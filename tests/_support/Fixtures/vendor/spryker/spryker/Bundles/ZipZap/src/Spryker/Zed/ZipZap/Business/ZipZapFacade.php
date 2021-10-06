<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ZipZap\Business;

use Generated\Shared\Transfer\FooBarTransfer;
use Generated\Shared\Transfer\ZipZapTransfer;

class ZipZapFacade implements ZipZapFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $foo
     *
     * @return bool
     */
    public function methodWithStringArgument(string $foo): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithArrayArgument(array $foo): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $foo
     *
     * @return void
     */
    public function methodReturnsVoid(string $foo): void
    {
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer $zipZapTransfer
     *
     * @return \Generated\Shared\Transfer\FooBarTransfer
     */
    public function methodWithTransferInputAndTransferOutput(ZipZapTransfer $zipZapTransfer): FooBarTransfer
    {
        return new FooBarTransfer();
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer|null $zipZapTransfer
     *
     * @return bool
     */
    public function methodWithDefaultNull(?ZipZapTransfer $zipZapTransfer = null): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithDefaultArray($foo = []): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function methodWithoutMethodReturnType()
    {
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function methodWithoutDocBlockReturnType()
    {
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return int|string
     */
    public function methodWithMultipleReturn()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return int|string|null
     */
    public function methodWithMultipleReturnAndNullable()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function methodWithNullableReturn()
    {
        return null;
    }
}
