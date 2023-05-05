<?php

$host = 'localhost';

if (DB_LOCAL === 1) {
    $dbname = '';
    $user = '';
    $pass = '';
}
else {
    $dbname = '';
    $user = '';
    $pass = '';
}

return [
    'dsn'  => 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8',
    'user' => $user,
    'pass' => $pass,
];
