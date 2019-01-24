<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument;

interface ArgumentInterface
{
    /**
     * @param string $name
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setName(string $name): self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param mixed $value
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setValue($value): self;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param array $callbacks
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function setCallbacks(array $callbacks): self;

    /**
     * @return string[]
     */
    public function getCallbacks(): array;

    /**
     * @return mixed
     */
    public function __toString();
}
