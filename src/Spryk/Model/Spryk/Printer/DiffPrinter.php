<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Printer;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\DiffOnlyOutputBuilder;

class DiffPrinter implements DiffPrinterInterface
{
    /**
     * @param string $original
     * @param string $new
     *
     * @return string
     */
    public function printDiff(string $original, string $new): string
    {
        $builder = new DiffOnlyOutputBuilder(
            "--- Original\n+++ New\n",
        );
        $differ = (new Differ($builder));
        $diff = $differ->diff(
            $original,
            $new,
        );

        if ($diff === "--- Original\n+++ New\n") {
            return '';
        }

        return $diff;
    }
}
