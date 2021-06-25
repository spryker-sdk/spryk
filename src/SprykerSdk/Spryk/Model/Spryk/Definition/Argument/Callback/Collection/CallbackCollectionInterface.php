<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
    public function getCallbackByName(string $callbackName): CallbackInterface;
}
