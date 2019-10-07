<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Service\ZipZap;

use Generated\Shared\Transfer\FooBarTransfer;
use Generated\Shared\Transfer\ZipZapTransfer;

interface ZipZapServiceInterface
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
    public function methodWithStringArgument(string $foo): bool;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithArrayArgument(array $foo): bool;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $foo
     *
     * @return void
     */
    public function methodReturnsVoid(string $foo): void;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer $zipZapTransfer
     *
     * @return \Generated\Shared\Transfer\FooBarTransfer
     */
    public function methodWithTransferInputAndTransferOutput(ZipZapTransfer $zipZapTransfer): FooBarTransfer;

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer|null $zipZapTransfer
     *
     * @return bool
     */
    public function methodWithDefaultNull(?ZipZapTransfer $zipZapTransfer = null): bool;

    /**
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithDefaultArray($foo = []): bool;

    /**
     * @api
     *
     * @return void
     */
    public function methodWithoutMethodReturnType();

    /**
     * @api
     *
     * @return
     */
    public function methodWithoutDocBlockReturnType();

    /**
     * @api
     *
     * @return string|int
     */
    public function methodWithMultipleReturn();

    /**
     * @api
     *
     * @return string|int|null
     */
    public function methodWithMultipleReturnAndNullable();

    /**
     * @api
     *
     * @return string|null
     */
    public function methodWithNullableReturn();
}
