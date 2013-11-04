# TRex\Loader\ClassLoader

TRex\Loader\ClassLoader, as its name suggests, is a PSR-0 class (auto-)loader.

## Active class auto-loader

By activating auto-loader, TRex\Loader\ClassLoader will include the file containing your class.

    TRex\Loader\ClassLoader::getInstance->register();

You can stop auto-loading when you want.

    TRex\Loader\ClassLoader::getInstance->unRegister();

## Load class

You can ask to TRex\Loader\ClassLoader to load a specific class.

    TRex\Loader\ClassLoader::getInstance->load('Vendor\Package\Class');

See how to add a vendor if you want to use it for a specific vendor class.

## Resolve path

TRex\Loader\ClassLoader can resolve the root directory and real source path of a vendor. The root directory is the path to the directory containing a vendor package. The real path is the absolute path to the source.

    TRex\Loader\ClassLoader::getInstance->getRootDir('Vendor'); //$ROOT_DIR
    TRex\Loader\ClassLoader::getInstance->getRealPath('Vendor'); //$ROOT_DIR/src/

See how to add a vendor if you want to use it for a specific vendor class.

## Add vendor

By adding a vendor, you can use these features for other PHP library.

### How to add a vendor?

There is three ways to add your personal vendors.

	//1. add vendors when your register auto-loading
    TRex\Loader\ClassLoader::getInstance->register(
		array(
			'VendorName1' => 'path/to/src1/',
			'VendorName2' => 'path/to/src2/',
			...
		)
	);

	//2. add vendors one by one for all the features
    TRex\Loader\ClassLoader::getInstance->addVendor('VendorName1', 'path/to/src1/');
	TRex\Loader\ClassLoader::getInstance->addVendor('VendorName2', 'path/to/src2/');
	...

	//3. add a list of vendors for all the features
	TRex\Loader\ClassLoader::getInstance->addVendors(
	    array(
	        'VendorName1' => 'path/to/src1',
	        'VendorName2' => 'path/to/src2'
	    )
	);

You can ask if a vendor is already added.

	TRex\Loader\ClassLoader::getInstance->hasVendor('Vendor'); //bool true if already added

You can get a vendor source path and root dir.

    TRex\Loader\ClassLoader::getInstance->getSourcePath('Vendor'); // "library/path/to/src/"
    TRex\Loader\ClassLoader::getInstance->getRootDir('Vendor'); // "$ROOT_DIR/library/"
    TRex\Loader\ClassLoader::getInstance->getRealPath('Vendor'); // "$ROOT_DIR/library/path/to/src/"

You can remove a vendor.

	TRex\Loader\ClassLoader::getInstance->removeVendor('Vendor');

### How to compose vendor data?

#### Vendor name
The vendor name is the common namespace of a library packages. In PSR-0, class name refers to it trough a namespace or un underscore separator:

	Vendor\Package\Class
	Vendor_Package_Class

Vendor name and library name must be directories with an identical name. ClassName must be a file with an identical name and a *.php* extension.

See PSR-0 for complete specifications.

#### Vendor source path

The vendor source path points to the directory containing classes.
The path must contains at least the vendor directory. The vendor directory must have exactly the same name than the vendor, otherwise an exception will be thrown.
The path must end with a correct directory separator ("/"), otherwise a notice will be triggered.

    ../../path/to/src/[Vendor/Package/Class.php]

### How a vendor path will be resolved?

By default, the vendor path is resolve from directory containing TRex library. So, if your vendors is included in the same directory, you have just to specify the path to the source.

Example

    /
    |
    |`- Vendors
    |   |
        |`- trex
        |`- yourLib
        |   |
            |`- docs
            |`- src
            |    |`- YourLib
            |           |`- Package1
            |           |`- Package2
            |           |
            |`- tests

Your vendor name will be "YourLib" and your path will be "yourLib/src".

You will have the following behavior:

    TRex\Loader\ClassLoader::getInstance->addVendor('YourLib', 'yourLib/src/');

    TRex\Loader\ClassLoader::getInstance->getSourcePath('YourLib'); // "yourLib/src/"
    TRex\Loader\ClassLoader::getInstance->getRootDir('YourLib'); // "/Vendors/yourLib/"
    TRex\Loader\ClassLoader::getInstance->getRealPath('YourLib');// "/Vendors/yourLib/src/"
