<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Builder;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

interface SprykDefinitionBuilderInterface
{
    /**
     * @param string $sprykName
     * @param string $currentMode
     * @param array|null $preDefinedDefinition
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function buildDefinition(string $sprykName, ?string $currentMode = null, ?array $preDefinedDefinition = null): SprykDefinitionInterface;

    /**
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return $this
     */
    public function setStyle(SprykStyleInterface $style);
}
