<?php

namespace vendor\core\base;

use JsonException;
use vendor\core\Db;

class Model
{

    public array $errors = [];
    public array $vars = [];
    public array $requiredVars = [];
    protected Db $pdo;

    public function __construct()
    {
        $this->pdo = Db::instance();
    }

    /**
     * Получение и фильтрация входящих переменных
     *
     * @param $data
     * @return void
     */
    public function loadVars($data): void
    {
        foreach ($this->vars as $name => $value) {

            if (isset($data[$name])) {

                // вызов функции очистки переменной
                $funcName = 'filter' . ucfirst($value['type']);
                $this->vars[$name] = $funcName($data[$name]);

                // обрезаем переменную по заданной длине
                if (isset($value['lenght'])) {
                    $type = gettype($this->vars[$name]); // тип переменной

                    if ($type === 'integer') {
                        $this->vars[$name] = (int)mb_substr($this->vars[$name], 0, $value['lenght']);
                    } else {
                        $this->vars[$name] = mb_substr($this->vars[$name], 0, $value['lenght']);
                    }
                }
            }
        }
    }

    public function validateRequiredVars(): bool
    {
        foreach ($this->requiredVars as $name) {
            $type = gettype($this->vars[$name]);

            if ($type === 'integer') {
                if ($this->vars[$name] < 0) {
                    $this->errors[] = $name;
                }
            } elseif ($this->vars[$name] === '' || is_array($this->vars[$name])) {
                $this->errors[] = $name;
            }
        }

        if ($this->errors) {
            return false;
        }

        return true;
    }


    public function response($response = 'ok'): void
    {
        echo $response;
        exit;
    }

    /**
     * @throws JsonException
     */
    public function responseError($error = ''): void
    {
        if ($error === '') {
            echo json_encode($this->errors, JSON_THROW_ON_ERROR);
        } else {
            echo json_encode($error, JSON_THROW_ON_ERROR);
        }

        exit;
    }

}

