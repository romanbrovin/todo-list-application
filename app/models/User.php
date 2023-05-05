<?php

namespace app\models;

use vendor\core\base\Model;

class User extends Model
{
    protected static string $adminName = 'admin';
    protected static string $adminPassword = '123';

    public array $vars = [
        'name' => ['type' => 'string', 'lenght' => 250],
        'password' => ['type' => 'string', 'lenght' => 250],
    ];

    public function login(): void
    {
        $_SESSION['admin'] = 1;
    }

    public function validateAdmin()
    {
        if ($this->vars['name'] === self::$adminName && $this->vars['password'] === self::$adminPassword) {
            return true;
        }

        $this->errors[] = 'auth';
    }
}