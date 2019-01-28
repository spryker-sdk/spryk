<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
}
