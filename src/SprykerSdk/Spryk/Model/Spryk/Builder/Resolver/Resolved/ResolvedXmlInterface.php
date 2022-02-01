<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

use SimpleXMLElement;

interface ResolvedXmlInterface extends ResolvedInterface
{
    /**
     * @param \SimpleXMLElement $simpleXMLElement
     *
     * @return void
     */
    public function setSimpleXmlElement(SimpleXMLElement $simpleXMLElement): void;

    /**
     * @return \SimpleXMLElement
     */
    public function getSimpleXmlElement(): SimpleXMLElement;
}
