<?php

function modifyDatesInArray($array)
{
    foreach ($array as $key => $value) {
        if (str_contains($key, '_at')) {
            $array[$key] = date_format(date_create($value), 'd.m.Y H:i:s');
        } else {
            $array[$key] = $value;
        }
    }

    return $array;
}

function redirect($http = false): void
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
    }

    header("Location: $redirect");
    exit;
}

function isAdmin(): bool
{
    return isset($_SESSION['admin']);
}

function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

/**
 * Проверка токена
 *
 * @return bool
 */
function isToken(): bool
{
    return isset($_POST['token2']) && $_POST['token2'] === $_SESSION['token1'];
}

function filterString($var): string
{
    return htmlspecialchars(trim($var), ENT_QUOTES);
}

function filterEmail($var): string
{
    return filter_var(trim($var), FILTER_VALIDATE_EMAIL);
}

function filterInt($var)
{
    return filter_var(trim($var), FILTER_VALIDATE_INT);
}
