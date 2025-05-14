<?php

namespace App\Livewire\MasterData\MonthlyReturn;

use Livewire\Component;
use App\Models\MonthlyReturnMaster;
use App\Models\Category;
use App\Models\Product;

class Create extends Component
{
    public $category;
    public $product;
    public $form_amount = 0.00;
    public $to_amount = 0.00;
    public $percentage;
    public $return_persentage;
    public $is_visible = true;

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

    // public function updatedCategory($value)
    // {
    //     $this->products = Product::where('category_id', $value)->get();
    //     $this->reset('product');
    // }
    public function updated($property, $value)
    {
        if ($property === 'category') {
            $this->products = Product::where('category_id', $value)->get();
            $this->reset('product');
        }
    }

    public function save()
    {
        $this->validate();

        MonthlyReturnMaster::create([
            'category_id' => $this->category,
            'product_id' => $this->product,
            'form_amount' => $this->form_amount,
            'to_amount' => $this->to_amount,
            'percentage' => $this->percentage,
            'return_persentage' => $this->return_persentage,
            'is_visible' => $this->is_visible,
        ]);

        session()->flash('message', 'Monthly Return Master created successfully.');
        return redirect()->route('monthly-return.index');
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.master-data.monthly-return.create', [
            'categories' => $categories,
            'products' => $this->products,
        ]);
    }
}
