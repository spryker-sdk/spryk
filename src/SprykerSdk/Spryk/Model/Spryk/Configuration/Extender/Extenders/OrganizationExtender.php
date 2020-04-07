<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use SprykerSdk\Spryk\SprykConfig;

class OrganizationExtender extends AbstractExtender implements SprykConfigurationExtenderInterface
{
    /**
     * @param array $sprykConfig
     *
     * @return array
     */
    public function extend(array $sprykConfig): array
    {
        $arguments = $this->getArguments($sprykConfig);

        if (!isset($arguments['organization']) || !isset($arguments['mode']['value'])) {
            return $sprykConfig;
        }

        $arguments = $this->buildProjectOrganization($arguments);
        $arguments = $this->buildCoreOrganization($arguments);

        $sprykConfig = $this->setArguments($arguments, $sprykConfig);

        return $sprykConfig;
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function buildProjectOrganization(array $arguments): array
    {
        if ($arguments['mode']['value'] !== SprykConfig::NAME_DEVELOPMENT_LAYER_PROJECT) {
            return $arguments;
        }

        $projectNamespace = $this->config->getProjectNamespace();
        $projectNamespaces = $this->config->getProjectNamespaces();

        $arguments['organization']['default'] = $projectNamespace;
        $arguments['organization']['values'] = $projectNamespaces;

        return $arguments;
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function buildCoreOrganization(array $arguments): array
    {
        if ($arguments['mode']['value'] !== SprykConfig::NAME_DEVELOPMENT_LAYER_CORE) {
            return $arguments;
        }

        $coreNamespaces = $this->config->getCoreNamespaces();
        $coreNamespaces = ['Trial'];

        $arguments['organization']['values'] = $coreNamespaces;

        return $arguments;
    }
}
