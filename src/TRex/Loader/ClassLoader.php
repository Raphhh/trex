<?php
namespace TRex\Loader;

/**
 * ClassLoader loads the file of a php class.
 * PSR-0 autoloader.
 *
 * @package TRex\Loader
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ClassLoader
{

    /**
     * Extension of PHP file.
     */
    const FILE_EXTENSION = '.php';

    /**
     * Common root of all paths.
     *
     * @var string
     */
    private $basePath = '';

    /**
     * Indicates whether self::load displays an exception.
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

    /**
     * Constructor.
     *
     * @param bool $isErrorDisplayed
     */
    public function __construct($isErrorDisplayed = false)
    {
        $this->setErrorDisplayed($isErrorDisplayed);
    }

    /**
     * Starts auto-loading of php classes.
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
     * Stops auto-loading of php classes.
     *
     * @return bool
     */
    public function unRegister()
    {
        return spl_autoload_unregister(array($this, 'load'));
    }

    /**
     * Loads a php class.
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
                sprintf('No file found for class %s with the path %s', $className, $classPath),
                E_USER_ERROR
            );
        }
        return null;
    }

    /**
     * Gets the path of the file containing the class $className.
     * If the class has a no vendor or a vendor not recoded, a empty string will be returned.
     *
     * @param string $className
     * @return string
     */
    public function getClassPath($className)
    {
        $className = $this->normalizeClassName($className);
        $vendorName = $this->extractVendorName($className);
        if ($this->hasVendor($vendorName)) {
            return $this->getRealPath($vendorName) . $this->parseClassPath($className);
        }
        return '';
    }

    /**
     * Indicates whether a vendor has been already added.
     *
     * @param string $vendorName
     * @return bool
     */
    public function hasVendor($vendorName)
    {
        return isset($this->vendors[$vendorName]);
    }

    /**
     * Adds vendor data.
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
     * Add sa list of vendor data.
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
     * Removes a vendor.
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
     * Gets a vendor source path.
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
     * Gets a vendor root dir.
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
     * Gets a vendor real path.
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
     * Getter of the common root of all paths.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Setter of the common root of all paths.
     *
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $this->normalizePath($basePath);
    }

    /**
     * Indicates whether self::load displays an exception.
     *
     * @return boolean
     */
    public function isErrorDisplayed()
    {
        return $this->isErrorDisplayed;
    }

    /**
     * Sets the display of exception for self::load.
     *
     * @param boolean $isErrorDisplayed
     */
    public function setErrorDisplayed($isErrorDisplayed)
    {
        $this->isErrorDisplayed = (boolean)$isErrorDisplayed;
    }

    /**
     * Extracts vendor paths dynamically.
     *
     * @param string $vendorName
     * @param string $key
     * @param callable $callback
     * @return string
     */
    private function getPaths($vendorName, $key, callable $callback)
    {
        if ($this->hasVendor($vendorName)) {
            if (!isset($this->vendors[$vendorName][$key])) {
                $this->vendors[$vendorName][$key] = call_user_func($callback, $this->getSourcePath($vendorName));
            }
            return $this->vendors[$vendorName][$key];
        }
        return '';
    }

    /**
     * Formats a path.
     * The path will ends with a directory separator.
     *
     * @param string $path
     * @return string
     */
    private function normalizePath($path)
    {
        return rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
    }

    /**
     * Formats a class name.
     * All classes will be resolved from the root namespace separator.
     *
     * @param $className
     * @return string
     */
    private function normalizeClassName($className)
    {
        return ltrim($className, '\\');
    }

    /**
     * Resolves an absolute root dir to the first directory of $basePath and $sourcePath.
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
     * Resolves an absolute path including $basePath and $sourcePath.
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
     * Extracts the first directory of $path.
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
        if (preg_match('#(.*?)(/|\\\)#', $path, $matches)) { //extracts first word before "\" or "/".
            return $matches[1] . DIRECTORY_SEPARATOR;
        }
        return ''; //this case does not normally happen, because self::normalizePath add to $path a dir separator.
    }

    /**
     * Extracts the vendor name of a class name.
     *
     * @param string $className
     * @return string
     */
    private function extractVendorName($className)
    {
        $matches = array();
        if (preg_match('#(.*?)(/|\\\|_)#', $className, $matches)) { //extracts first word before "\" or "_".
            return $matches[1];
        }
        return '';
    }

    /**
     * Converts a class name in a file path.
     * Handle two format:
     *     - format with underscore as separator: Vendor_Package_Class.
     *     - format with namespace separator: Vendor\Package\Class.
     * Class name must not start with namespace separator, or the path will start with a directory separator.
     *
     * @param $className
     * @return string
     */
    private function parseClassPath($className)
    {
        if (strpos($className, '_') !== false) { //Vendor_Package_Class
            return strtr($className, '_', DIRECTORY_SEPARATOR) . self::FILE_EXTENSION;
        } else { //Vendor\Package\Class
            return strtr($className, '\\', DIRECTORY_SEPARATOR) . self::FILE_EXTENSION;
        }
    }

    /**
     * Indicates whether the calling context requires to display error.
     *
     * @return bool
     */
    private function hasToDisplayError()
    {
        $backTraceData = $this->getBackTraceData();
        return !(
            isset($backTraceData['function'])
            && in_array($backTraceData['function'], $this->getExcludedFunctionNames(), true)
        );
    }

    /**
     * Returns the calling context.
     *
     * @return array
     */
    private function getBackTraceData()
    {
        $backTraces = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($backTraces as $i => $backTrace) {
            if (isset($backTrace['function']) && $backTrace['function'] === 'spl_autoload_call') {
                //we are at the level of autoload.
                if (isset($backTraces[$i + 1])) {
                    return $backTraces[$i + 1]; //The index following has the context of the autoload call.
                }
                break;
            }
        }
        return array();
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
