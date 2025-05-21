<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;

class Create extends Component
{
    use WithFileUploads;

    // Existing properties
    public $title, $slug, $sku, $category_id, $price = 0, $discount_rate, $no_discount = false, $discounted_price;
    public $gst_rate, $gst_amount, $stock = 0, $is_visible = 1, $is_bestseller = 0;
    public $short_desc, $description, $meta_title, $meta_keyword, $meta_description;
    // public $is_provide_direct = 0, $is_provide_roi = 0, $is_provide_level = 0;
    public $image;
    public $total_price = 0;

    // New properties for variations and combos
    public $product_type = 'simple'; // 'simple', 'variable', 'combo'
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

    public function mount()
    {
        $this->variations = [
            ['attribute' => '', 'value' => '', 'price' => '', 'stock' => '', 'sku' => '']
        ];
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['price', 'discount_rate', 'gst_rate'])) {
            $this->calculateTotalPrice();
        }
        
        // Handle product type changes
        if ($propertyName === 'product_type') {
            $this->manages_variations = $this->product_type === 'variable';
        }
        
        // Handle product search for combos
        if ($propertyName === 'searchProduct' && strlen($this->searchProduct) > 2) {
            $this->searchResults = Product::where('title', 'like', '%'.$this->searchProduct.'%')
                ->where('id', '!=', $this->selectedProduct?->id)
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
        // dd($variation->value);

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

    public function store()
    {
        $rules = [
            'title' => 'required',
            'sku' => 'nullable|unique:products,sku',
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

        // Create the product
        $product = Product::create([
            'title' => $this->title,
            'slug' => createSlug($this->title, Product::class),
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
            // 'is_provide_direct' => $this->is_provide_direct,
            // 'is_provide_roi' => $this->is_provide_roi,
            // 'is_provide_level' => $this->is_provide_level,
        ]);

        // Handle variations for variable products
        if ($this->product_type === 'variable' && !empty($this->variations)) {
            foreach ($this->variations as $variation) {
                $product->variations()->create([
                    'attribute' => $variation['attribute'],
                    'value' => $variation['value'],
                    'price_override' => $variation['price'],
                    'stock' => $variation['stock'],
                    'sku' => $variation['sku'] ?? null,
                ]);
            }
        }

        // Handle combo items for combo products
        if ($this->product_type === 'combo' && !empty($this->comboItems)) {
            foreach ($this->comboItems as $item) {
                $product->comboItems()->create([
                    'product_id' => $item['product_id'],
                    'variation_id' => $item['variation_id'] ?? null,
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        // Handle image upload
        if ($this->image) {
            $product->addMedia($this->image)->toMediaCollection('products');
        }

        // Reset form
        $this->reset();

        $this->dispatch('toastMessage', json_encode([
            'type' => 'success',
            'message' => 'Product created successfully.'
        ]));

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product.create', [
            'categories' => Category::all()
        ]);
    }
}