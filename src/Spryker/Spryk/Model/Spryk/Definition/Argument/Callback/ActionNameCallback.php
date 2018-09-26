<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ActionNameCallback implements CallbackInterface
{
    protected const ACTION_SUFFIX = 'Action';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ActionNameCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $actionName = $argumentCollection->getArgument('method')->getValue();
        if (mb_substr($actionName, - mb_strlen(static::ACTION_SUFFIX)) === static::ACTION_SUFFIX) {
            $actionName = mb_substr($actionName, 0, mb_strlen($actionName) - mb_strlen(static::ACTION_SUFFIX));
        }

        return lcfirst($actionName);
    }
}
