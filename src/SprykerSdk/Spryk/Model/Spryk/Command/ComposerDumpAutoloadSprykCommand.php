<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Command;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

class ComposerDumpAutoloadSprykCommand extends AbstractSprykCommand
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ComposerDumpAutoload';
    }

    /**
     * @return string
     */
    protected function getCommandLine(): string
    {
        return 'composer dump-autoload';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isRunnable(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getFallbackMessage(SprykDefinitionInterface $sprykDefinition): string
    {
        return 'Please, execute `composer dump-autoload` manually.';
    }
}
