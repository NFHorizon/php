<?php

spl_autoload_register(function (string $className): void {
    $prefix = 'LogicToolkit\\';

    if (strpos($className, $prefix) !== 0) {
        return;
    }

    $relativeClass = substr($className, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($path)) {
        require $path;
    }
});
