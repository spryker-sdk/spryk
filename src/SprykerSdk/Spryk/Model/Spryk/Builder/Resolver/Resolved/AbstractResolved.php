<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

abstract class AbstractResolved implements ResolvedInterface
{
    /**
     * @var string
     */
    protected string $filePath;

    /**
     * @var string|null
     */
    protected ?string $tmpFileName = null;

    /**
     * @var string
     */
    protected string $originalContent = '';

    /**
     * @var string
     */
    protected string $content = '';

    /**
     * @param string $content
     *
     * @return void
     */
    public function setOriginalContent(string $content): void
    {
        $this->originalContent = $content;
    }

    /**
     * @return string
     */
    public function getOriginalContent(): string
    {
        return $this->originalContent;
    }

    /**
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $filePath
     *
     * @return void
     */
    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @return string
     */
    public function getTmpFileName(): string
    {
        if ($this->tmpFileName === null) {
            $this->tmpFileName = sprintf('%s/spryk/%s', sys_get_temp_dir(), basename($this->filePath));
        }

        return $this->tmpFileName;
    }
}
