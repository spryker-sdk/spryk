<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class GlueProcessorFactoryMethodNameCallback implements CallbackInterface
{
    /**
     * @var string
     */
    protected const CALLBACK_NAME = 'GlueProcessorFactoryMethodName';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::CALLBACK_NAME;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $className = (string)$argumentCollection->getArgument('className')->getValue();
        $classNameFragments = explode('\\', $className);

        return $this->ensurePrefix(array_pop($classNameFragments));
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function ensurePrefix(string $value): string
    {
        $prefix = 'create';
        if (substr_compare($value, $prefix, 0, strlen($prefix)) === 0) {
            return $value;
        }

        return $prefix . $value;
    }
}
