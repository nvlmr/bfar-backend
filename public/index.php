<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* ================= ROOT PATH ================= */

define('ROOT_PATH', dirname(__DIR__));

/* ================= CONFIG ================= */

require_once ROOT_PATH . '/app/config/config.php';

/* ================= AUTOLOAD CLASSES ================= */

spl_autoload_register(function ($className) {

    $directories = [
        '/app/core/',
        '/app/controllers/',
        '/app/models/',
        '/app/middleware/',
        '/app/services/',
    ];

    foreach ($directories as $dir) {
        $file = ROOT_PATH . $dir . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/* ================= LOAD HELPERS ================= */

foreach (glob(ROOT_PATH . '/app/helpers/*.php') as $helper) {
    require_once $helper;
}

/* ================= ROUTES ================= */

require_once ROOT_PATH . '/app/config/routes.php';

/* ================= CLEAN URL ================= */

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $url);
$url = trim($url, '/');

/* ================= DISPATCH ================= */

$router->dispatch($url);