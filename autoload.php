<?php

//echo "\nIncluding autoload.php\n";

function __autoload($class_name)
{
    if (substr($class_name, strlen($class_name) - strlen("Test")) == "Test")
    {
        $file = "../resources/test/php/" . $class_name . ".php";
        //echo "\nAutoloading test file: " . $file . "\n";
        require_once($file);
    }
    else
    {
        $file = "../resources/main/php/" . $class_name . ".php";
        //echo "\nAutoloading main file: " . $file . "\n";
        require $file;
    }
}