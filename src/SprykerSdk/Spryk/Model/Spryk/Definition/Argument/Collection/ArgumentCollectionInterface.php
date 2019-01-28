<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
