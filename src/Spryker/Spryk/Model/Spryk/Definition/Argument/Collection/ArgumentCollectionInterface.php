<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Collection;

use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;

interface ArgumentCollectionInterface
{
    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function getArgument(string $name): ArgumentInterface;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface[]
     */
    public function getArguments(): array;

    /**
     * @return array
     */
    public function getArgumentsAsArray(): array;
}
