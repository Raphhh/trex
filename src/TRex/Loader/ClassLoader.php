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
     * unique instance of the current class
     * singleton pattern
     *
     * @var ClassLoader
     */
    private static $instance;

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
     * @param $vendorName
     * @return string
     */
    public function getRootDir($vendorName)
    {
        if ($this->hasVendor($vendorName)) {
            if (!isset($this->vendors[$vendorName]['rootDir'])) { //todo: cache not unit tested
                $this->vendors[$vendorName]['rootDir'] = $this->resolveRootDir($this->getSourcePath($vendorName));
            }
            return $this->vendors[$vendorName]['rootDir'];
        }
        return '';
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
     *
     * test if a source path is well formatted and normalize it.
     *
     * @param string $sourcePath
     * @return string
     * @throws \InvalidArgumentException
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
     * @throws \DomainException
     * @return string
     */
    private function resolveRootDir($sourcePath)
    {
        $matches = array();
        if (preg_match('/(.*?)trex/i', __DIR__, $matches)) { //todo: exception not unit tested
            return $matches[1] . $this->extractBaseDir($sourcePath);
        }
        throw new \DomainException(sprintf('%s must belong to TRex', __CLASS__));
    }

    /**
     * extract the first directory of $path
     *
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
}
