<?php
namespace TRex\Loader;

/**
 * Class ClassLoaderTest
 * @package TRex\Loader
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
            'realPath' => sprintf('vendor%ssrc%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),
            'rootDir' => sprintf('vendor%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),
        );
        $this->assertFalse($provider['classLoader']->hasVendor($provider['name']));
        return $provider;
    }

    /**
     * gets an undefined vendor source path
     *
     * @depends testHasVendorNotAdded
     */
    public function testGetSourcePathNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getSourcePath($provider['name']));
        return $provider;
    }

    /**
     * gets an undefined vendor root dir
     *
     * @depends testGetSourcePathNotAdded
     */
    public function testGetRootDirNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getRootDir($provider['name']));
        return $provider;
    }

    /**
     * gets an undefined vendor real path
     *
     * @depends testGetRootDirNotAdded
     */
    public function testGetRealPathNotAdded(array $provider)
    {
        $this->assertSame('', $provider['classLoader']->getRealPath($provider['name']));
        return $provider;
    }

    /**
     * removes an undefined vendor
     *
     * @depends testGetRealPathNotAdded
     */
    public function testRemoveVendorNotExisting(array $provider)
    {
        $this->assertFalse($provider['classLoader']->removeVendor($provider['name']));
        return $provider;
    }

    /**
     * adds a vendor for the first time
     *
     * @depends testGetSourcePathNotAdded
     */
    public function testAddVendorFirst(array $provider)
    {
        $this->assertTrue($provider['classLoader']->addVendor($provider['name'], $provider['sourcePath']));
        return $provider;
    }

    /**
     * adds a same vendor for the second time
     *
     * @depends testAddVendorFirst
     */
    public function testAddVendorSecond(array $provider)
    {
        $this->assertFalse($provider['classLoader']->addVendor($provider['name'], $provider['sourcePath']));
        return $provider;
    }

    /**
     * gets a vendor source path which has been added without an ending DIRECTORY_SEPARATOR.
     */
    public function testGetSourcePathWithoutSlash()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue($classLoader->addVendor(__FUNCTION__, 'foo'));
        $this->assertSame(
            'foo' . DIRECTORY_SEPARATOR,
            $classLoader->getSourcePath(__FUNCTION__)
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
     * gets a vendor source path
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
     * gets a vendor root dir
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
     * gets a vendor real path
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
     * removes a vendor
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
     * adds a list of vendors
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
     * adds the same vendor twice
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
     * tests the conversion of a class path
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
     * tests the conversion of a class path with a vendor not added before.
     */
    public function testGetClassPathWithNotAddedVendor()
    {
        $classLoader = new ClassLoader();
        $this->assertSame('', $classLoader->getClassPath('Vendor2\ClassName'));
    }

    /**
     * tests the load of a class file
     */
    public function testLoadOk()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue(
            $classLoader->addVendor(
                'TRex',
                $this->getFilePath('tests' . DIRECTORY_SEPARATOR)
            )
        );
        $this->assertSame(
            'Foo_test',
            $classLoader->load('TRex\Loader\resources\Foo'),
            sprintf('Class not found at "%s"', $classLoader->getClassPath('TRex\Loader\resources\Foo'))
        );
        return $classLoader;
    }

    /**
     * tests the load of a class file when there is no such file, but error is muted.
     *
     * @depends testLoadOk
     */
    public function testLoadKoWithoutError(ClassLoader $classLoader)
    {
        $this->assertNull($classLoader->load('TRex\Loader\resources\None'));
        return $classLoader;
    }

    /**
     * tests the load of a class file when there is no such file
     *
     * @depends testLoadKoWithoutError
     *
     * @expectedException \Exception
     * @expectedExceptionMessage No file found for class TRex\Loader\resources\None with the path
     */
    public function testLoadKoWithError(ClassLoader $classLoader)
    {
        $classLoader->register();
        $classLoader->setErrorDisplayed(true);
        $this->assertNull($classLoader->load('TRex\Loader\resources\None'));
        return $classLoader;
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
        $classLoader = new ClassLoader();
        $classLoader->register();
        $classLoader->setErrorDisplayed(true);
        $this->assertFalse(call_user_func_array($functionName, $args));
        $classLoader->unRegister();
        unset($classLoader);
    }

    /**
     * tests activation of autoloading
     *
     */
    public function testRegister()
    {
        $classLoader = new ClassLoader();
        $this->assertTrue($classLoader->register());
        return $classLoader;
    }

    /**
     * tests deactivation of autoloading
     *
     * @depends testRegister
     */
    public function testUnRegister(ClassLoader $classLoader)
    {
        $this->assertTrue($classLoader->unRegister());
    }

    /**
     * tests setter and getter of $basePath
     *
     */
    public function testSetBasePath()
    {
        $classLoader = new ClassLoader();
        $classLoader->setBasePath('\test/');
        $this->assertSame('\test' . DIRECTORY_SEPARATOR, $classLoader->getBasePath());
    }

    /**
     * tests setter and getter of $basePath without an ending directory separator
     */
    public function testSetBasePathWithoutDirSeparator()
    {
        $classLoader = new ClassLoader();
        $classLoader->setBasePath('\test');
        $this->assertSame('\test' . DIRECTORY_SEPARATOR, $classLoader->getBasePath());
    }

    /**
     * real path and root dir are impacted by a new base path
     */
    public function testRealPathWithNewBasePath()
    {
        $classLoader = new ClassLoader();
        $classLoader->setBasePath('foo' . DIRECTORY_SEPARATOR);
        $classLoader->addVendor(__FUNCTION__, 'bar' . DIRECTORY_SEPARATOR);
        $this->assertSame(
            'foo' . DIRECTORY_SEPARATOR . 'bar' . DIRECTORY_SEPARATOR,
            $classLoader->getRealPath(__FUNCTION__)
        );
    }

    /**
     * provides a list of functions not throwing exception
     *
     * @return array
     */
    public function provideFunctionNames()
    {
        return array(
            array('class_exists', array('TRex\Loader\resources\None')),
            array('get_parent_class', array('TRex\Loader\resources\None')),
            array('interface_exists', array('TRex\Loader\resources\None')),
            array('is_subclass_of', array(new \stdClass(), 'TRex\Loader\resources\None')),
            array('is_a', array(new \stdClass(), 'TRex\Loader\resources\None')),
        );
    }

    /**
     * returns the path for $file
     *
     * @param $file
     * @return string
     */
    private function getFilePath($file)
    {
        return realpath(__DIR__ . '/../../..') . DIRECTORY_SEPARATOR . $file;
    }

    /**
     * provides class paths for test
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
                sprintf(
                    'vendor%ssrc%sVendor%sClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
            array(
                '\Vendor\ClassName',
                sprintf(
                    'vendor%ssrc%sVendor%sClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
            array(
                'Vendor\VendorClassName',
                sprintf(
                    'vendor%ssrc%sVendor%sVendorClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
            array(
                'Vendor_ClassName',
                sprintf(
                    'vendor%ssrc%sVendor%sClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
            array(
                '\Vendor_ClassName',
                sprintf(
                    'vendor%ssrc%sVendor%sClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
            array(
                'Vendor_VendorClassName',
                sprintf(
                    'vendor%ssrc%sVendor%sVendorClassName.php',
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR,
                    DIRECTORY_SEPARATOR
                )
            ),
        );
    }
}
