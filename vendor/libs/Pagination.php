<?php

namespace vendor\libs;

class Pagination
{
    public const PER_PAGE = 3;

    public int $currentPage;
    public int $perPage;
    public int $countPages;
    public int $totalEntries;  // все записей из БД
    public string $uri;

    public function __construct($totalEntries)
    {
        $this->perPage = self::getPerPage();
        $this->totalEntries = $totalEntries;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage();
        $this->uri = $this->getParams();
    }

    /**
     * Кол-во записей на одной странице в каталоге
     */
    protected static function getPerPage(): int
    {
        return self::PER_PAGE;
    }

    protected function getCountPages(): int
    {
        return ceil($this->totalEntries / $this->perPage) ?: 1;
    }

    protected function getCurrentPage(): int
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        if (!$page || $page < 1) {
            $page = 1;
        }
        if ($page > $this->countPages) {
            $page = $this->countPages;
        }

        return $page;
    }

    protected function getParams(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0] . '?';

        if (isset($url[1]) && $url[1] !== '') {
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!str_contains($param, "page=")) {
                    $uri .= "$param&amp;";
                }
            }
        }

        return $uri;
    }

    public function __toString()
    {
        return $this->getHtml();
    }

    protected function getHtml(): string
    {
        $back =
        $forward =
        $startPage =
        $endPage =
        $page2left =
        $page1left =
        $page2right =
        $page1right =
        $separatorLeft =
        $separatorRight = null;

        $currentPage = '
            <li class="page-item active">
                <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip" 
                data-bs-title="Текущая страница" class="page-link">
                    ' . $this->currentPage . '
                </a>
            </li>';

        if ($this->currentPage > 1 && $this->countPages > 5) {
            $href = $this->uri . 'page=' . ($this->currentPage - 1);
            $back = '
                <li class="page-item">
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip" 
                    data-bs-title="Предыдущая страница" class="page-link" href="' . $href . '">
                        ←
                    </a>
                </li>';
        }

        if ($this->currentPage < $this->countPages && $this->countPages > 5) {
            $href = $this->uri . 'page=' . ($this->currentPage + 1);
            $forward = '
                <li class="page-item">
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip" 
                    data-bs-title="Следующая страница" class="page-link" href="' . $href . '">
                        →
                    </a>
                </li>';
        }

        if ($this->currentPage > 3) {
            $href = $this->uri . 'page=1';
            $startPage = '
                <li class="page-item">
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip" 
                    data-bs-title="Первая страница" class="page-link" href="' . $href . '">
                        1
                    </a>
                </li>';
        }

        if ($this->currentPage < ($this->countPages - 2)) {
            $href = $this->uri . 'page=' . $this->countPages;
            $endPage = '
                <li class="page-item">
                    <a data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip" 
                    data-bs-title="Последняя страница" class="page-link" href="' . $href . '">
                        ' . $this->countPages . '
                    </a>
                </li>';
        }

        if ($this->currentPage - 2 > 0) {
            $href = $this->uri . 'page=' . ($this->currentPage - 2);
            $page2left = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        ' . ($this->currentPage - 2) . '
                    </a>
                </li>';
        }

        if ($this->currentPage - 1 > 0) {
            $href = $this->uri . 'page=' . ($this->currentPage - 1);
            $page1left = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        ' . ($this->currentPage - 1) . '
                    </a>
                </li>';
        }

        if ($this->currentPage + 1 <= $this->countPages) {
            $href = $this->uri . 'page=' . ($this->currentPage + 1);
            $page1right = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        ' . ($this->currentPage + 1) . '
                    </a>
                </li>';
        }

        if ($this->currentPage + 2 <= $this->countPages) {
            $href = $this->uri . 'page=' . ($this->currentPage + 2);
            $page2right = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        ' . ($this->currentPage + 2) . '
                    </a>
                </li>';
        }

        if ($this->currentPage - 4 > 0) {
            $separatorLeft = '<li class="page-item disabled"><a class="page-link">...</a></li>';
        }

        if ($this->currentPage - 4 === 1) {
            $href = $this->uri . 'page=2';
            $separatorLeft = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        2
                    </a>
                </li>';
        }

        if ($this->currentPage + 4 <= $this->countPages) {
            $separatorRight = '<li class="page-item disabled"><a class="page-link">...</a></li>';
        }

        if ($this->currentPage + 4 === $this->countPages) {
            $href = $this->uri . 'page=' . ($this->countPages - 1);
            $separatorRight = '
                <li class="page-item">
                    <a class="page-link" href="' . $href . '">
                        ' . ($this->countPages - 1) . '
                    </a>
                </li>';
        }

        return
            '<ul class="pagination justify-content-center mt-5">' .
            $back . $startPage . $separatorLeft .
            $page2left . $page1left . $currentPage . $page1right . $page2right .
            $separatorRight . $endPage . $forward .
            '</ul>';
    }

    public function getLimitStart(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

}