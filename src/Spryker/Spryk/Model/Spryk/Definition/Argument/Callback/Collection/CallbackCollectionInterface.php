<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface;

interface CallbackCollectionInterface
{
    /**
     * @param string $callbackName
     *
     * @throws \Spryker\Spryk\Exception\CallbackNotFoundException
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function getCallbackByName($callbackName): CallbackInterface;
}
