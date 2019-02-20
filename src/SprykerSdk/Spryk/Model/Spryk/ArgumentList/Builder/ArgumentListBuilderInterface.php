<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder;

interface ArgumentListBuilderInterface
{
    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    public function buildArgumentList(array $sprykDefinitions): array;
}
