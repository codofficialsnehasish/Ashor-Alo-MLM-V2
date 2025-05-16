<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;

class Edit extends Component
{
    use WithFileUploads;

    public $product;
    public $title, $slug, $sku, $category_id, $price = 0, $discount_rate, $no_discount = false, $discounted_price;
    public $gst_rate, $gst_amount, $stock = 0, $is_visible = 1, $is_bestseller = 0;
    public $short_desc, $description, $meta_title, $meta_keyword, $meta_description;
    public $is_provide_direct = 0, $is_provide_roi = 0, $is_provide_level = 0;
    public $image;
    public $total_price = 0;
    public $existingImage;

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->title = $product->title;
        $this->slug = $product->slug;
        $this->sku = $product->sku;
        $this->category_id = $product->category_id;
        $this->price = $product->price;
        $this->discount_rate = $product->discount_rate;
        $this->no_discount = $product->no_discount;
        $this->discounted_price = $product->discounted_price;
        $this->gst_rate = $product->gst_rate;
        $this->gst_amount = $product->gst_amount;
        $this->stock = $product->stock;
        $this->is_visible = (bool) $product->is_visible;
        $this->is_bestseller = (bool) $product->is_bestseller;
        $this->short_desc = $product->short_desc;
        $this->description = $product->description;
        $this->meta_title = $product->meta_title;
        $this->meta_keyword = $product->meta_keyword;
        $this->meta_description = $product->meta_description;
        $this->is_provide_direct = (bool) $product->is_provide_direct;
        $this->is_provide_roi = (bool) $product->is_provide_roi;
        $this->is_provide_level = (bool) $product->is_provide_level;
        $this->total_price = $product->total_price;
        $this->existingImage = $product->getFirstMediaUrl('products'); // Existing one from media library
    }

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

        $this->discounted_price = $discountedPrice;
        $this->gst_amount = $gstAmount;
        $this->total_price = $discountedPrice + $gstAmount;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $this->product->id,
            'sku' => 'nullable|unique:products,sku,' . $this->product->id,
            'price' => 'required|numeric|min:0',
            'discount_rate' => 'nullable|integer|min:0|max:100',
            'discounted_price' => 'nullable|numeric|min:0',
            'gst_rate' => 'nullable|integer|min:0|max:100',
            'gst_amount' => 'nullable|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $this->product->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'discount_rate' => $this->discount_rate,
            'no_discount' => $this->no_discount,
            'discounted_price' => $this->discounted_price,
            'gst_rate' => $this->gst_rate,
            'gst_amount' => $this->gst_amount,
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

        if ($this->image) {
            $this->product->clearMediaCollection('products');
            $this->product->addMedia($this->image)->toMediaCollection('products');
        }

        $this->image = '';
        $this->existingImage = $this->product->getFirstMediaUrl('products');
        $this->dispatch('toastMessage', json_encode([
            'type' => 'success',
            'message' => 'Product updated successfully.'
        ]));

        // return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product.edit', [
            'categories' => Category::all()
        ]);
    }
}
