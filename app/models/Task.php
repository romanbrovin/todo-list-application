<?php

namespace app\models;

use R;
use RedBeanPHP\RedException\SQL;
use vendor\core\base\Model;

class Task extends Model
{
    public array $vars = [
        'id' => ['type' => 'int', 'lenght' => 9],
        'name' => ['type' => 'string', 'lenght' => 250],
        'email' => ['type' => 'email', 'lenght' => 250],
        'text' => ['type' => 'string', 'lenght' => 250],
    ];

    public static function getCountOfItems(): int
    {
        return R::count('m_task');
    }

    public static function getAllItems(int $limitStart, int $perPage): array
    {
        $query = "
            SELECT 
                id, 
                name, 
                email, 
                text, 
                is_done, 
                is_update
            FROM m_task
            ORDER BY " . self::getQueryOrder() . "
            LIMIT $limitStart, $perPage";

        return R::getAll($query);
    }

    /**
     * Порядок сортировки
     */
    public static function getQueryOrder(string $name = ''): string
    {

        $q = (isset($_GET['q'])) ? filterString($_GET['q']) : null;

        if ($q === 'name_down') {
            $queryOrder = 'name DESC';
        } elseif ($q === 'name_up') {
            $queryOrder = 'name ASC';
        } elseif ($q === 'email_down') {
            $queryOrder = 'email DESC';
        } elseif ($q === 'email_up') {
            $queryOrder = 'email ASC';
        } elseif ($q === 'is_done_down') {
            $queryOrder = 'is_done DESC';
        } elseif ($q === 'is_done_up') {
            $queryOrder = 'is_done ASC';
        } else {
            $queryOrder = 'id DESC';
        }

        return $queryOrder;
    }

    /**
     * Сортировка в каталоге
     */
    public static function sortOnPage(): array
    {
        $var = [];

        $var['sortQuery'] = (isset($_GET['q'])) ? filterString($_GET['q']) : null;

        // Поля для поиска
        $var['searchFields'] = [
            ['query' => 'name', 'name' => 'имя пользователя',],
            ['query' => 'email', 'name' => 'email',],
            ['query' => 'is_done', 'name' => 'статус',],
        ];

        // Переменные для поиска
        foreach ($var['searchFields'] as $value) {
            // Заполняем data-query значениями (ex.: price_down)
            $var['query_' . $value['query']] = $value['query'] . '_down';
            // Иконка у текста (по умолчанию ее нет)
            $var['arrow_' . $value['query']] = null;
        }

        // Идет сортировка
        if ($var['sortQuery']) {
            $pos = strpos($var['sortQuery'], '_up');
            if ($pos !== false) { // если совпадение найдено
                $query_str = str_replace('_up', '', $var['sortQuery']);
                ${'query_' . $query_str} = $query_str . '_down';
                ${'arrow_' . $query_str} = '▲';
            } else {
                $query_str = str_replace('_down', '', $var['sortQuery']);
                ${'query_' . $query_str} = $query_str . '_up';
                ${'arrow_' . $query_str} = '▼';
            }

            $var['query_' . $query_str] = ${'query_' . $query_str};
            $var['arrow_' . $query_str] = ${'arrow_' . $query_str};
        }

        return $var;
    }

    public function getItemById(): array
    {
        return R::load('m_task', $this->vars['id'])->export();
    }

    /**
     * @throws SQL
     */
    public function create(): void
    {
        $obj = R::dispense('m_task');

        $obj['created_at'] = date('Y-m-d H:i:s');
        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['name'] = $this->vars['name'];
        $obj['email'] = $this->vars['email'];
        $obj['text'] = $this->vars['text'];

        R::store($obj);
    }

    /**
     * @throws SQL
     */
    public function save(): void
    {
        $obj = R::load('m_task', $this->vars['id']);

        $obj['updated_at'] = date('Y-m-d H:i:s');
        $obj['text'] = $this->vars['text'];
        $obj['is_update'] = 1;

        R::store($obj);
    }

    /**
     * @throws SQL
     */
    public function done(): void
    {
        $obj = R::load('m_task', $this->vars['id']);

        $obj['is_done'] = ((int)$obj['is_done'] === 0) ? 1 : 0;

        R::store($obj);
    }
}