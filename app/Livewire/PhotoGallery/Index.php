<?php

namespace App\Livewire\PhotoGallery;

use App\Models\PhotoGallary;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selected = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        PhotoGallary::find($id)->delete();
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Record deleted successfully.'
        ]));
    }

    public function render()
    {
        return view('livewire.photo-gallery.index', [
            'galleries' => PhotoGallary::with('media')
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%'.$this->search.'%')
                          ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'trashedCount' => PhotoGallary::onlyTrashed()->count(),
        ]);
    }
}
