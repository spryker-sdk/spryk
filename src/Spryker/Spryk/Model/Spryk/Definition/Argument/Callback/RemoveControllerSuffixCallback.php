<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class RemoveControllerSuffixCallback implements CallbackInterface
{
    public const CONTROLLER_SUFFIX = 'Controller';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'RemoveControllerSuffixCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        if (mb_substr($value, - mb_strlen(static::CONTROLLER_SUFFIX)) === static::CONTROLLER_SUFFIX) {
            $value = mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::CONTROLLER_SUFFIX));
        }

        return ucfirst($value);
    }
}
