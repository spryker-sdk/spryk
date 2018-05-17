<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection;

use Spryker\Spryk\Exception\CallbackNotFoundException;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface;

class CallbackCollection implements CallbackCollectionInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface[]
     */
    protected $callbacks;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface[] $callbacks
     */
    public function __construct(array $callbacks)
    {
        $this->callbacks = $callbacks;
    }

    /**
     * @param string $callbackName
     *
     * @throws \Spryker\Spryk\Exception\CallbackNotFoundException
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\CallbackInterface
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
