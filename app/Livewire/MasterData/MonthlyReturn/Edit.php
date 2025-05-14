<?php

namespace App\Livewire\MasterData\MonthlyReturn;

use Livewire\Component;
use App\Models\MonthlyReturnMaster;
use App\Models\Category;
use App\Models\Product;

class Edit extends Component
{
    public $monthlyReturnMaster;
    public $category;
    public $product;
    public $form_amount;
    public $to_amount;
    public $percentage;
    public $return_persentage;
    public $is_visible;

    public $products = [];

    protected $rules = [
        'category' => 'required|exists:categories,id',
        'product' => 'required|exists:products,id',
        'form_amount' => 'required|numeric|min:0',
        'to_amount' => 'required|numeric|min:0|gte:form_amount',
        'percentage' => 'nullable|integer|min:0',
        'return_persentage' => 'required|integer|min:0',
        'is_visible' => 'boolean'
    ];

    public function mount($id)
    {
        $this->monthlyReturnMaster = MonthlyReturnMaster::findOrFail($id);
        $this->category = $this->monthlyReturnMaster->category_id;
        $this->product = $this->monthlyReturnMaster->product_id;
        $this->form_amount = $this->monthlyReturnMaster->form_amount;
        $this->to_amount = $this->monthlyReturnMaster->to_amount;
        $this->percentage = $this->monthlyReturnMaster->percentage;
        $this->return_persentage = $this->monthlyReturnMaster->return_persentage;
        $this->is_visible = $this->monthlyReturnMaster->is_visible;

        $this->updatedCategory($this->category);
    }

    public function updatedCategory($value)
    {
        $this->products = Product::where('category_id', $value)->get();
        if (!$this->products->contains('id', $this->product)) {
            $this->product = null;
        }
    }

    public function update()
    {
        $this->validate();

        $this->monthlyReturnMaster->update([
            'category_id' => $this->category,
            'product_id' => $this->product,
            'form_amount' => $this->form_amount,
            'to_amount' => $this->to_amount,
            'percentage' => $this->percentage,
            'return_persentage' => $this->return_persentage,
            'is_visible' => $this->is_visible,
        ]);

        session()->flash('message', 'Monthly Return Master updated successfully.');
        return redirect()->route('monthly-return.index');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.master-data.monthly-return.edit', [
            'categories' => $categories,
            'products' => $this->products,
        ]);
    }
}
