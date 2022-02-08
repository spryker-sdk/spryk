<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Printer;

interface DiffPrinterInterface
{
    /**
     * @param string $original
     * @param string $new
     *
     * @return string
     */
    public function printDiff(string $original, string $new): string;
}
