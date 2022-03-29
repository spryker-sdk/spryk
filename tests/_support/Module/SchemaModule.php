<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;

class SchemaModule extends Module
{
    /**
     * @param string $pathToPersistenceFile
     *
     * @return void
     */
    public function havePersistenceFileWithTable(string $pathToPersistenceFile): void
    {
        $persistenceSchemaTable = '<?xml version="1.0"?>
            <database xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" name="zed" xsi:noNamespaceSchemaLocation="http://static.spryker.com/schema-01.xsd" namespace="Orm\Zed\FooBar\Persistence" package="src.Orm.Zed.FooBar.Persistence">
                  <table name="spy_foo_bar" idMethod="native" class="FooBar">
                  </table>
            </database>';

        $directory = dirname($pathToPersistenceFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($pathToPersistenceFile, $persistenceSchemaTable);
    }
}
