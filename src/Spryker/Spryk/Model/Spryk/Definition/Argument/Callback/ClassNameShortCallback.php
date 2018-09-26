<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ClassNameShortCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ClassNameShortCallback';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        if (strpos($value, '\\') === false) {
            return $value;
        }

        $classNameFragments = explode('\\', $value);

        return array_pop($classNameFragments);
    }
}
