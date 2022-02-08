<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

class ResolvedJson extends AbstractResolved implements ResolvedJsonInterface
{
    /**
     * @var array
     */
    protected array $decodedJson;

    /**
     * @param array $decodedJson
     *
     * @return void
     */
    public function setDecodedJson(array $decodedJson): void
    {
        $this->decodedJson = $decodedJson;
    }

    /**
     * @return array
     */
    public function getDecodedJson(): array
    {
        return $this->decodedJson;
    }
}
