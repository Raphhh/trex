<?php

include_once __DIR__ . '/../../src/TRex/bootstrap.php';

$classLoader = new \TRex\Loader\ClassLoader();
$classLoader->addVendor('TRex', dirname(__DIR__));
$classLoader->register();
