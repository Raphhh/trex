<?php
namespace TRex\Loader;

/**
 * Class ClassLoader
 *
 * load the file of a php class
 * PSR-0 autoloader
 *
 * @package TRex\Loader
 */
class ClassLoader
{

    /**
     * Extension of PHP file.
     */
    const FILE_EXTENSION = '.php';

    /**
     * Absolute path of common root.
     *
     * @var string
     */
    private $basePath;

    /**
     * Indiquates if self::load displays an exception.
     *
     * @var bool
     */
    private $isErrorDisplayed;

    /**
     * List of vendors with their source path.
     *
     * @var array
     */
    private $vendors = array();

    /*
     * List of functions not throwing exception.
     *
     * @var array
     */
    private $excludedFunctionNames = array(
        'class_exists',
        'get_parent_class',
        'interface_exists',
        'is_subclass_of',
        'is_a',
    );

    public function __construct($isErrorDisplayed = false)
    {
        $this->setIsErrorDisplayed($isErrorDisplayed);
    }

    /**
     * Setter of $isErrorDisplayed
     *
     * @param boolean $isErrorDisplayed
     */
    public function setIsErrorDisplayed($isErrorDisplayed)
    {
        $this->isErrorDisplayed = (boolean)$isErrorDisplayed;
    }

    /**
     * Getter of $isErrorDisplayed
     *
     * @return boolean
     */
    public function isErrorDisplayed()
    {
        return $this->isErrorDisplayed;
    }


    /**
     * Start auto-loading of php classes.
     * Call automatically self::load when a new class is used.
     *
     * @param array $vendors
     * @return bool
     */
    public function register(array $vendors = array())
    {
        $this->addVendors($vendors);
        return spl_autoload_register(array($this, 'load'));
    }

    /**
     * Stop auto-loading of php classes.
     *
     * @return bool
     */
    public function unRegister()
    {
        return spl_autoload_unregister(array($this, 'load'));
    }

    /**
     * Load a php class.
     * If no class is founded, a exception is thrown.
     * Return the result of the included file of null if no file included.
     *
     * @param string $className
     * @throws \Exception
     * @return mixed|null
     */
    public function load($className)
    {
        $classPath = $this->getClassPath($className);
        if ($classPath && is_file($classPath)) {
            return include_once $classPath;

        } elseif ($this->isErrorDisplayed() && $this->hasToDisplayError()) {
            throw new \Exception(
                sprintf(
                    'No file found for class %s with the path %s',
                    $className,
                    $classPath
                ),
                E_USER_ERROR
            );
        }
        return null;
    }

    /**
     * Get the path of the file containing the class $className.
     * If the class has a no vendor or a vendor not recoded, a empty string will be returned.
     *
     * @param string $className
     * @return string
     */
    public function getClassPath($className)
    {
        $className = ltrim($className, '\\');
        $vendor = $this->extractVendor($className);
        if ($this->hasVendor($vendor)) {
            return $this->getRealPath($vendor) . $this->parseClassPath($className);
        }
        return '';
    }

    /**
     * Indicate if a vendor has been already added.
     *
     * @param string $vendorName
     * @return bool
     */
    public function hasVendor($vendorName)
    {
        return isset($this->vendors[$vendorName]);
    }

    /**
     * Add vendor data.
     *
     * @param string $name
     * @param string $sourcePath
     * @return bool
     */
    public function addVendor($name, $sourcePath)
    {
        if (!$this->hasVendor($name)) {
            $this->vendors[$name] = array(
                'sourcePath' => $this->normalizePath($sourcePath),
            );
            return true;
        }
        return false;
    }

    /**
     * Add a list of vendor data.
     * Keys are names and values are source path;
     * See self::addVendor().
     *
     * @param array $vendors
     * @return bool
     */
    public function addVendors(array $vendors)
    {
        $result = 1;
        foreach ($vendors as $vendor => $sourcePath) {
            $result &= $this->addVendor($vendor, $sourcePath);
        }
        return (bool)$result;
    }

    /**
     * Remove a vendor.
     *
     * @param string $vendorName
     * @return bool
     */
    public function removeVendor($vendorName)
    {
        if ($this->hasVendor($vendorName)) {
            unset($this->vendors[$vendorName]);
            return true;
        }
        return false;
    }

    /**
     * Get a vendor source path.
     *
     * @param string $vendorName
     * @return string
     */
    public function getSourcePath($vendorName)
    {
        if ($this->hasVendor($vendorName)) {
            return $this->vendors[$vendorName]['sourcePath'];
        }
        return '';
    }

    /**
     * Get a vendor root dir.
     * The root dir is the absolute path to the first directory of the source path.
     *
     * @param string $vendorName
     * @return string
     */
    public function getRootDir($vendorName)
    {
        return $this->getPaths($vendorName, 'rootDir', array($this, 'resolveRootDir'));
    }

    /**
     * Get a vendor real path.
     * The real path is the absolute path to the source.
     *
     * @param string $vendorName
     * @return string
     */
    public function getRealPath($vendorName)
    {
        return $this->getPaths($vendorName, 'realPath', array($this, 'resolveRealPath'));
    }

    /**
     * Getter of $basePath.
     *
     * @return string
     */
    public function getBasePath()
    {
        if (null === $this->basePath) {
            $this->setBasePath($this->buildBasePath());
        }
        return $this->basePath;
    }

    /**
     * Setter of $basePath.
     *
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $this->normalizePath($basePath);
    }

    /**
     * Extract vendor paths dynamically.
     *
     * @param string $vendorName
     * @param string $key
     * @param callable $callback
     * @return string
     */
    private function getPaths($vendorName, $key, callable $callback)
    {
        if ($this->hasVendor($vendorName)) {
            if (!isset($this->vendors[$vendorName][$key])) { //todo: cache not unit tested
                $this->vendors[$vendorName][$key] = call_user_func($callback, $this->getSourcePath($vendorName));
            }
            return $this->vendors[$vendorName][$key];
        }
        return '';
    }

    /**
     * Test if a path is well formatted and normalize it.
     *
     * @param string $path
     * @return string
     */
    private function normalizePath($path)
    {
        if (substr($path, -1) !== DIRECTORY_SEPARATOR) {
            trigger_error(
                sprintf('Path must end with correct directory separator "%s".', DIRECTORY_SEPARATOR),
                E_USER_NOTICE
            );
            $path .= DIRECTORY_SEPARATOR;
        }
        return $path;
    }

    /**
     * Resolve an absolute root dir to the first directory of $sourcePath.
     *
     * ex:
     * trex/src => /absolute/path/to/trex/
     *
     * @param string $sourcePath
     * @return string
     */
    private function resolveRootDir($sourcePath)
    {
        return $this->getBasePath() . $this->extractBaseDir($sourcePath);
    }

    /**
     * Resolve an absolute path including $sourcePath.
     *
     * ex:
     * trex/src => /absolute/path/to/trex/src/
     *
     * @param string $sourcePath
     * @return string
     * @throws \DomainException
     */
    private function resolveRealPath($sourcePath)
    {
        return $this->getBasePath() . $sourcePath;
    }

    /**
     * Extract the first directory of $path.
     *
     * ex:
     * trex/src => trex/
     *
     * @param string $path
     * @return string
     */
    private function extractBaseDir($path)
    {
        $matches = array();
        if (preg_match('#(.*?)(/|\\\)#', $path, $matches)) { //TODO: or simply strpos($path, DIRECTORY_SEPARATOR)?
            return $matches[1] . DIRECTORY_SEPARATOR;
        }
        return ''; //this case does not normally happen, because self::normalizePath add to $path (which is the source path of a vendor) a directory separator.
    }

    /**
     * Extract the vendor of a class name.
     *
     * @param string $className
     * @return string
     */
    private function extractVendor($className)
    {
        $matches = array();
        if (preg_match('#(.*?)(/|\\\|_)#', $className, $matches)) {
            return $matches[1];
        }
        return '';
    }

    /**
     * Convert a class name in a file path.
     *
     * @param $className
     * @return string
     */
    private function parseClassPath($className)
    {
        if (strpos($className, '_') !== false) {
            return strtr($className, '_', DIRECTORY_SEPARATOR) . self::FILE_EXTENSION;
        } else {
            return strtr($className, '\\', DIRECTORY_SEPARATOR) . self::FILE_EXTENSION;
        }
    }

    /**
     * Indicate if the calling context requires to display error.
     *
     * @return bool
     */
    private function hasToDisplayError()
    {
        $backTraceData = $this->getBackTraceData();
        return !(isset($backTraceData['function']) && in_array($backTraceData['function'], $this->getExcludedFunctionNames(), true));
    }

    /**
     * Return the calling context.
     *
     * @return array
     */
    private static function getBackTraceData()
    {
        $backTraces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($backTraces as $i => $backTrace) {
            if (isset($backTrace['function']) && $backTrace['function'] === 'spl_autoload_call') { //we are at the level of autoload.
                if (isset($backTraces[$i + 1])) {
                    return $backTraces[$i + 1]; //The index following has the context of the autoload call.
                }
                break;
            }
        }
        return array();
    }

    /**
     * Builder of $basePath.
     *
     * @return string
     * @throws \DomainException
     * @todo not unit tested
     */
    private function buildBasePath()
    {
        $matches = array();
        if (preg_match('/(.*?)trex/i', __DIR__, $matches)) {
            return $matches[1];
        }
        throw new \DomainException(sprintf('%s must belong to TRex', __CLASS__));
    }

    /**
     * Getter of $excludedFunctionNames.
     *
     * @return array
     */
    private function getExcludedFunctionNames()
    {
        return $this->excludedFunctionNames;
    }
}
