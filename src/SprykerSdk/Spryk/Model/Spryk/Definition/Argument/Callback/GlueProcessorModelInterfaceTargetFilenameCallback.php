<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class GlueProcessorModelInterfaceTargetFilenameCallback implements CallbackInterface
{
    /**
     * @var string
     */
    protected const CALLBACK_NAME = 'GlueProcessorModelInterfaceTargetFilename';

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
        if (strpos($className, '\\') !== false) {
            $classNameFragments = explode('\\', $className);

            $className = array_pop($classNameFragments);
        }

        return $className . 'Interface.php';
    }
}
