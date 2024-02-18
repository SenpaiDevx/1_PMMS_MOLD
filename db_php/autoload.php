<?php
spl_autoload_register(function ($class) {
    require __DIR__ . "/html_php/" . $class . ".php";
});