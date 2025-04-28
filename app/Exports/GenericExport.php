<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class GenericExport implements FromCollection
{
    protected $model, $search, $columns;

    public function __construct($model, $search, $columns)
    {
        $this->model = $model;
        $this->search = $search;
        $this->columns = $columns;
    }

    public function collection()
    {
        return $this->model::query()
            ->when($this->search, function ($q) {
                foreach ($this->columns as $col) {
                    $q->orWhere($col, 'like', '%' . $this->search . '%');
                }
            })
            ->get();
    }
}
