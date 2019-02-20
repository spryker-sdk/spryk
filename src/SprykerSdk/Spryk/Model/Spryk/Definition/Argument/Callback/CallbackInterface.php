<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

interface CallbackInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @throws \SprykerSdk\Spryk\Exception\ArgumentNotFoundException
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value);
}
