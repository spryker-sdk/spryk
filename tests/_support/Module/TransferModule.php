<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;

class TransferModule extends Module
{
    /**
     * @param string $pathToTransferFile
     * @param string $transferName
     *
     * @return void
     */
    public function haveTransferSchemaFileWithTransferAndExistingProperty(string $pathToTransferFile, string $transferName): void
    {
        $transferSchema = sprintf('<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBar">
    <property name="something" type="string" />
  </transfer>

  <transfer name="%s">
    <property name="testProperty" type="string" />
  </transfer>

</transfers>', $transferName);

        $directory = dirname($pathToTransferFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($pathToTransferFile, $transferSchema);
    }

    /**
     * @param string $pathToTransferFile
     * @param string $transferName
     *
     * @return void
     */
    public function haveTransferSchemaFileWithTransfer(string $pathToTransferFile, string $transferName): void
    {
        $transferSchema = sprintf('<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBar">
    <property name="something" type="string" />
  </transfer>

  <transfer name="%s">
  </transfer>

</transfers>', $transferName);

        $directory = dirname($pathToTransferFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($pathToTransferFile, $transferSchema);
    }
}
