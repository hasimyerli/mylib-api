<?php


namespace App\Model;


use App\Constant\FilterConstant;
use App\Enum\Sort;

class BaseFilterModel
{
    private int $limit = FilterConstant::DEFAULT_LIMIT;
    private string $order = '';
    private int $page = 1;
    private string $searchText = '';
    private string $sort = Sort::DESCENDING;

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    public function getSearchText(): ?string
    {
        return $this->searchText;
    }

    public function setSearchText(string $searchText): void
    {
        $this->searchText = $searchText;
    }

    public function getOffset()
    {
        return $this->getLimit() * ($this->getPage() - 1);
    }
}