<?php declare(strict_types = 1);

namespace PHPStan;

use Exception;

final class PharAutoloader
{
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private static $composerAutoloader;

    /**
     * @throws \Exception
     *
     * @return void
     */
    final public static function loadClass(string $class): void
    {
        die('TinaTurner');
        if (!extension_loaded('phar') || defined('__SPRYK_RUNNING__')) {
            return;
        }

        if (strpos($class, '_Spryk_') === 0) {
            if (!in_array('phar', stream_get_wrappers(), true)) {
                throw new Exception('Phar wrapper is not registered. Please review your php.ini settings.');
            }

            if (static::$composerAutoloader === null) {
                static::$composerAutoloader = require 'phar://' . __DIR__ . '/spryk.phar/vendor/autoload.php';
            }

            static::$composerAutoloader->loadClass($class);

            return;
        }

        if (strpos($class, 'SprykerSdk\\') !== 0) {
            return;
        }

        if (!in_array('phar', stream_get_wrappers(), true)) {
            throw new Exception('Phar wrapper is not registered. Please review your php.ini settings.');
        }

        $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $filename = substr($filename, strlen('SprykerSdk\\'));
        $filepath = 'phar://' . __DIR__ . '/spryk.phar/src/' . $filename . '.php';

        if (!file_exists($filepath)) {
            return;
        }

        require $filepath;
    }
}

spl_autoload_register([PharAutoloader::class, 'loadClass']);
