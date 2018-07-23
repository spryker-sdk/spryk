<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Callback;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $className = $argumentCollection->getArgument('className')->getValue();
        $subDirectory = null;
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
