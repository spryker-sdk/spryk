<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest;

use Codeception\Actor;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class SprykIntegrationTester extends Actor
{
    use _generated\SprykIntegrationTesterActions;

    /**
     * @param string $module
     *
     * @return string
     */
    public function getSprykerModuleDirectory(string $module = 'FooBar'): string
    {
        return sprintf('%svendor/spryker/spryker/Bundles/%s/', $this->getVirtualDirectory(), $module);
    }

    /**
     * @param string $module
     *
     * @return string
     */
    public function getSprykerShopModuleDirectory(string $module = 'FooBar'): string
    {
        return sprintf('%svendor/spryker/spryker-shop/Bundles/%s/', $this->getVirtualDirectory(), $module);
    }

    /**
     * @param string $module
     * @param string $layer
     *
     * @return string
     */
    public function getProjectModuleDirectory(string $module = 'FooBar', string $layer = 'Zed'): string
    {
        return sprintf('%ssrc/Pyz/%s/%s/', $this->getVirtualDirectory(), $layer, $module);
    }

    /**
     * @param string $module
     * @param string $layer
     *
     * @return string
     */
    public function getProjectTestDirectory(string $module = 'FooBar', string $layer = 'Zed'): string
    {
        return sprintf('%stests/PyzTest/%s/%s/', $this->getVirtualDirectory(), $layer, $module);
    }
}
