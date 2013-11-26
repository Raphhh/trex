<?php
error_reporting(E_ALL | E_STRICT);

require_once 'Loader/ClassLoader.php';

$classLoader = new \TRex\Loader\ClassLoader();
$classLoader->addVendor('TRex', sprintf('trex%src%s', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR));
$classLoader->register();
