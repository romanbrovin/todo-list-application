<?php

namespace vendor\core;

class Router
{
    protected static array $route;  // Текущий маршрут
    protected static array $routes; // Таблица маршрутов

    /**
     * Добавляет маршрут в таблицу
     *
     * @param string $regexp Регулярное выражение маршрута
     * @param array $route Маршрут [controller, action, params]
     */
    public static function add(string $regexp, array $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * Перенаправляет URL по корректному маршруту
     */
    public static function dispatch(string $url): void
    {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action']) . 'Action';
                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    include WWW . '/404.php';
                }
            } else {
                include WWW . '/404.php';
            }
        } else {
            include WWW . '/404.php';
        }
    }

    /**
     * Возвращает строку без GET параметров
     */
    protected static function removeQueryString(string $url): string
    {
        if ($url) {
            $params = explode('?', $url);

            return !strpos($params[0], '=') ? rtrim($params[0], '/') : '';
        }

        return '';
    }

    /**
     * Ищет URL в таблице маршрутов
     */
    protected static function matchRoute(string $url): bool
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("~$pattern~i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                return true;
            }
        }

        return false;
    }

    /**
     * Преобразует имена к виду CamelCase
     */
    protected static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }

    /**
     * Преобразует имена к виду camelCase
     */
    protected static function lowerCamelCase(string $name): string
    {
        return lcfirst(self::upperCamelCase($name));
    }

}
