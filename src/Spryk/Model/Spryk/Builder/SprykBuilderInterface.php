<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface SprykBuilderInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $definition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface|null $style
     *
     * @return void
     */
    public function runSpryk(SprykDefinitionInterface $definition, ?SprykStyleInterface $style = null): void;
}
