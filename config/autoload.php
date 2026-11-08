<?php

spl_autoload_register(function ($classname) {
    $file =  __DIR__ . '/../src/' . $classname . '.php';

    require_once $file;
});
