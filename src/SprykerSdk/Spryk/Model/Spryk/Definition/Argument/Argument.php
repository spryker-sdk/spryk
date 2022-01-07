<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument;

class Argument implements ArgumentInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var bool
     */
    protected $allowOverride = false;

    /**
     * @var array<string>
     */
    protected $callbacks = [];

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAllowOverride(): bool
    {
        return $this->allowOverride;
    }

    /**
     * @param bool $allowOverride
     *
     * @return $this
     */
    public function setAllowOverride(bool $allowOverride)
    {
        $this->allowOverride = $allowOverride;

        return $this;
    }

    /**
     * @return array<string>
     */
    public function getCallbacks(): array
    {
        return $this->callbacks;
    }

    /**
     * @param array $callbacks
     *
     * @return $this
     */
    public function setCallbacks(array $callbacks)
    {
        $this->callbacks = $callbacks;

        return $this;
    }

    /**
     * @return array|string
     */
    public function __toString()
    {
        $value = $this->getValue();

        if (is_array($value)) {
            return implode(PHP_EOL, $value);
        }

        return $value;
    }
}
