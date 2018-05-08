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
     * @var array
     */
    protected $options;

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
}
