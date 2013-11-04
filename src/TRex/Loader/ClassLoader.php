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
     * extension of php file
     */
    const FILE_EXTENSION = '.php';

    /**
     * unique instance of the current class
     * singleton pattern
     *
     * @var ClassLoader
     */
    private static $instance;

    /**
     * absolute path of common root
     *
     * @var string
     */
    private $basePath;

    /**
     * list of default vendors with their source path
     *
     * @var array
     */
    private $vendors = array(
        'TRex' => array(
            'sourcePath' => 'trex/src/',
        ),
        'TRexTests' => array(
            'sourcePath' => 'trex/tests/',
        ),
    );

    /**
     * get $instance
     *
     * @return ClassLoader
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            $className = get_called_class();
            self::$instance = new $className();
        }
        return self::$instance;
    }

    /**
     * ClassLoader is a singleton and can not be instantiate directly
     */
    private function __construct()
    {
    }

    /**
     * ClassLoader is a singleton and can not be clone directly
     */
    private function __clone()
    {
    }

    /**
     * start auto-loading of php classes
     *
     * @param array $vendors
     * @return bool
     */
    public function register(array $vendors = array())
    {
        $this->addVendors($vendors);
        return spl_autoload_register(array(self::getInstance(), 'load'));
    }

    /**
     * stop auto-loading of php classes
     *
     * @return bool
     */
    public function unRegister()
    {
        return spl_autoload_unregister(array(self::getInstance(), 'load'));
    }

    /**
     * load a php class
     *
     * @param string $className
     * @throws \Exception
     * @return mixed|null
     */
    public function load($className)
    {
        $classPath = $this->getClassPath($className);
        if (is_file($classPath)) {
            return include_once $classPath;
        }
        throw new \Exception(sprintf(
            'No file found for class %s with the path %s',
            $className,
            $classPath
        ), E_USER_ERROR);
    }

    /**
     * get the path of the file containing the class $className
     *
     * @param string $className
     * @return string
     */
    public function getClassPath($className)
    {
        $className = ltrim($className, '\\');
        $vendor = $this->extractVendor($className);
        if ($vendor) {
            if ($this->hasVendor($vendor)) {
                return $this->getRealPath($vendor) . $this->parseClassPath($className);
            }
            trigger_error(sprintf('Detected vendor %s was not recorded. Class %s.', $vendor, $className), E_USER_ERROR);
        }
        return $this->getBasePath() . $this->parseClassPath($className);
    }

    /**
     * indicate if a vendor has been already added
     *
     * @param string $vendorName
     * @return bool
     */
    public function hasVendor($vendorName)
    {
        return isset($this->vendors[$vendorName]);
    }

    /**
     * add vendor data
     *
     * @param string $name
     * @param string $sourcePath
     * @return bool
     */
    public function addVendor($name, $sourcePath)
    {
        if (!$this->hasVendor($name)) {
            $this->vendors[$name] = array(
                'sourcePath' => $this->normalizeSourcePath($sourcePath),
            );
            return true;
        }
        return false;
    }

    /**
     * add a list of vendor data
     * keys are names and values are source path
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
     * remove a vendor
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
     * get a vendor source path
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
     * get a vendor root dir
     * the root dir is the absolute path to the first directory of the source path
     *
     * @param string $vendorName
     * @return string
     */
    public function getRootDir($vendorName)
    {
        return $this->getPaths($vendorName, 'rootDir', array($this, 'resolveRootDir'));
    }

    /**
     * get a vendor real path
     * the real path is the absolute path to the source
     *
     * @param string $vendorName
     * @return string
     */
    public function getRealPath($vendorName)
    {
        return $this->getPaths($vendorName, 'realPath', array($this, 'resolveRealPath'));
    }

    /**
     * extract path dynamically
     *
     * @param $vendorName
     * @param $key
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
     * test if a source path is well formatted and normalize it.
     *
     * @param string $sourcePath
     * @return string
     */
    private function normalizeSourcePath($sourcePath)
    {
        if (substr($sourcePath, -1) !== DIRECTORY_SEPARATOR) {
            trigger_error(
                sprintf('Vendor source path must end with correct directory separator "%s".', DIRECTORY_SEPARATOR),
                E_USER_NOTICE
            );
            $sourcePath .= DIRECTORY_SEPARATOR;
        }
        return $sourcePath;
    }

    /**
     * resolve an absolute root dir to the first directory of $sourcePath
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
     * resolve an absolute path including $sourcePath
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
        return $this->getBasePath($sourcePath) . $sourcePath;
    }

    /**
     * extract the first directory of $path
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
        return '';
    }

    /**
     * extract the vendor of a class name
     *
     * @param $className
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
     * convert a class name in a file path
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
     * getter of $basePath
     *
     * @return string
     */
    private function getBasePath()
    {
        if (null === $this->basePath) {
            $this->setBasePath($this->buildBasePath());
        }
        return $this->basePath;
    }

    /**
     * setter of $basePath
     *
     * @param string $basePath
     */
    private function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * builder of $basePath
     *
     * @return string
     * @throws \DomainException
     */
    private function buildBasePath()
    {
        $matches = array();
        if (preg_match('/(.*?)trex/i', __DIR__, $matches)) { //todo: exception not unit tested
            return $matches[1];
        }
        throw new \DomainException(sprintf('%s must belong to TRex', __CLASS__));
    }

}
