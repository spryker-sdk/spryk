<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

class ResolvedYml extends AbstractResolved implements ResolvedYmlInterface
{
    /**
     * @var array
     */
    protected array $decodedYml = [];

    /**
     * @param array $decodedYml
     *
     * @return void
     */
    public function setDecodedYml(array $decodedYml): void
    {
        $this->decodedYml = $decodedYml;
    }

    /**
     * @return array
     */
    public function getDecodedYml(): array
    {
        return $this->decodedYml;
    }
}
