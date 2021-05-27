<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class ArgumentToDocParameterFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'argumentToDocParameter';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $argumentParts = explode(' ', $value);

        if (mb_substr($argumentParts[0], 0, 1) === '?') {
            return sprintf(
                '%s|%s %s',
                mb_substr($argumentParts[0], 1),
                'null',
                $argumentParts[1]
            );
        }

        return $value;
    }
}
