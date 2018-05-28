<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Module;

use Codeception\Module;
use Codeception\Step;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;

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
    public function addExecutedSpryk(string $spryk): IntegrationModule
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
