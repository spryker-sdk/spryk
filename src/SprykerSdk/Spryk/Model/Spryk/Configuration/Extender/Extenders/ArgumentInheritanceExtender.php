<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;

class ArgumentInheritanceExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        $excludedArgumentList = $this->getExcludedArgumentList();

        foreach ($arguments as $argumentName => $value) {
            if (!in_array($argumentName, $excludedArgumentList, true)) {
                $arguments[$argumentName]['inherit'] = true;
            }
        }

        return $this->setArguments($arguments, $sprykConfig);
    }

    /**
     * @return array
     */
    protected function getExcludedArgumentList(): array
    {
        return [
            'targetPath',
            'className',
            'subDirectory',
        ];
    }
}
