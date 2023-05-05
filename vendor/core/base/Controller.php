<?php

namespace vendor\core\base;

abstract class Controller
{
    public string $view; // вид
    public string $layout = LAYOUT; // текущий шаблон
    public array $route = []; // текущий маршрут и параметры (controller, action, params)
    public array $vars = []; // пользовательские данные
    public string $title = ''; // Заголовок страницы
    public $obj;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];

        new Model();
    }

    public function getMeta(): array
    {
        return [
            'route' => $this->route,
            'title' => $this->title,
        ];
    }

    /**
     * @return void
     */
    public function getView(): void
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars): void
    {
        $this->vars = $vars;
    }

    /**
     * Валидация запроса к странице.
     * Должны совпадать токены и запрос должен быть сделан ajax
     *
     * @return void
     */
    public function validateAjaxAndToken(): void
    {
        if (!isAjax() || !isToken()) {
            include WWW . '/404.php';
            exit;
        }
    }

}
