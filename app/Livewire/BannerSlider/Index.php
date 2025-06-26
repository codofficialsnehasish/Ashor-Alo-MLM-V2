<?php

namespace App\Livewire\BannerSlider;

use App\Models\BannerSlider;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;

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

    protected function checkPermission($permission)
    {
        if (!Gate::allows($permission)) {
            abort(403, 'Unauthorized action.');
        }
    }


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
        $this->checkPermission('Delete Photo Gallery');

        BannerSlider::find($id)->delete();
        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Record deleted successfully.'
        ]));
    }

    public function render()
    {
        $this->checkPermission('Show Photo Gallery');
        return view('livewire.banner-slider.index', [
            'galleries' => BannerSlider::with('media')
                ->when($this->search, function ($query) {
                    $query->where('title', 'like', '%'.$this->search.'%')
                          ->orWhere('description', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage),
            'trashedCount' => BannerSlider::onlyTrashed()->count(),
        ]);
    }
}
