<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use Codeception\Step;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;

class IntegrationModule extends Module
{
    /**
     * @var array
     */
    protected static $executedSpryks = [];

    /**
     * @var array
     */
    protected $config = [
        'developmentMode' => 'core',
    ];

    /**
     * @param string $spryk
     *
     * @return $this
     */
    public function addExecutedSpryk(string $spryk)
    {
        static::$executedSpryks[$spryk] = $spryk;

        return $this;
    }

    /**
     * @return array
     */
    public static function getExecutedSpryks()
    {
        return static::$executedSpryks;
    }

    /**
     * @param \Codeception\Step $step
     *
     * @return void
     */
    public function _afterStep(Step $step): void
    {
        OptionsContainer::clearOptions();
    }

    /**
     * @return string
     */
    public function getDevelopmentMode(): string
    {
        return $this->config['developmentMode'];
    }
}
