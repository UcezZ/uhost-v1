<?php

class SearchParams
{
    private int $page, $perpage;
    private bool $own;

    public function __construct()
    {
        $this->page = 1;
        $this->perpage = 8;
        $this->own = false;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perpage;
    }

    public function getOwn()
    {
        return $this->own;
    }

    public function setPage(int $page)
    {
        $this->page = $page < 1 ? 1 : $page;
        return $this;
    }

    public function setPerPage(int $perpage)
    {
        $this->perpage = $perpage < 1 ? 1 : ($perpage > 255 ? 255 : $perpage);
        return $this;
    }

    public function setOwn(bool $own)
    {
        $this->own = $own;
        return $this;
    }
}
