<?php

namespace vendor\core\base;

class View
{

    public array $route; // текущий маршрут и параметры (controller, action, params)
    public $layout;      // текущий шаблон
    public $view;        // текущий вид

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        $this->layout = $layout;
        $this->view = $view;
    }

    public function render($vars): void
    {
        if (is_array($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }

        $fileView = APP . "/views/{$this->route['controller']}/$this->view.php";

        $uri = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($uri);

        if (isset($uri[1])) {
            $uri = explode('?', $uri[1]);
        }

        $uri = $uri[0];

        if (COMPRESS_PAGE === 1) {
            ob_start([$this, "compressPage"]);
        } else {
            ob_start();
        }

        if (is_file($fileView)) {
            require_once $fileView;
        } else {
            include WWW . '/404.php';
        }

        $content = ob_get_contents();
        ob_clean();

        if (false !== $this->layout) {
            $fileLayout = APP . "/views/layouts/$this->layout.php";
            if (is_file($fileLayout)) {
                $route = $this->route;
                require_once $fileLayout;
            } else {
                include WWW . '/404.php';
            }
        }
    }

    /**
     * Сжатие HTML в одну строчку
     *
     * @param $buffer
     *
     * @return array|string|string[]|null
     */
    protected function compressPage($buffer): array|string|null
    {
        $search = [
            '/>[^\S ]+/',        // strip whitespaces after tags, except space
            '/[^\S ]+</',        // strip whitespaces before tags, except space
            '/(\s)+/',           // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/', // Remove HTML comments
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            '',
        ];

        return preg_replace($search, $replace, $buffer);
    }

}
