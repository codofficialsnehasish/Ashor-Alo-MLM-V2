<?php

namespace App\Livewire\Order;

use Livewire\Component;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ComboItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class AddOrder extends Component
{
    public $customers;
    public $categories;
    public $products = [];
    public $quantities = []; // key: product_id or variation_id

    public $selectedCustomer;
    public $category = null;
    public $selectedProducts = []; // product_id => ['qty' => x]

    public $paymentMethod;
    public $paymentStatus;

    public $subtotal = 0;
    public $total = 0;

    public function mount()
    {
        $this->customers = User::all();
        $this->categories = Category::all();
    }

    public function updated($property, $value)
    {
        // dd($property);
        if ($property === 'category') {
            $this->loadProducts();
        }

        if (str_starts_with($property, 'quantities.')) {
            $this->calculateTotals();
        }
    }

    public function loadProducts()
    {
        $this->products = Product::with([
            'variations',
            'comboItems'
        ])
        ->where('category_id', $this->category)
        ->get();

        // dd($this->products);
    }


    public function updatedSelectedProducts()
    {
        $this->calculateTotals();
    }

    public function updatedSelectedProductsQty()
    {
        $this->calculateTotals();
    }

    public function updateQuantity($productId, $qty)
    {
        $this->selectedProducts[$productId]['qty'] = $qty;
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->quantities as $key => $qty) {
            $parts = explode('_', $key);
            $type = $parts[0];
            $id = $parts[1];
            switch ($type) {
                case 'simple':
                    $product = Product::find($id);
                    $price = $product->total_price ?? 0;
                    break;
                case 'variation':
                    $variation = ProductVariation::find($id);
                    $price = $variation->price_override ?? 0;
                    break;
                case 'combo':
                    $product = Product::find($id);
                    $price = $product->combo_price ?? 0;
                    break;
            }

            $this->subtotal += ((float) $qty) * ((float) $price);
        }


        $this->total = $this->subtotal;
    }

    protected function findItemById($id)
    {
        foreach ($this->products as $product) {
            // Simple product
            if ($product->product_type === 'simple' && $product->id == $id) {
                return ['price' => $product->price];
            }

            // Variable product
            if ($product->product_type === 'variable') {
                foreach ($product->variations as $variation) {
                    if ($variation->id == $id) {
                        return ['price' => $variation->price_override];
                    }
                }
            }

            // Combo product
            if ($product->product_type === 'combo') {
                foreach ($product->comboItems as $comboItem) {
                    if ($comboItem->id == $id) {
                        $isVariation = $comboItem->variation_id !== null;

                        $price = $comboItem->price_override ??
                                ($isVariation
                                    ? $comboItem->variation?->price_override
                                    : $comboItem->product?->total_price);

                        return ['price' => $price ?? 0];
                    }
                }
            }
        }

        return null;
    }



    public function placeOrder()
    {
        $this->validate([
            'selectedCustomer' => 'required|exists:users,id',
            'paymentMethod' => 'required|string',
            'paymentStatus' => 'required|string',
        ]);

        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => $this->selectedCustomer,
            'price_subtotal' => $this->subtotal,
            'price_total' => $this->total,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
        ]);

        foreach ($this->selectedProducts as $productId => $data) {
            $product = Product::find($productId);
            $unitPrice = $product->discounted_price ?? $product->price;
            $qty = $data['qty'];
            $gstRate = $product->gst_rate ?? 0;
            $gstAmount = ($unitPrice * $qty) * ($gstRate / 100);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_title' => $product->title,
                'product_unit_price' => $unitPrice,
                'quantity' => $qty,
                'product_gst_rate' => $gstRate,
                'product_gst' => $gstAmount,
                'total_price' => ($unitPrice * $qty) + $gstAmount,
            ]);
        }

        session()->flash('message', 'Order placed successfully!');
        return redirect()->route('orders.index');
    }

    public function render()
    {
        return view('livewire.order.add-order');
    }
}
