<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;

interface ArgumentCollectionInterface
{
    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return $this
     */
    public function addArgument(ArgumentInterface $argument);

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
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface>
     */
    public function getArguments(): array;

    /**
     * @return array
     */
    public function getArgumentsAsArray(): array;

    /**
     * @return string
     */
    public function getFingerprint(): string;
}
