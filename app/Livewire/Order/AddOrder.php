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
use App\Models\TopUp;
use App\Models\MlmSetting;
use App\Models\MonthlyReturnMaster;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
    public $transactionNumber = null;

    public $subtotal = 0;
    public $total = 0;

    public $last_top_up_amount = 0.00;
    public $addon_orders;
    public $selectedAddonOrder = null;
    public $selectedAddonOrder_id = null;

    public function mount()
    {
        // $this->customers = User::all();
        $this->customers = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Leader']);
        })->get();

        $this->categories = Category::where('is_visible',1)->get();
    }

    public function selectAddonOrder($orderId)
    {
        $this->selectedAddonOrder = TopUp::find($orderId);
        $add_on_percentage = optional(MlmSetting::first())->add_on_percentage ?? 0;
        // Calculate subtotal and total based on the selected order
        $this->subtotal = optional($this->selectedAddonOrder)->total_amount ? $this->selectedAddonOrder->total_amount * ($add_on_percentage / 100) : 0;

        $this->total = $this->subtotal;
        $this->selectedAddonOrder_id = $this->selectedAddonOrder->order_id;
    }

    public function updated($property, $value)
    {
        // dd($property);
        if($property === 'selectedCustomer'){
            
            $this->last_top_up_amount = TopUp::where('user_id',$value)->whereNull('add_on_against_order_id')->latest()->value('total_amount');
            $this->selectedCustomer = $value;
            // dd($this->addonable_orders); 
        }
        if ($property === 'category') {
            $category = Category::find($value);
            if($category->is_provide_roi ==1 && ($category->is_provide_direct == 0 && $category->is_provide_level == 0 && $category->is_show_on_business == 0)){
                $this->addon_orders = TopUp::where('user_id', $this->selectedCustomer)
                                            ->whereNull('add_on_against_order_id') // Not an addon
                                            ->whereHas('order', function ($query) {
                                                $query->where('status', '!=', 1);
                                            })
                                            ->whereNotIn('order_id', function($query) {
                                                $query->select('add_on_against_order_id')
                                                    ->from('top_ups')
                                                    ->whereNotNull('add_on_against_order_id');
                                            })
                                            ->with('order')
                                            ->get();
            }else{
                $this->addon_orders = null;
            }
            $this->loadProducts();
        }

        if (str_starts_with($property, 'quantities.')) {
            $this->calculateTotals();
        }

        // Handle selected products changes
        if ($property === 'selectedProducts') {
            $this->calculateTotals();
        }

        // Handle selected products quantity changes (if using separate array)
        if (str_starts_with($property, 'selectedProducts.')) {
            $parts = explode('.', $property);
            if (count($parts) === 3 && $parts[2] === 'qty') {
                $this->calculateTotals();
            }
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
            'transactionNumber' => [
                'nullable',
                'required_if:paymentMethod,online',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->paymentMethod === 'online' && 
                        Order::where('transaction_id', $value)->exists()) {
                        $fail('This transaction id has already been used.');
                    }
                },
            ],
        ]);

        $orderData = [
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'user_id' => $this->selectedCustomer,
            'category_id' => $this->category,
            'price_subtotal' => $this->subtotal,
            'price_total' => $this->total,
            'payment_method' => $this->paymentMethod,
            'payment_status' => $this->paymentStatus,
            'placed_by' => Auth::user()->name.'('.get_role(Auth::id()).')'
        ];

        // Add transaction number if payment is online
        if ($this->paymentMethod === 'online') {
            $orderData['transaction_id'] = $this->transactionNumber;
        }

        $order = Order::create($orderData);
        // dd($this->quantities);
        foreach ($this->quantities as $key => $qty) {
            if ($qty <= 0) continue;
            
            $parts = explode('_', $key);
            $type = $parts[0];
            $id = $parts[1];
            
            $orderItemData = [
                'order_id' => $order->id,
                'quantity' => $qty,
            ];

            switch ($type) {
                case 'simple':
                    $product = Product::find($id);
                    $orderItemData['product_id'] = $product->id;
                    $orderItemData['product_title'] = $product->title;
                    $orderItemData['product_unit_price'] = $product->total_price ?? 0;
                    $orderItemData['product_gst_rate'] = $product->gst_rate ?? 0;
                    break;
                    
                case 'variation':
                    $variation = ProductVariation::with('product')->find($id);
                    $orderItemData['product_id'] = $variation->product_id;
                    $orderItemData['product_variation_id'] = $variation->id; // Track variation
                    $orderItemData['product_title'] = $variation->product->title . ' - ' . $variation->value;
                    $orderItemData['product_unit_price'] = $variation->price_override ?? 0;
                    $orderItemData['product_gst_rate'] = $variation->product->gst_rate ?? 0;
                    break;
                    
                case 'combo':
                    $product = Product::find($id);
                    $orderItemData['product_id'] = $product->id;
                    $orderItemData['product_title'] = $product->title . ' (Combo)';
                    $orderItemData['product_unit_price'] = $product->combo_price ?? 0;
                    $orderItemData['product_gst_rate'] = $product->gst_rate ?? 0;
                    break;
            }

            $orderItemData['product_gst'] = ($orderItemData['product_unit_price'] * $qty) * ($orderItemData['product_gst_rate'] / 100);
            $orderItemData['total_price'] = ($orderItemData['product_unit_price'] * $qty) + $orderItemData['product_gst'];

            OrderItem::create($orderItemData);
            $this->selectedAddonOrder_id = null;
        }

        $this->make_id_green($this->category, $order->id, $this->selectedCustomer, $this->total, now());

        session()->flash('message', 'Order placed successfully!');
        // return redirect()->route('orders.index');
        return redirect()->route('orders.print', $order->id, $order->id);

    }


    private function calculate_ROI($total_amount, $category, $order_id, $acumulated_amount){ //Return of Invesment

        $main_amount = $total_amount + $acumulated_amount;

        $percentage = MonthlyReturnMaster::where('form_amount', '<=', $main_amount)
                        ->where('to_amount', '>=', $main_amount)
                        ->where('category_id',$category)
                        ->first();

        $data_array = [];
        if (!empty($percentage->percentage)) {
            // Calculate monthly installment and total months
            $per_month_installment_amount = $total_amount * ($percentage->percentage / 100);
            $total_paying_amount = $total_amount * ($percentage->return_persentage / 100);
            $total_month = $total_paying_amount / $per_month_installment_amount;

            // Set basic values
            $data_array['total_installment_month'] = $total_month;
            $data_array['installment_amount_per_month'] = $per_month_installment_amount;
            $data_array['total_paying_amount'] = $total_paying_amount;
            $data_array['return_percentage'] = $percentage->return_persentage;
            $data_array['percentage'] = $percentage->percentage;

            // Start date = current date + 1 day
            $start_date = Carbon::now()->addDay();

            // End date by adding months (rounded up for safety)
            $end_date = $start_date->copy()->addMonths(ceil($total_month));

            // Total days between start and end
            $total_days = $start_date->diffInDays($end_date);

            // Daily installment amount
            $installment_amount_per_day = $total_paying_amount / $total_days;

            // Add to data array
            $data_array['installment_amount_per_day'] = round($installment_amount_per_day, 2);
            $data_array['total_installment_days'] = $total_days;
            $data_array['start_date'] = $start_date->toDateString();
            $data_array['end_date_of_completion'] = $end_date->toDateString();
            
            return $data_array;
        }else{
            return array();
        }
    }


    private function get_accumulation_business($user_id, $category_id){
        $total_acumulation = TopUp::where('user_id', $user_id)      
                            ->where('is_completed', 0)
                            ->whereHas('order', function ($query) use ($category_id) {
                                $query->where('category_id', $category_id);
                            })
                            ->sum('total_amount');

        // $total_acumulation = TopUp::where('user_id',$user_id)->where('is_completed',0)->sum('total_amount');
        
        return $total_acumulation ?? 0;
    }

    private function make_id_green($category, $order_id, $user_id, $total_amount, $date){
        //calculate accumulation business 
        $total_acumulation = $this->get_accumulation_business($user_id, $category);

        $ROI = $this->calculate_ROI($total_amount, $category, $order_id, $total_acumulation);
        
        if(!empty($ROI)){
            $category = Category::find($category);
            $top_up = new TopUp();
            $top_up->entry_by = Auth::user()->name.'('.get_role(Auth::id()).')';
            $top_up->user_id = $user_id;
            $top_up->order_id = $order_id;
            $top_up->add_on_against_order_id = $this->selectedAddonOrder_id;
            $top_up->start_date = $date;
            $top_up->end_date = $ROI['end_date_of_completion'];
            $top_up->total_amount = $total_amount;
            $top_up->percentage = $ROI['percentage'];
            $top_up->return_percentage = $ROI['return_percentage'];
            $top_up->total_installment_month = $ROI['total_installment_month'];
            $top_up->total_paying_amount = $ROI['total_paying_amount'];
            $top_up->installment_amount_per_month = $ROI['installment_amount_per_month'];
            $top_up->installment_amount_per_day = $ROI['installment_amount_per_day'];
            $top_up->total_installment_days = $ROI['total_installment_days'];
            $top_up->is_provide_direct = $category->is_provide_direct;
            $top_up->is_provide_roi = $category->is_provide_roi;
            $top_up->is_provide_level = $category->is_provide_level;
            $top_up->is_show_on_business = $category->is_show_on_business;
            $top_up->save();
    
            $custo = User::find($user_id);

            if ($custo && $custo->binaryNode && $custo->binaryNode->status != 1) {
                $binaryNode = $custo->binaryNode;

                $binaryNode->status = 1;
                $binaryNode->joining_amount = $total_amount;
                $binaryNode->activated_at = $date;
                $binaryNode->join_by = Auth::user()->name . ' (' . get_role(Auth::id()) . ')';
                $binaryNode->joining_order_id = $order_id;

                $binaryNode->update(); // returns true or false
    
                //joining amount transaction
                // $transactionAdded = $this->transaction->make_transaction(
                //     $user_id,
                //     $total_amount,
                //     'Joining Amount',
                //     1
                // );

            }
        }else{
            if($total_amount == 0 || $total_amount == 1){
                $custo = User::find($user_id);
                if($custo->binaryNode->status != 1){
                    $custo->binaryNode->status = 1;
                    $custo->binaryNode->joining_amount = $total_amount;
                    $custo->binaryNode->activated_at = $date;
                    $result = $custo->binaryNode->update();
                }
            }
        }
    }

    public function print(Order $order)
    {
        $order->load(['user', 'items.product', 'items.variation']);
        return view('orders.print', compact('order'));
    }

    public function render()
    {
        return view('livewire.order.add-order');
    }
}
