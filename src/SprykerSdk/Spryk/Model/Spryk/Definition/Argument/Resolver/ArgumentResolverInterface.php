<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface ArgumentResolverInterface
{
    /**
     * @param array $arguments
     * @param string $sprykName
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(array $arguments, string $sprykName, SprykStyleInterface $style): ArgumentCollectionInterface;
}
