<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

/** @var ClassLoader $loader */
$loader = require __DIR__.'/../vendor/autoload.php';
//$loader->add('AliPayRequest', realpath(__DIR__.'/../src/Hn/SwBundle/Services/AliPay/AliPayRequest'));
//$loader->add('AliPayWapPatModel', realpath(__DIR__.'/../src/Hn/SwBundle/Services/AliPay/WapPayModel'));

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

AnnotationDriver::registerAnnotationClasses();

return $loader;
