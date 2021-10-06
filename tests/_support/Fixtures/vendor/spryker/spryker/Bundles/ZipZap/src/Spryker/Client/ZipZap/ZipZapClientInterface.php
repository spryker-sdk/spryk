<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Client\ZipZap;

use Generated\Shared\Transfer\FooBarTransfer;
use Generated\Shared\Transfer\ZipZapTransfer;

interface ZipZapClientInterface
{
    /**
     * Specification:
     * - Returns whether the method is with string argument.
     *
     * @api
     *
     * @param string $foo
     *
     * @return bool
     */
    public function methodWithStringArgument(string $foo): bool;

    /**
     * Specification:
     * - Returns whether the method is with array argument.
     *
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithArrayArgument(array $foo): bool;

    /**
     * Specification:
     * - Returns whether the method is with void return type.
     *
     * @api
     *
     * @param string $foo
     *
     * @return void
     */
    public function methodReturnsVoid(string $foo): void;

    /**
     * Specification:
     * - Returns `FooBar` transfer object.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer $zipZapTransfer
     *
     * @return \Generated\Shared\Transfer\FooBarTransfer
     */
    public function methodWithTransferInputAndTransferOutput(ZipZapTransfer $zipZapTransfer): FooBarTransfer;

    /**
     * Specification:
     * - Returns whether the method is with default nullable value.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ZipZapTransfer|null $zipZapTransfer
     *
     * @return bool
     */
    public function methodWithDefaultNull(?ZipZapTransfer $zipZapTransfer = null): bool;

    /**
     * Specification:
     * - Returns whether the method is with default array value.
     *
     * @api
     *
     * @param array $foo
     *
     * @return bool
     */
    public function methodWithDefaultArray(array $foo = []): bool;

    /**
     * Specification:
     * - Returns whether the method is without return type.
     *
     * @api
     *
     * @return void
     */
    public function methodWithoutMethodReturnType(): void;

    /**
     * Specification:
     * - Returns whether the method is without doc block return type.
     *
     * @api
     *
     * @return
     */
    public function methodWithoutDocBlockReturnType(): void;

    /**
     * Specification:
     * - Returns whether the method is with multiple return type.
     *
     * @api
     *
     * @return string|int
     */
    public function methodWithMultipleReturn();

    /**
     * Specification:
     * - Returns whether the method is with multiple and nullable return type.
     *
     * @api
     *
     * @return string|int|null
     */
    public function methodWithMultipleReturnAndNullable();

    /**
     * Specification:
     * - Returns whether the method is with nullable return type.
     *
     * @api
     *
     * @return string|null
     */
    public function methodWithNullableReturn(): ?string;
}
