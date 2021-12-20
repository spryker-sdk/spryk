<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class GlueProcessorModelSubDirectoryCallback implements CallbackInterface
{
    /**
     * @var string
     */
    protected const CALLBACK_NAME = 'GlueProcessorModelSubDirectory';

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
        if (strpos($className, '\\') === false) {
            return null;
        }

        $classNameFragments = explode('\\', $className);
        $positionOfProcessor = array_search('Processor', $classNameFragments, true);
        if ($positionOfProcessor === false) {
            return null;
        }

        $requiredSubDirectoryFragments = array_slice(
            $classNameFragments,
            $positionOfProcessor + 1,
            count($classNameFragments),
        );

        return implode(DIRECTORY_SEPARATOR, $requiredSubDirectoryFragments);
    }
}
