<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Executor\Configuration;

interface SprykExecutorConfigurationInterface
{
    /**
     * @param string $sprykName
     * @param array $includeOptionalSubSpryks
     * @param string $targetModuleName
     * @param string $dependentModuleName
     *
     * @return mixed
     */
    public function prepare(
        string $sprykName,
        array $includeOptionalSubSpryks,
        string $targetModuleName,
        string $dependentModuleName
    );

    /**
     * @return string
     */
    public function getSprykName(): string;

    /**
     * @return array<string>
     */
    public function getIncludeOptionalSubSpryks(): array;

    /**
     * @return string|null
     */
    public function getTargetModule(): ?string;

    /**
     * @return string|null
     */
    public function getTargetModuleOrganization(): ?string;

    /**
     * @return string|null
     */
    public function getTargetModuleLayer(): ?string;

    /**
     * @return string|null
     */
    public function getDependentModule(): ?string;

    /**
     * @return string|null
     */
    public function getDependentModuleOrganization(): ?string;

    /**
     * @return string|null
     */
    public function getDependentModuleLayer(): ?string;
}
