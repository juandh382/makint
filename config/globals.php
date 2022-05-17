<?php
define("base_url", "http://localhost/makint");
define("controller_default", "MainController");
define("action_default", "init");

$_SESSION['paginatorData'] = [
    'url' => '',
    'current' => 0,
    'currentSection' => '',
    'total' => 0,
    'counter' => 1,
    'max' => 1,
    'sections' => []
];