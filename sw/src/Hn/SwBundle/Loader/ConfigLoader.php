<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2017/5/11
 * Time: 15:01
 */

namespace Hn\SwBundle\Loader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class ConfigLoader
{
    public function load($loadName,$type = 'yaml')
    {
        $configDirectories = array(__DIR__);

        $locator = new FileLocator($configDirectories);
        $configName = $loadName . '.' . $type;
        $resource = $locator->locate($configName, null, false);

        $configValues = Yaml::parse(file_get_contents($resource[0]));

        return $configValues;
    }
}