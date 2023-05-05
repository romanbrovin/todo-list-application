<?php

use vendor\core\Router;

$query = trim($_SERVER['REQUEST_URI'], '/');

define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__) . '/app');
define("WWW", dirname(__DIR__) . '/public');
define('CORE', dirname(__DIR__) . '/vendor/core');
define('LIBS', dirname(__DIR__) . '/vendor/libs');

const LAYOUT = 'default'; // основной шаблон
const COMPRESS_PAGE = 1;  // сжатие html кода
const DB_DEBUG = 0;       // режим дебага базы данных
const DB_LOCAL = 1;       // база данных 1-локальная 0-серверная

require LIBS . '/functions.php';

session_start();


spl_autoload_register(static function ($class) {
    $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});


Router::add('^$', ['controller' => 'Task', 'action' => 'index']);
Router::add('^done$', ['controller' => 'Task', 'action' => 'done']);

Router::add('^add$', ['controller' => 'Task', 'action' => 'add']);
Router::add('^create$', ['controller' => 'Task', 'action' => 'create']);
Router::add('^edit$', ['controller' => 'Task', 'action' => 'edit']);
Router::add('^save$', ['controller' => 'Task', 'action' => 'save']);

Router::add('^login$', ['controller' => 'User', 'action' => 'login']);
Router::add('^logout$', ['controller' => 'User', 'action' => 'logout']);
Router::add('^auth$', ['controller' => 'User', 'action' => 'auth']);

// Запуск
Router::dispatch($query);