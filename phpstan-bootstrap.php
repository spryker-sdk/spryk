<?php

define('APPLICATION_ROOT_DIR', __DIR__);

require_once(__DIR__ . '/vendor/codeception/codeception/autoload.php');
require_once(__DIR__ . '/vendor/autoload.php');

$codeceptionShimFilePath = __DIR__ . '/vendor/codeception/stub/src/shim.php';
if (file_exists($codeceptionShimFilePath)) {
    require_once($codeceptionShimFilePath);
}
