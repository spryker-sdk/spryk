<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedBusinessFactoryMethodNameCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedBusinessFactoryMethodNameCallback';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $factoryMethod = $argumentCollection->hasArgument('factoryMethod')
            ? $argumentCollection->getArgument('factoryMethod')->getValue()
            : false;

        if ($factoryMethod) {
            return $factoryMethod;
        }

        $className = $argumentCollection->getArgument('className')->getValue();
        $classNameFragments = explode('\\', $className);

        return 'create' . array_pop($classNameFragments);
    }
}
