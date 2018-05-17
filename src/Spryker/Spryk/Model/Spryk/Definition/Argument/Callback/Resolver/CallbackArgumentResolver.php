<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class CallbackArgumentResolver implements CallbackArgumentResolverInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface
     */
    protected $callbackCollection;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface $callbackCollection
     */
    public function __construct(CallbackCollectionInterface $callbackCollection)
    {
        $this->callbackCollection = $callbackCollection;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(ArgumentCollectionInterface $argumentCollection): ArgumentCollectionInterface
    {
        foreach ($argumentCollection->getArguments() as $argument) {
            $value = $argument->getValue();
            foreach ($argument->getCallbacks() as $callback) {
                $callback = $this->callbackCollection->getCallbackByName($callback);
                $value = $callback->getValue($argumentCollection, $value);
            }

            $argument->setValue($value);
        }

        return $argumentCollection;
    }
}
