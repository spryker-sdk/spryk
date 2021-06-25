<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
    public static function getExecutedSpryks(): array
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
