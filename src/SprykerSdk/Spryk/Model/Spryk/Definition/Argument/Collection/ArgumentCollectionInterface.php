<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;

interface ArgumentCollectionInterface
{
    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function addArgument(ArgumentInterface $argument): self;

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasArgument(string $name): bool;

    /**
     * @param string $name
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function getArgument(string $name): ArgumentInterface;

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface[]
     */
    public function getArguments(): array;

    /**
     * @return array
     */
    public function getArgumentsAsArray(): array;
}
