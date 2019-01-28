<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface;

interface CallbackCollectionInterface
{
    /**
     * @param string $callbackName
     *
     * @throws \SprykerSdk\Spryk\Exception\CallbackNotFoundException
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function getCallbackByName($callbackName): CallbackInterface;
}
