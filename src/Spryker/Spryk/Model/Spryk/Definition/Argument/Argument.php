<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument;

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
     * @var string[]|null
     */
    protected $callbacks;

    /**
     * @param string $name
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setName(string $name): ArgumentInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setValue($value): ArgumentInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasCallbacks(): bool
    {
        return ($this->callbacks !== null);
    }

    /**
     * @return string[]
     */
    public function getCallbacks(): array
    {
        if (!$this->hasCallbacks()) {
            return [];
        }
        
        return $this->callbacks;
    }

    /**
     * @param array $callbacks
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setCallbacks(array $callbacks): ArgumentInterface
    {
        $this->callbacks = $callbacks;

        return $this;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
