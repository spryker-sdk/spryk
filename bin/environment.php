<?php

use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Zed\Console\Business\Model\Environment;
use Symfony\Component\ErrorHandler\ErrorHandler;

defined('APPLICATION_ROOT_DIR') || define('APPLICATION_ROOT_DIR', getcwd());

$autoloadPath = APPLICATION_ROOT_DIR . '/vendor/autoload.php';

if (file_exists($autoloadPath)) {
    require_once $autoloadPath;

    if (class_exists(Config::class) && interface_exists(KernelConstants::class)) {
        Environment::initialize();
        define('SPRYKER_PROJECT_NAMESPACE', Config::get(KernelConstants::PROJECT_NAMESPACE, ''));
        define('SPRYKER_PROJECT_NAMESPACES', implode(',', Config::get(KernelConstants::PROJECT_NAMESPACES, '')));
        define('SPRYKER_CORE_NAMESPACES', Config::get(KernelConstants::CORE_NAMESPACES, ''));
    }
}

if (class_exists(ErrorHandler::class)) {
    echo "Hundnase";
    ErrorHandler::register();
}
