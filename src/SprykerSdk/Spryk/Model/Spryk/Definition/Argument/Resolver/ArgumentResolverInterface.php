<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface|null $resolvedArgumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(
        array $arguments,
        string $sprykName,
        SprykStyleInterface $style,
        ?ArgumentCollectionInterface $resolvedArgumentCollection = null
    ): ArgumentCollectionInterface;
}
