# TRex\Loader\ClassLoader

TRex\Loader\ClassLoader, as its name suggests, is a PSR-0 class (auto-)loader.

## Active class auto-loader

By activating auto-loader, TRex\Loader\ClassLoader will include the file containing your class.

```php
$classLoader->register();
```

You can stop auto-loading when you want.

```php
$classLoader->unRegister();
```

## Load class

You can ask to TRex\Loader\ClassLoader to load a specific class.

```php
$classLoader->load('Vendor\Package\Class');
```

See how to add a vendor if you want to use it for a specific vendor class.

## Resolve path

TRex\Loader\ClassLoader can resolve the root directory and real source path of a vendor. The root directory is the path to the directory containing a vendor package. The real path is the absolute path to the source.

```php
$classLoader->getRootDir('Vendor'); //$ROOT_DIR
$classLoader->getRealPath('Vendor'); //$ROOT_DIR/src/
```

This class can also resolve the path of a class file.

```php
$classLoader->getClassPath('Vendor\Package\Class'); //$ROOT_DIR/src/Vendor/Package/Class
```

See how to add a vendor if you want to use it for a specific vendor class.

## Add vendor

By adding a vendor, you can use these features for other PHP library.

### How to add a vendor?

There is three ways to add your personal vendors.

```php
//1. add vendors when your register auto-loading
$classLoader->register(
    array(
        'VendorName1' => 'path/to/src1/',
        'VendorName2' => 'path/to/src2/',
        ...
    )
);
```
```php
//2. add vendors one by one for all the features
$classLoader->addVendor('VendorName1', 'path/to/src1/');
$classLoader->addVendor('VendorName2', 'path/to/src2/');
...
```
```php
//3. add a list of vendors for all the features
$classLoader->addVendors(
    array(
        'VendorName1' => 'path/to/src1',
        'VendorName2' => 'path/to/src2'
    )
);
```

You can ask if a vendor is already added.

```php
$classLoader->hasVendor('Vendor'); //bool true if already added
```

You can get a vendor source path and root dir.

```php
$classLoader->getSourcePath('Vendor'); // "library/path/to/src/"
$classLoader->getRootDir('Vendor'); // "$ROOT_DIR/library/"
$classLoader->getRealPath('Vendor'); // "$ROOT_DIR/library/path/to/src/"
```

You can remove a vendor.

```php
$classLoader->removeVendor('Vendor');
```

### How to compose vendor data?

#### Vendor name
The vendor name is the common namespace of a library packages. In PSR-0, class name refers to it trough a namespace or un underscore separator:

```php
Vendor\Package\Class
Vendor_Package_Class
```

Vendor name and library name must be directories with an identical name. ClassName must be a file with an identical name and a *.php* extension.

See PSR-0 for complete specifications.

### How a vendor path will be resolved?

When you add a vendor, you will have the following behavior:

```php
TRex\Loader\ClassLoader::getInstance()->addVendor('YourLib', 'yourLib/src/');
```
```php
TRex\Loader\ClassLoader::getInstance()->getSourcePath('YourLib'); // "yourLib/src/"
TRex\Loader\ClassLoader::getInstance()->getRootDir('YourLib'); // "yourLib/"
TRex\Loader\ClassLoader::getInstance()->getRealPath('YourLib');// "yourLib/src/"
```

You can redefine the base path in setting a new absolute base path from where every path will be resolved.

```php
TRex\Loader\ClassLoader::getInstance()->setBasePath('/specific/base/path/');
TRex\Loader\ClassLoader::getInstance()->addVendor('YourLib', 'yourLib/src/');
```
```php
TRex\Loader\ClassLoader::getInstance()->getSourcePath('YourLib'); // "yourLib/src/"
TRex\Loader\ClassLoader::getInstance()->getRootDir('YourLib'); // "/specific/base/path/yourLib/"
TRex\Loader\ClassLoader::getInstance()->getRealPath('YourLib');// "/specific/base/path/yourLib/src/"
```