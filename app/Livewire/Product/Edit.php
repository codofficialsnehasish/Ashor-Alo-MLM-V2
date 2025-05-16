<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
use App\Models\ComboItem;

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

    // Variation and Combo properties
    public $product_type = 'simple';
    public $manages_variations = false;
    public $combo_price = 0;
    
    // Variation management
    public $variations = [];
    public $attribute_name = '';
    public $attribute_value = '';
    public $variation_price = '';
    public $variation_stock = '';
    public $variation_sku = '';
    
    // Combo management
    public $comboItems = [];
    public $searchProduct = '';
    public $searchResults = [];
    public $selectedProduct = null;
    public $selectedVariation = null;
    public $comboItemQuantity = 1;

    public function mount(Product $product)
    {
        $this->product = $product;

        // Basic product info
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
        $this->existingImage = $product->getFirstMediaUrl('products');
        
        // Product type specific
        $this->product_type = $product->product_type;
        $this->manages_variations = $product->manages_variations;
        $this->combo_price = $product->combo_price;

        // Load variations if variable product
        if ($this->product_type === 'variable') {
            $this->variations = $product->variations->map(function($variation) {
                return [
                    'id' => $variation->id,
                    'attribute' => $variation->attribute,
                    'value' => $variation->value,
                    'price' => $variation->price_override,
                    'stock' => $variation->stock,
                    'sku' => $variation->sku,
                ];
            })->toArray();
        }

        // Load combo items if combo product
        if ($this->product_type === 'combo') {
            $this->comboItems = $product->comboItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_title' => $item->product->title,
                    'variation_id' => $item->variation_id,
                    'variation_value' => $item->variation?->value,
                    'quantity' => $item->quantity,
                ];
            })->toArray();
        }
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['price', 'discount_rate', 'gst_rate'])) {
            $this->calculateTotalPrice();
        }
        
        if ($propertyName === 'product_type') {
            $this->manages_variations = $this->product_type === 'variable';
        }
        
        if ($propertyName === 'searchProduct' && strlen($this->searchProduct) > 2) {
            $this->searchResults = Product::where('title', 'like', '%'.$this->searchProduct.'%')
                ->where('id', '!=', $this->selectedProduct?->id)
                ->where('id', '!=', $this->product->id) // Don't allow self-referencing
                ->limit(5)
                ->get();
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

    // Variation management methods
    public function addVariation()
    {
        $this->validate([
            'attribute_name' => 'required',
            'attribute_value' => 'required',
            'variation_price' => 'required|numeric|min:0',
            'variation_stock' => 'required|integer|min:0',
        ]);

        $this->variations[] = [
            'attribute' => $this->attribute_name,
            'value' => $this->attribute_value,
            'price' => $this->variation_price,
            'stock' => $this->variation_stock,
            'sku' => $this->variation_sku,
        ];

        $this->resetVariationFields();
    }

    public function removeVariation($index)
    {
        // If variation has an ID, mark it for deletion
        if (isset($this->variations[$index]['id'])) {
            ProductVariation::find($this->variations[$index]['id'])->delete();
        }
        unset($this->variations[$index]);
        $this->variations = array_values($this->variations);
    }

    public function resetVariationFields()
    {
        $this->reset([
            'attribute_name',
            'attribute_value',
            'variation_price',
            'variation_stock',
            'variation_sku'
        ]);
    }

    // Combo management methods
    public function selectProduct($productId)
    {
        $this->selectedProduct = Product::find($productId);
        $this->searchProduct = $this->selectedProduct->title;
        $this->searchResults = [];
    }

    public function selectVariation($variationId)
    {
        $this->selectedVariation = ProductVariation::find($variationId);
    }

    public function addComboItem()
    {
        $this->validate([
            'selectedProduct' => 'required',
            'comboItemQuantity' => 'required|integer|min:1',
        ]);

        $variation = $this->selectedVariation 
            ? ProductVariation::find($this->selectedVariation)
            : null;

        $this->comboItems[] = [
            'product_id' => $this->selectedProduct->id,
            'product_title' => $this->selectedProduct->title,
            'variation_id' => $variation?->id,
            'variation_value' => $variation?->value,
            'quantity' => $this->comboItemQuantity,
        ];

        $this->resetComboFields();
    }

    public function removeComboItem($index)
    {
        // If combo item has an ID, mark it for deletion
        if (isset($this->comboItems[$index]['id'])) {
            ComboItem::find($this->comboItems[$index]['id'])->delete();
        }
        unset($this->comboItems[$index]);
        $this->comboItems = array_values($this->comboItems);
    }

    public function resetComboFields()
    {
        $this->reset([
            'searchProduct',
            'selectedProduct',
            'selectedVariation',
            'comboItemQuantity'
        ]);
        $this->searchResults = [];
    }

    public function update()
    {
        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $this->product->id,
            'sku' => 'nullable|unique:products,sku,' . $this->product->id,
            'category_id' => 'nullable|exists:categories,id',
            'product_type' => 'required|in:simple,variable,combo',
        ];

        // Add validation rules based on product type
        if ($this->product_type === 'simple') {
            $rules['price'] = 'required|numeric|min:0';
            $rules['stock'] = 'nullable|integer|min:0';
        } elseif ($this->product_type === 'variable') {
            $rules['variations'] = 'required|array|min:1';
        } elseif ($this->product_type === 'combo') {
            $rules['combo_price'] = 'required|numeric|min:0';
            $rules['comboItems'] = 'required|array|min:1';
        }

        $this->validate($rules);

        // Update the product
        $this->product->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'product_type' => $this->product_type,
            'manages_variations' => $this->manages_variations,
            'price' => $this->product_type === 'simple' ? $this->price : 0,
            'discount_rate' => $this->discount_rate,
            'no_discount' => $this->no_discount,
            'discounted_price' => $this->product_type === 'simple' ? ($this->price - (($this->discount_rate / 100) * $this->price)) : 0,
            'gst_rate' => $this->gst_rate,
            'gst_amount' => $this->product_type === 'simple' ? (($this->gst_rate / 100) * ($this->price - (($this->discount_rate / 100) * $this->price))) : 0,
            'total_price' => $this->total_price,
            'stock' => $this->product_type === 'simple' ? ($this->stock ?? 0) : 0,
            'combo_price' => $this->product_type === 'combo' ? $this->combo_price : null,
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

        // Handle image upload
        if ($this->image) {
            $this->product->clearMediaCollection('products');
            $this->product->addMedia($this->image)->toMediaCollection('products');
            $this->existingImage = $this->product->getFirstMediaUrl('products');
        }

        // Handle variations for variable products
        if ($this->product_type === 'variable') {
            $existingVariationIds = [];
            
            foreach ($this->variations as $variation) {
                if (isset($variation['id'])) {
                    // Update existing variation
                    $this->product->variations()
                        ->where('id', $variation['id'])
                        ->update([
                            'attribute' => $variation['attribute'],
                            'value' => $variation['value'],
                            'price_override' => $variation['price'],
                            'stock' => $variation['stock'],
                            'sku' => $variation['sku'] ?? null,
                        ]);
                    $existingVariationIds[] = $variation['id'];
                } else {
                    // Create new variation
                    $newVariation = $this->product->variations()->create([
                        'attribute' => $variation['attribute'],
                        'value' => $variation['value'],
                        'price_override' => $variation['price'],
                        'stock' => $variation['stock'],
                        'sku' => $variation['sku'] ?? null,
                    ]);
                    $existingVariationIds[] = $newVariation->id;
                }
            }
            
            // Delete variations not in the current list
            $this->product->variations()
                ->whereNotIn('id', $existingVariationIds)
                ->delete();
        }

        // Handle combo items for combo products
        if ($this->product_type === 'combo') {
            $existingComboItemIds = [];
            
            foreach ($this->comboItems as $item) {
                if (isset($item['id'])) {
                    // Update existing combo item
                    $this->product->comboItems()
                        ->where('id', $item['id'])
                        ->update([
                            'product_id' => $item['product_id'],
                            'variation_id' => $item['variation_id'] ?? null,
                            'quantity' => $item['quantity'],
                        ]);
                    $existingComboItemIds[] = $item['id'];
                } else {
                    // Create new combo item
                    $newComboItem = $this->product->comboItems()->create([
                        'product_id' => $item['product_id'],
                        'variation_id' => $item['variation_id'] ?? null,
                        'quantity' => $item['quantity'],
                    ]);
                    $existingComboItemIds[] = $newComboItem->id;
                }
            }
            
            // Delete combo items not in the current list
            $this->product->comboItems()
                ->whereNotIn('id', $existingComboItemIds)
                ->delete();
        }

        $this->dispatch('toastMessage', json_encode([
            'type' => 'success',
            'message' => 'Product updated successfully.'
        ]));
    }

    public function render()
    {
        return view('livewire.product.edit', [
            'categories' => Category::all()
        ]);
    }
}