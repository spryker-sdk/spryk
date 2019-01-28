<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
