<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver;

class OptionsContainer
{
    /**
     * @var array|null
     */
    protected static $options;

    /**
     * @param array $options
     *
     * @return void
     */
    public static function setOptions(array $options): void
    {
        static::$options = $options;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function hasOption(string $name): bool
    {
        return isset(static::$options[$name]);
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public static function getOption(string $name)
    {
        return static::$options[$name];
    }

    /**
     * @return void
     */
    public static function clearOptions(): void
    {
        static::$options = null;
    }
}
