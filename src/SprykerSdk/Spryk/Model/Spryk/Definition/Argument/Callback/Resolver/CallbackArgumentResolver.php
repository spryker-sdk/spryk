<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class CallbackArgumentResolver implements CallbackArgumentResolverInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface
     */
    protected $callbackCollection;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Collection\CallbackCollectionInterface $callbackCollection
     */
    public function __construct(CallbackCollectionInterface $callbackCollection)
    {
        $this->callbackCollection = $callbackCollection;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
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
