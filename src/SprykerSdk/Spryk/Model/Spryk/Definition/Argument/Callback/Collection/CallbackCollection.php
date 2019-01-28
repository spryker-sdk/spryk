<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection;

use SprykerSdk\Spryk\Exception\CallbackNotFoundException;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface;

class CallbackCollection implements CallbackCollectionInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface[]
     */
    protected $callbacks;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface[] $callbacks
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
    public function getCallbackByName($callbackName): CallbackInterface
    {
        foreach ($this->callbacks as $callback) {
            if ($callback->getName() === $callbackName) {
                return $callback;
            }
        }

        throw new CallbackNotFoundException(sprintf('Callback by name "%s" not found. Maybe you have a typo in your callback name or you need to add it to the callback collection.', $callbackName));
    }
}
