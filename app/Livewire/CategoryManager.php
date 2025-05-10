<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Validation\Rule;

use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

use App\Exports\CategoriesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class CategoryManager extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $parentcategories;
    public $categoryId, $name, $description, $parent_id, $is_visible = 1;
    public $isEdit = false;
    public $search = '';

    public function render()
    {
        $this->parentcategories = Category::with('parent')->latest()->get();
        $query = Category::query()->with('parent');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        return view('livewire.category-manager', [
            'categories' => $query->paginate(10)
        ]);
    }

    public function resetForm()
    {
        $this->reset(['categoryId', 'name', 'description', 'parent_id', 'is_visible', 'isEdit']);
        $this->is_visible = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|unique:categories,name',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'is_visible' => 'integer',
        ]);

        Category::create($this->only(['name', 'description', 'parent_id', 'is_visible']));

        session()->flash('success', 'Category created successfully.');
        $this->resetForm();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->is_visible = $category->is_visible;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate([
            'name' => ['required', Rule::unique('categories', 'name')->ignore($this->categoryId)],
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id',
            'is_visible' => 'integer',
        ]);

        $category = Category::findOrFail($this->categoryId);
        $category->update($this->only(['name', 'description', 'parent_id', 'is_visible']));

        session()->flash('success', 'Category updated successfully.');
        $this->resetForm();
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Category deleted successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new CategoriesExport, 'categories.xlsx');
    }

    public function exportPDF()
    {
        $categories = Category::select('name', 'description', 'is_visible')->get();

        $pdf = Pdf::loadView('exports.categories-pdf', ['categories' => $categories]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'categories.pdf');
    }
}
