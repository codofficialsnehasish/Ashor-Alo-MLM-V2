<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Place Order</h1>
                        </div>
                    </div>
                </div><!-- /# column -->
                <div class="col-lg-8 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-end">
                                <li><a wire:navigate href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="javascript:void(0);">Orders & Products</a></li>
                                <li><a wire:navigate href="{{ route('orders.list') }}">Orders</a></li>
                                <li class="active">Place Order</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->
            <div id="main-content">
                <div class="card">
                    <div class="card-body">
    
                        @if (session()->has('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
    
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Customer</label>
                                <select class="form-select js-example-basic-single" wire:model.live="selectedCustomer">
                                    <option value="">-- Choose Customer --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }} ({{$customer->getMemberNumberAttribute() }})</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select class="form-select" wire:model.live="category">
                                    <option value="">-- Choose Category --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(!empty($addon_orders))
                        <div class="d-flex justify-content-center">
                        @foreach($addon_orders as $order)
                            <div class="addon-order-item" wire:click="selectAddonOrder({{ $order->id }})" style="cursor: pointer;margin-right: 10px;border: 1px solid #99999961;padding: 5px;border-radius: 7px;">
                                <b>₹{{ number_format($order->total_amount, 2) }}</b>
                            </div>
                        @endforeach
                            </div>
                        @else
                        <h5 class="mt-4">Select Products</h5>
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Variation</th>
                                    <th>Rate</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $index = 1; @endphp
                                
                                @foreach($products as $product)
                                    @if($product->product_type == 'simple')
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $product->title }}</td>
                                            <td>-</td>
                                            <td>{{ $product->total_price }}</td>
                                            <td>
                                                <input type="number" wire:model.live="quantities.simple_{{ $product->id }}" min="0" value="0" class="form-control">
                                            </td>
                                            <td>
                                                ₹{{ number_format((float) ($quantities['simple_'.$product->id] ?? 0) * (float) ($product->total_price ?? 0), 2) }}
                                            </td>

                                        </tr>
                                    @elseif($product->product_type == 'variable')
                                        @foreach($product->variations as $variation)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $product->title }}</td>
                                                <td>{{ $variation->value }}</td>
                                                <td>{{ $variation->price_override }}</td>
                                                <td>
                                                    <input type="number" wire:model.live="quantities.variation_{{ $variation->id }}" min="0" value="0" class="form-control">
                                                </td>
                                                <td>
                                                    ₹{{ number_format((float)($quantities['variation_'.$variation->id] ?? 0) * (float) ($variation->price_override ?? 0), 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @elseif($product->product_type == 'combo')
                                        <tr class="table-info">
                                            <td>{{ $index++ }}</td>
                                            <td colspan="2"><strong>{{ $product->title }} (Combo)</strong></td>
                                            <td><strong>₹{{ number_format($product->combo_price, 2) }}</strong></td>
                                            <td>
                                                <input type="number" wire:model.live="quantities.combo_{{ $product->id }}" min="0" value="0" class="form-control">
                                            </td>
                                            <td>
                                                ₹{{ number_format((float)($quantities['combo_'.$product->id] ?? 0) * (float)($product->combo_price ?? 0), 2) }}
                                            </td>
                                        </tr>

                                        @foreach($product->comboItems as $comboItem)
                                            @php
                                                $isVariation = !is_null($comboItem->variation_id);
                                                $title = $comboItem->product?->title;
                                                $unit = $comboItem->variation?->attribute ?? $comboItem->product?->value;
                                                $price = $comboItem->price_override ?? ($isVariation ? $comboItem->variation?->price_override : $comboItem->product?->total_price);
                                                $variationLabel = $isVariation ? "{$comboItem->variation->value} {$unit}" : '-';
                                            @endphp
                                            <tr>
                                                <td></td>
                                                <td>{{ $title }}</td>
                                                <td>{{ $variationLabel }}</td>
                                                <td>₹{{ number_format($price, 2) }}</td>
                                                <td colspan="2">Included in combo</td>
                                            </tr>
                                        @endforeach

                                    @endif


                                @endforeach
                            </tbody>
                        </table>
                        @endif

                        <div class="card mt-3">
                            <div class="card-body">
                                <p class="card-text text-end">
                                    <strong>Subtotal:</strong> ₹{{ number_format($subtotal, 2) }}<br>
                                    <strong>Total:</strong> ₹{{ number_format($total, 2) }}<br>
                                    @if(empty($addon_orders))
                                    @if(!empty($last_top_up_amount))
                                    <strong class="text-success">Last Paid Amount : {{ $last_top_up_amount }}</strong><br>
                                    <strong class="text-danger">Minimum Required Amount : {{ number_format($last_top_up_amount * 2, 2) }}</strong>
                                    @endif
                                    @endif
                                </p>
                            </div>
                        </div>
    
    
                        <h5 class="mt-4">Payment Details</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Payment Method</label>
                                <select class="form-select" wire:model.live="paymentMethod">
                                    <option value="">-- Select --</option>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                @if($paymentMethod === 'online')
                                    <div class="col-md-12">
                                        <label class="form-label">Transaction Number</label>
                                        <input type="text" class="form-control" wire:model="transactionNumber" placeholder="Enter transaction number">
                                        @error('transactionNumber') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            </div>
    
                            <div class="col-md-6">
                                <label class="form-label">Payment Status</label>
                                <select class="form-select" wire:model="paymentStatus">
                                    <option value="">-- Select --</option>
                                    <option value="paid">Paid</option>
                                    <option value="awaiting">Awaiting Payment</option>
                                </select>
                            </div>

                        </div>
    
                        <div class="mt-4">
                            <button class="btn btn-primary" wire:click="placeOrder">Place Order</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@script()
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();

        $('.js-example-basic-single').on('change', function(e) {
            let data = $(this).val();
            // console.log(data)
            $wire.set('selectedCustomer', data)
            $wire.selectedCustomer = data;
        });
    });
</script>
@endscript