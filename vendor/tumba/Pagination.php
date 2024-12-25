<?php

namespace tumba;

class Pagination
{
    public int $currentPage;
    public int $perPage;
    public int $totalElements;
    public int $countPages;
    public string $uri;

    public function __construct($page, $perPage, $totalElements)
    {
        $this->perPage = $perPage;
        $this->totalElements = $totalElements;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage($page);
        $this->uri = $this->getParams();
    }

    public function __toString(): string
    {
        return $this->getHTML();
    }

    private function getCountPages(): int
    {
        return ceil($this->totalElements / $this->perPage) ?: 1;
    }

    private function getCurrentPage($page): int
    {
        if (!$page || $page < 1) {
            $page = 1;
        } elseif ($page > $this->countPages) {
            $page = $this->countPages;
        }
        return $page;
    }

    private function getParams()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $uri = $url[0];
        if (isset($url[1]) && $url[1] != '') {
            $uri .= '?';
            $params = explode('&', $url[1]);
            foreach ($params as $param) {
                if (!(preg_match("#page=#", $param))) {
                    $uri .= "{$param}&";
                }
            }
        }
        return $uri;
    }

    public function getHTML()
    {
        $back = null; // ссылка НАЗАД
        $forward = null; // ссылка ВПЕРЕД
        $startPage = null; // ссылка В НАЧАЛО
        $endPage = null; // ссылка В КОНЕЦ
        $page3left = null; // 3 страница слева
        $page2left = null; // 2 страница слева
        $page1left = null; // 1 страница слева
        $page3right = null; // 3 страница справа
        $page2right = null; // 2 страница справа
        $page1right = null; // 1 страница справа

        // $back
        if ($this->currentPage > 1) {
            $back = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage - 1) . "'>&lt;</a></li>";
        } else {
            $back = "<li class='page-item disabled'><a class='page-link' href=''>&lt;</a></li>";
        }

        // $forward
        if ($this->currentPage < $this->countPages) {
            $forward = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage + 1) . "'>&gt;</a></li>";
        } else {
            $forward = "<li class='page-item disabled'><a class='page-link' href=''>&gt;</a></li>";
        }

        // $startPage
        if ($this->currentPage > 1) {
            $startPage = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink(1) . "'>&laquo;</a></li>";
        } else {
            $startPage = "<li class='page-item disabled'><a class='page-link' href=''>&laquo;</a></li>";
        }

        // $endPage
        if ($this->currentPage < $this->countPages) {
            $endPage = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->countPages) . "'>&raquo;</a></li>";
        } else {
            $endPage = "<li class='page-item disabled'><a class='page-link' href=''>&raquo;</a></li>";
        }

        // $page3left
        if ($this->currentPage - 3 > 0) {
            $page3left = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage - 3) . "'>"
                . ($this->currentPage - 3) . "</a></li>";
        }

        // $page2left
        if ($this->currentPage - 2 > 0) {
            $page2left = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage - 2) . "'>"
                . ($this->currentPage - 2) . "</a></li>";
        }

        // $page1left
        if ($this->currentPage - 1 > 0) {
            $page1left = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage - 1) . "'>"
                . ($this->currentPage - 1) . "</a></li>";
        }

        // $page1right
        if ($this->currentPage + 1 <= $this->countPages) {
            $page1right = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage + 1) . "'>"
                . ($this->currentPage + 1) . "</a></li>";
        }

        // $page2right
        if ($this->currentPage + 2 <= $this->countPages) {
            $page2right = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage + 2) . "'>"
                . ($this->currentPage + 2) . "</a></li>";
        }

        // $page3right
        if ($this->currentPage + 3 <= $this->countPages) {
            $page3right = "<li class='page-item'><a class='page-link' href='"
                . $this->getLink($this->currentPage + 3) . "'>"
                . ($this->currentPage + 3) . "</a></li>";
        }

        return '<nav aria-label="Page navigation example"><ul class="pagination">'
            . $startPage . $back . $page3left . $page2left . $page1left
            . '<li class="page-item active"><a class="page-link">'
            . $this->currentPage . '</a></li>' . $page1right . $page2right . $page3right . $forward . $endPage . '</ul></nav>';
    }


    public function getStart(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function getLink($page)
    {
        if ($page == 1) {
            return rtrim($this->uri, '?&');
        }

        if (str_contains($this->uri, '&')) {
            return $this->uri . 'page=' . $page;
        } else {
            if (str_contains($this->uri, '?')) {
                return $this->uri . 'page=' . $page;
            } else {
                return $this->uri . '?page=' . $page;
            }
        }
    }
}