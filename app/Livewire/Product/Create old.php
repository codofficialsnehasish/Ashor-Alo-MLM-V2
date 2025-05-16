<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;

class Create extends Component
{
    use WithFileUploads;

    public $title, $slug, $sku, $category_id, $price = 0, $discount_rate, $no_discount = false, $discounted_price;
    public $gst_rate, $gst_amount, $stock = 0, $is_visible = 1, $is_bestseller = 0;
    public $short_desc, $description, $meta_title, $meta_keyword, $meta_description;
    public $is_provide_direct = 0, $is_provide_roi = 0, $is_provide_level = 0;
    public $image;
    public $total_price = 0;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['price', 'discount_rate', 'gst_rate'])) {
            $this->calculateTotalPrice();
        }
    }

    public function calculateTotalPrice()
    {
        $price = $this->price ?: 0;
        $discountRate = $this->discount_rate ?: 0;
        $gstRate = $this->gst_rate ?: 0;

        $discountAmount = ($discountRate / 100) * $price;
        $discountedPrice = $price - $discountAmount;
        $gstAmount = ($gstRate / 100) * $discountedPrice;
        $this->total_price = $discountedPrice + $gstAmount;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:products,slug',
            'sku' => 'nullable|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'discount_rate' => 'nullable|integer|min:0|max:100',
            'discounted_price' => 'nullable|numeric|min:0',
            'gst_rate' => 'nullable|integer|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $product = Product::create([
            'title' => $this->title,
            'slug' => createSlug($this->title, Product::class),
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'discount_rate' => $this->discount_rate,
            'no_discount' => $this->no_discount,
            'discounted_price' => $this->price - (($this->discount_rate / 100) * $this->price),
            'gst_rate' => $this->gst_rate,
            'gst_amount' => ($this->gst_rate / 100) * ($this->price - (($this->discount_rate / 100) * $this->price)),
            'stock' => $this->stock ?? 0,
            'is_visible' => $this->is_visible,
            'is_bestseller' => $this->is_bestseller,
            'short_desc' => $this->short_desc,
            'description' => $this->description,
            'meta_title' => $this->meta_title,
            'meta_keyword' => $this->meta_keyword,
            'meta_description' => $this->meta_description,
            'is_provide_direct' => $this->is_provide_direct,
            'is_provide_roi' => $this->is_provide_roi,
            'is_provide_level' => $this->is_provide_level,
        ]);

        $product->total_price = $this->total_price;

        $product->update();

        if ($this->image) {
            $product->addMedia($this->image)->toMediaCollection('products');
        }

        // Reset all form fields to initial state
        $this->reset([
            'title', 'slug', 'sku', 'category_id', 'price', 'total_price', 'discount_rate', 'no_discount', 'discounted_price',
            'gst_rate', 'gst_amount', 'stock', 'is_visible', 'is_bestseller',
            'short_desc', 'description', 'meta_title', 'meta_keyword', 'meta_description',
            'is_provide_direct', 'is_provide_roi', 'is_provide_level', 'image'
        ]);

        $this->dispatch('toastMessage', json_encode([
            'type'=>'success',
            'message' => 'Product created successfully.'
        ]));
    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => Category::all()
        ]);
    }
}
