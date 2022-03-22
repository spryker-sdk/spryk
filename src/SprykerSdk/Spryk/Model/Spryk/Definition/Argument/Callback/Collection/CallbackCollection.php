<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection;

use SprykerSdk\Spryk\Exception\CallbackNotFoundException;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface;

class CallbackCollection implements CallbackCollectionInterface
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface>
     */
    protected $callbacks;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface> $callbacks
     */
    public function __construct(array $callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * @param string $callbackName
     *
     * @throws \SprykerSdk\Spryk\Exception\CallbackNotFoundException
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
     */
    public function getCallbackByName(string $callbackName): CallbackInterface
    {
        foreach ($this->callbacks as $callback) {
            if ($callback->getName() === $callbackName) {
                return $callback;
            }
        }

        throw new CallbackNotFoundException(sprintf('Callback by name "%s" not found. Maybe you have a typo in your callback name or you need to add it to the callback collection.', $callbackName));
    }
}
