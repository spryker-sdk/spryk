<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
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
