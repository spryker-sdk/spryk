<?php

namespace SprykerSdk\Spryk\Console;

use Exception;

class Environment
{
    /**
     * @return void
     */
    public static function initialize(): void
    {
        static::defineApplicationRootDir();
        static::defineSdkRootDir();
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    protected static function defineApplicationRootDir(): void
    {
        if (!defined('APPLICATION_ROOT_DIR')) {
            $applicationRootDir = getenv('APPLICATION_ROOT_DIR', true) ?: getenv('APPLICATION_ROOT_DIR');
            if (!$applicationRootDir) {
                throw new Exception('Can not get APPLICATION_ROOT_DIR environment variable');
            }
            define('APPLICATION_ROOT_DIR', $applicationRootDir);
        }
    }

    /**
     * @return void
     */
    protected static function defineSdkRootDir(): void
    {
        if (defined('APPLICATION_SDK_DIR')) {
            return;
        }

        $applicationSdkDir = getenv('APPLICATION_SDK_DIR', true) ?: getenv('APPLICATION_SDK_DIR');

        if (!$applicationSdkDir) {
            return;
        }

        define('APPLICATION_SDK_DIR', $applicationSdkDir);
    }
}
