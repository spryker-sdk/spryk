<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

interface ResolvedDataInterface extends ResolvedInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function setDecodedYml(array $data): void;

    /**
     * @return array
     */
    public function getDecodedYml(): array;
}
