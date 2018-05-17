<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

interface CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @throws \Spryker\Spryk\Exception\ArgumentNotFoundException
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value);
}
