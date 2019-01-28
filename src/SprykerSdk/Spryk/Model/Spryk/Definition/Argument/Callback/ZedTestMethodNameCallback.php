<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedTestMethodNameCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedTestMethodNameCallback';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $methodName = $argumentCollection->getArgument('method')->getValue();

        return 'test' . ucfirst($methodName) . '_add_test_info';
    }
}
