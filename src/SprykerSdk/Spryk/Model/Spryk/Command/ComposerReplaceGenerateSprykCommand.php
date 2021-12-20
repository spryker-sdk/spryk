<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Command;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\SprykConfig;

class ComposerReplaceGenerateSprykCommand extends AbstractSprykCommand
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ComposerReplaceGenerate';
    }

    /**
     * @return string
     */
    protected function getCommandLine(): string
    {
        return 'vendor/bin/console dev:composer:replace';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isRunnable(SprykDefinitionInterface $sprykDefinition): bool
    {
        $organization = $sprykDefinition->getArgumentCollection()->getArgument(SprykConfig::NAME_ARGUMENT_ORGANIZATION);

        if (!in_array($organization->getValue(), ['Spryker', 'SprykerShop'], true)) {
            return false;
        }

        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getFallbackMessage(SprykDefinitionInterface $sprykDefinition): string
    {
        return sprintf(
            'Please, add new module into a `replace` section in `composer.json` for the %s organization.',
            $sprykDefinition->getArgumentCollection()->getArgument(SprykConfig::NAME_ARGUMENT_ORGANIZATION),
        );
    }
}
