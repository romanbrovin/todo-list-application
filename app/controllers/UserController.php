<?php

namespace app\controllers;

use app\models\User;
use JsonException;
use vendor\core\base\Controller;

class UserController extends Controller
{
    public function authAction(): void
    {
        if (isAdmin()) {
            redirect('/');
        }

        $this->title = "Авторизация";

        $meta = $this->getMeta();
        $this->set(compact(['meta']));
    }

    /**
     * @throws JsonException
     */
    public function loginAction(): void
    {
        $this->obj = new User();
        $this->obj->loadVars($_REQUEST);

        $this->validateAjaxAndToken();

        $this->obj->requiredVars = [
            'name',
            'password',
        ];

        if ($this->obj->validateRequiredVars() && $this->obj->validateAdmin()) {
            $this->obj->login();
            $this->obj->response();
        }

        $this->obj->responseError();
    }

    public function logoutAction(): void
    {
        session_destroy();
        redirect('/');
    }

}
