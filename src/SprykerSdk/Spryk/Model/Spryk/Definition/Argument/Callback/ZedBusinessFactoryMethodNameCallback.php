<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
        $className = $argumentCollection->getArgument('className')->getValue();
        $classNameFragments = explode('\\', $className);

        return 'create' . array_pop($classNameFragments);
    }
}
