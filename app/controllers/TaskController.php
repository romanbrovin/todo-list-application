<?php

namespace app\controllers;

use app\models\Task;
use JsonException;
use RedBeanPHP\RedException\SQL;
use vendor\core\base\Controller;
use vendor\libs\Pagination;

class TaskController extends Controller
{
    public function indexAction(): void
    {
        $totalEntries = Task::getCountOfItems();

        $pagination = new Pagination($totalEntries);
        $limitStart = $pagination->getLimitStart();
        $perPage = $pagination->perPage;

        $tasks = Task::getAllItems($limitStart, $perPage);

        $sort = Task::sortOnPage();

        $this->title = 'ToDo App';

        if ($pagination->currentPage > 1) {
            $this->title .= ' | Страница ' . $pagination->currentPage;
        }

        $meta = $this->getMeta();
        $this->set(compact(['meta', 'tasks', 'sort', 'pagination']));
    }

    public function addAction(): void
    {
        $meta = $this->getMeta();
        $this->set(compact(['meta',]));

    }

    public function editAction(): void
    {
        $this->obj = new Task();
        $this->obj->loadVars($_REQUEST);

        $this->obj = $this->obj->getItemById();

        if ((int)$this->obj['id'] < 1) {
            redirect('/');
        }

        $this->obj = modifyDatesInArray($this->obj);

        $item = $this->obj;

        $this->title = "Редактирование";

        $meta = $this->getMeta();
        $this->set(compact(['meta', 'item']));
    }

    /**
     * @throws SQL
     * @throws JsonException
     */
    public function createAction(): void
    {
        $this->validateAjaxAndToken();

        $this->obj = new Task();
        $this->obj->loadVars($_REQUEST);

        $this->obj->requiredVars = [
            'email',
        ];

        if ($this->obj->validateRequiredVars()) {
            $this->obj->create();
            $this->obj->response();
        }

        $this->obj->responseError();
    }

    /**
     * @throws SQL
     * @throws JsonException
     */
    public function saveAction(): void
    {
        $this->validateAjaxAndToken();

        if (!isAdmin()) {
            redirect('/login');
        }

        $this->obj = new Task();
        $this->obj->loadVars($_REQUEST);

        if ($this->obj->validateRequiredVars()) {
            $this->obj->save();
            $this->obj->response();
        }

        $this->obj->responseError();
    }

    /**
     * @throws SQL
     */
    public function doneAction(): void
    {
        $this->validateAjaxAndToken();

        $this->obj = new Task();
        $this->obj->loadVars($_REQUEST);

        $this->obj->done();
        $this->obj->response();
    }

}