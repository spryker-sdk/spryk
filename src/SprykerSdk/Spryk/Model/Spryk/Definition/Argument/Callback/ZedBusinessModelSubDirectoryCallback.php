<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class ZedBusinessModelSubDirectoryCallback implements CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ZedBusinessModelSubDirectoryCallback';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $className = $argumentCollection->getArgument('className')->getValue();
        $subDirectory = $value;
        if (strpos($className, '\\') !== false) {
            $classNameFragments = explode('\\', $className);
            $positionOfBusiness = (int)array_search('Business', $classNameFragments, true);
            $requiredSubDirectoryFragments = array_slice($classNameFragments, $positionOfBusiness + 1);
            array_pop($requiredSubDirectoryFragments);
            $subDirectory = implode(DIRECTORY_SEPARATOR, $requiredSubDirectoryFragments);
        }

        return $subDirectory;
    }
}
