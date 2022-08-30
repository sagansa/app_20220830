<?php

namespace App\Http\Livewire\DataTables;

trait WithSortingName
{
    public $sortField = 'name';
    public $sortDirection = 'asc';

    public function sortByColumn($column)
    {
        if ($this->sortColumn == $column) {
            $this->sortDirection = $this->sortDirection == 'asc' ? 'desc' : 'asc';
        } else {
            $this->reset('sortDirection');
            $this->sortColumn = $column;
        }
    }

    public function applySorting($query)
    {
        return $query->orderBy($this->sortColumn, $this->sortDirection);
    }
}
