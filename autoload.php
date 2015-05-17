<?php

function __autoload($class_name)
{
    $class_name = str_replace("\\", "/", $class_name);

    if (substr($class_name, strlen($class_name) - strlen("Test")) == "Test")
    {
        $file = "../resources/test/php/" . $class_name . ".php";
        require $file;
    }
    else
    {
        $file = "../resources/main/php/" . $class_name . ".php";
        require $file;
    }
}