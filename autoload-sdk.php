<?php

$autoloader = function ($className) {

    $moduleFilter = function (string $value) {
        $filterChain = new \Zend\Filter\FilterChain();
        $filterChain
            ->attach(new \Zend\Filter\Word\CamelCaseToDash())
            ->attach(new \Zend\Filter\StringToLower());

        return $filterChain->filter($value);
    };

    $namespaces = [
        'SprykerSdk',
    ];

    $codeceptionSupportDirectories = [
        'Helper',
        'Module',
    ];

    $testingNamespaces = [
        'SprykerSdkTest'
    ];

    $className = ltrim($className, '\\');
    $classNameParts = explode('\\', $className);

    if (count($classNameParts) < 3) {
        return false;
    }

    if (!in_array($classNameParts[0], $namespaces)
        && !in_array($classNameParts[1], $codeceptionSupportDirectories)
        && !in_array($classNameParts[0], $testingNamespaces)) {
        return false;
    }

    if (in_array($classNameParts[0], $namespaces)) {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        $module = $classNameParts[2];
        $filePathParts = [
            __DIR__ . '/..',
            $moduleFilter($module),
            'src',
            $className,
        ];
    }

    if (in_array($classNameParts[0], $testingNamespaces)) {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        $module = $classNameParts[2];
        $filePathParts = [
            __DIR__ . '/..',
            $moduleFilter($module),
            'tests',
            $className,
        ];
    }

    if (in_array($classNameParts[1], $codeceptionSupportDirectories)) {
        $module = array_shift($classNameParts);
        $className = implode(DIRECTORY_SEPARATOR, $classNameParts) . '.php';
        $filePathParts = [
            __DIR__ . '/..',
            $moduleFilter($module),
            'tests',
            '_support',
            $className,
        ];
    }

    if (isset($filePathParts)) {
        $filePath = implode(DIRECTORY_SEPARATOR, $filePathParts);
        if (file_exists($filePath)) {
            include($filePath);

            return true;
        }

        if (isset($filePathPartsHelper)) {
            $filePath = implode(DIRECTORY_SEPARATOR, $filePathPartsHelper);
            if (file_exists($filePath)) {
                include($filePath);

                return true;
            }
        }
    }

    return false;
};

spl_autoload_register($autoloader);
