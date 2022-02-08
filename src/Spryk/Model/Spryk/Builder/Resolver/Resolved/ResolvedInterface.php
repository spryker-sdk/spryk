<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

interface ResolvedInterface
{
    /**
     * @param string $content
     *
     * @return void
     */
    public function setOriginalContent(string $content): void;

    /**
     * @return string
     */
    public function getOriginalContent(): string;

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void;

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $filePath
     *
     * @return void
     */
    public function setFilePath(string $filePath): void;

    /**
     * @return string
     */
    public function getFilePath(): string;

    /**
     * @return string
     */
    public function getTmpFileName(): string;
}
