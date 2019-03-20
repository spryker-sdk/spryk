<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class EnsureConsoleSuffixFilter implements FilterInterface
{
    public const CONSOLE_SUFFIX = 'Console';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ensureConsoleSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::CONSOLE_SUFFIX)) !== static::CONSOLE_SUFFIX) {
            $value = $value . static::CONSOLE_SUFFIX;
        }

        return ucfirst($value);
    }
}
