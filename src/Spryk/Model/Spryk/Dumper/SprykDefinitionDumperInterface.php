<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Dumper;

interface SprykDefinitionDumperInterface
{
    /**
     * @param int|null $level
     *
     * @return array<mixed>
     */
    public function dump(?int $level = null): array;
}
