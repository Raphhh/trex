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
            'src' => 'trex/src/',
        ),
        'TRexTests' => array(
            'src' => 'trex/tests/',
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
                'src' => $this->normalizeSourcePath($sourcePath),
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
            return $this->vendors[$vendorName]['src'];
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
}
