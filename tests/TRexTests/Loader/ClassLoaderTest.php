<?php
namespace TRexTests\Loader;

use TRex\Loader\ClassLoader;

/**
 * Class ClassLoaderTest
 * @package TRexTests\Loader
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * has an undefined vendor
     *
     * @return array
     */
    public function testHasVendorNotAdded()
    {
        $provider = array(
            'classLoader' => new ClassLoader(),
            'name' => 'Vendor',
            'sourcePath' => sprintf('vendor%ssrc%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),
            'realPath' => $this->getBaseDir(sprintf('vendor%ssrc', DIRECTORY_SEPARATOR)),
            'rootDir' => $this->getBaseDir('vendor'),
        );
        $this->assertFalse($provider['classLoader']->hasVendor($provider['name']));
        return $provider;
    }

    /**
     * get an undefined vendor source path
     *
     * @depends testHasVendorNotAdded
     */
    public function testGetSourcePathNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getSourcePath($provider['name']));
        return $provider;
    }

    /**
     * get an undefined vendor root dir
     *
     * @depends testGetSourcePathNotAdded
     */
    public function testGetRootDirNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getRootDir($provider['name']));
        return $provider;
    }

    /**
     * get an undefined vendor real path
     *
     * @depends testGetRootDirNotAdded
     */
    public function testGetRealPathNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getRealPath($provider['name']));
        return $provider;
    }

    /**
     * remove an undefined vendor
     *
     * @depends testGetRealPathNotAdded
     */
    public function testRemoveVendorNotExisting(array $provider)
    {
        $this->assertFalse($provider['classLoader']->removeVendor($provider['name']));
        return $provider;
    }

    /**
     * add a vendor for the first time
     *
     * @depends testGetSourcePathNotAdded
     */
    public function testAddVendorFirst(array $provider)
    {
        $this->assertTrue($provider['classLoader']->addVendor($provider['name'], $provider['sourcePath']));
        return $provider;
    }

    /**
     * add a same vendor for the second time
     *
     * @depends testAddVendorFirst
     */
    public function testAddVendorSecond(array $provider)
    {
        $this->assertFalse($provider['classLoader']->addVendor($provider['name'], $provider['sourcePath']));
        return $provider;
    }

    /**
     * added source path can be relative
     */
    public function testAddVendorWithRelativePath()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue(
            $classLoader->addVendor(
                __FUNCTION__,
                sprintf('..%s%s%sPath%s', DIRECTORY_SEPARATOR, __FUNCTION__, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR)
            )
        );
    }

    /**
     * get a vendor source path witch has been added without an ending DIRECTORY_SEPARATOR
     *
     * @expectedException \PHPUnit_Framework_Error_Notice
     * @expectedExceptionMessage Path must end with correct directory separator
     */
    public function testGetSourcePathWithoutSlash()
    {
        $classLoader = new ClassLoader();
        $provider = array(
            'name' => __FUNCTION__,
            'sourcePath' => sprintf('%s%sPath', __FUNCTION__, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR)
        );
        $this->assertTrue($classLoader->addVendor($provider['name'], $provider['sourcePath']));
        $this->assertSame(
            $provider['sourcePath'] . DIRECTORY_SEPARATOR,
            $classLoader->getSourcePath($provider['name'])
        );
    }

    /**
     * has an existing vendor
     *
     * @depends testAddVendorFirst
     */
    public function testHasVendorAfterAdd(array $provider)
    {
        $this->assertTrue($provider['classLoader']->hasVendor($provider['name']));
        return $provider;
    }

    /**
     * get a vendor source path
     *
     * @depends testHasVendorAfterAdd
     */
    public function testGetSourcePathAfterAdd(array $provider)
    {
        $this->assertSame(
            $provider['sourcePath'],
            $provider['classLoader']->getSourcePath($provider['name'])
        );
        return $provider;
    }

    /**
     * get a vendor root dir
     *
     * @depends testGetSourcePathAfterAdd
     */
    public function testGetRootDirAfterAdd(array $provider)
    {
        $this->assertSame(
            $provider['rootDir'],
            $provider['classLoader']->getRootDir($provider['name'])
        );
        return $provider;
    }

    /**
     * get a vendor real path
     *
     * @depends testGetRootDirAfterAdd
     */
    public function testGetRealPathAfterAdd(array $provider)
    {
        $this->assertSame(
            $provider['realPath'],
            $provider['classLoader']->getRealPath($provider['name'])
        );
        return $provider;
    }

    /**
     * remove a vendor
     *
     * @depends testGetRealPathAfterAdd
     */
    public function testRemoveVendorExisting(array $provider)
    {
        $this->assertTrue($provider['classLoader']->removeVendor($provider['name']));
        return $provider;
    }

    /**
     * has a removed vendor
     *
     * @depends testRemoveVendorExisting
     */
    public function testHasVendorAfterRemove(array $provider)
    {
        $this->assertFalse($provider['classLoader']->hasVendor($provider['name']));
        return $provider;
    }

    /**
     * add a list of vendors
     */
    public function testAddVendors()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue(
            $classLoader->addVendors(
                array(
                    sprintf('%s1', __FUNCTION__) => sprintf(
                        '%s1%sPath%s',
                        __FUNCTION__,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    ),
                    sprintf('%s2', __FUNCTION__) => sprintf(
                        '%s2%sPath%s',
                        __FUNCTION__,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    ),
                )
            )
        );

        $this->assertTrue($classLoader->hasVendor(sprintf('%s1', __FUNCTION__)));
        $this->assertTrue($classLoader->hasVendor(sprintf('%s2', __FUNCTION__)));

    }

    /**
     * add the same vendor twice
     */
    public function testAddVendorsWithDouble()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue(
            $classLoader->addVendors(
                array(
                    sprintf('%s', __FUNCTION__) => sprintf(
                        '%s%sPath%s',
                        __FUNCTION__,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    ),
                    sprintf('%s', __FUNCTION__) => sprintf(
                        '%s%sPath%s',
                        __FUNCTION__,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    ),
                )
            )
        );
    }

    /**
     * test the default config with TRex path
     */
    public function testGetSourcePathDefault()
    {
        $classLoader = new ClassLoader();
        $this->assertSame('trex/src/', $classLoader->getSourcePath('TRex'));
        $this->assertSame('trex/tests/', $classLoader->getSourcePath('TRexTests'));
    }

    /**
     * test the default config with TRex root dir
     */
    public function testGetRootDirDefault()
    {
        $classLoader = new ClassLoader();
        $this->assertSame($this->getBaseDir('trex'), $classLoader->getRootDir('TRex'));
        $this->assertSame($this->getBaseDir('trex'), $classLoader->getRootDir('TRexTests'));
    }

    /**
     * test the conversion of a class path
     *
     * @param string $className
     * @param string $path
     *
     * @dataProvider provideClassPaths
     */
    public function testGetClassPath($className, $path)
    {
        $classLoader = new ClassLoader();
        $classLoader->addVendor(
            'Vendor',
            sprintf('vendor%ssrc%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR)
        );
        $this->assertSame($path, $classLoader->getClassPath($className));
    }

    /**
     * test the conversion of a class path with a vendor not added before.
     */
    public function testGetClassPathWithNotAddedVendor()
    {
        $classLoader = new ClassLoader();
        $this->assertSame('', $classLoader->getClassPath('Vendor2\ClassName'));
    }

    /**
     * test the load of a class file
     */
    public function testLoadOk()
    {
        $classLoader = new ClassLoader();
        $this->assertSame('Foo_test', $classLoader->load('TRexTests\Loader\resources\Foo'));
    }

    /**
     * test the load of a class file when there is no such file
     *
     * @expectedException \Exception
     * @expectedExceptionMessage No file found for class TRexTests\Loader\resources\None with the path
     */
    public function testLoadKoWithError()
    {
        $classLoader = new ClassLoader(true);
        $this->assertSame(null, $classLoader->load('TRexTests\Loader\resources\None'));
    }

    /**
     * test the load of a class file when there is no such file, but error is muted.
     */
    public function testLoadKoWithoutError()
    {
        $classLoader = new ClassLoader();
        $this->assertSame(null, $classLoader->load('TRexTests\Loader\resources\None'));
    }

    /**
     * tests functions not throwing exception
     *
     * @param string $functionName
     * @param array $args
     *
     * @dataProvider provideFunctionNames
     */
    public function testLoadFunctionExceptions($functionName, array $args)
    {
        $this->assertFalse(call_user_func_array($functionName, $args));
    }

    /**
     * test activation of autoloading
     *
     */
    public function testRegister()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue($classLoader->register());
        return $classLoader;
    }

    /**
     * test deactivation of autoloading
     *
     * @depends testRegister
     */
    public function testUnRegister(ClassLoader $classLoader)
    {
        $this->assertTrue($classLoader->unRegister());
    }

    /**
     * test setter and getter of $basePath
     *
     */
    public function testSetBasePath()
    {
        $classLoader = new ClassLoader();
        $basePath = $classLoader->getBasePath();
        $classLoader->setBasePath('test' . DIRECTORY_SEPARATOR);
        $this->assertSame('test' . DIRECTORY_SEPARATOR, $classLoader->getBasePath());
        $classLoader->setBasePath($basePath);
    }

    /**
     * test setter and getter of $basePath without an ending directory separator
     *
     * @expectedException \PHPUnit_Framework_Error_Notice
     * @expectedExceptionMessage Path must end with correct directory separator
     */
    public function testSetBasePathWithoutDireSeparator()
    {
        $classLoader = new ClassLoader();
        $basePath = $classLoader->getBasePath();
        $classLoader->setBasePath('test');
        $this->assertSame('test' . DIRECTORY_SEPARATOR, $classLoader->getBasePath());
        $classLoader->setBasePath($basePath);
    }

    /**
     * real path and root dir are impacted by a new base path
     */
    public function testRealPathWithNewBasePath()
    {
        $classLoader = new ClassLoader();
        $basePath = $classLoader->getBasePath();
        $classLoader->setBasePath(str_replace('/', DIRECTORY_SEPARATOR, '/specific/base/path/'));
        $classLoader->addVendor(__FUNCTION__, str_replace('/', DIRECTORY_SEPARATOR, 'lib/src/'));
        $this->assertSame(
            str_replace('/', DIRECTORY_SEPARATOR, '/specific/base/path/lib/src/'),
            $classLoader->getRealPath(__FUNCTION__)
        );
        $classLoader->setBasePath($basePath);
    }

    /**
     * provide a list of functions not throwing exception
     *
     * @return array
     */
    public function provideFunctionNames()
    {
        return array(
            array('class_exists', array('TRexTests\Loader\resources\None')),
            array('get_parent_class', array('TRexTests\Loader\resources\None')),
            array('interface_exists', array('TRexTests\Loader\resources\None')),
            array('is_subclass_of', array(new \stdClass(), 'TRexTests\Loader\resources\None')),
            array('is_a', array(new \stdClass(), 'TRexTests\Loader\resources\None')),
        );
    }

    /**
     * return the root dir for $dir
     *
     * @param $dir
     * @return string
     */
    private function getBaseDir($dir)
    {
        return $this->getFilePath($dir . DIRECTORY_SEPARATOR);
    }

    /**
     * return the path for $file
     *
     * @param $file
     * @return string
     */
    private function getFilePath($file)
    {
        return realpath(__DIR__ . '/../../../..') . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * provide class paths for test
     *
     * @return array
     */
    public function provideClassPaths()
    {
        return array(
            array(
                'ClassName',
                '' //only class with vendor
            ),
            array(
                '\ClassName',
                '' //only class with vendor
            ),
            array(
                'Vendor\ClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
            array(
                '\Vendor\ClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
            array(
                'Vendor\VendorClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sVendorClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
            array(
                'Vendor_ClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
            array(
                '\Vendor_ClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
            array(
                'Vendor_VendorClassName',
                $this->getFilePath(
                    sprintf(
                        'vendor%ssrc%sVendor%sVendorClassName.php',
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR,
                        DIRECTORY_SEPARATOR
                    )
                )
            ),
        );
    }
}
