<!DOCTYPE html>
<html>
<head>
    <title>Order Receipt - {{ $order->order_number }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }
        .receipt-header-card {
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        border: 1px solid #e0e0e0;
        overflow: hidden;
    }
    
    .receipt-header-container {
        /*display: flex;*/
        /*align-items: stretch;*/
        min-height: 180px;
        width: 650px;
    }
    
    .order-info-section, .customer-info-section {
        padding: 25px;
        /*flex: 1;*/
        /*display: flex;*/
        /*flex-direction: column;*/
        float: left;
    }
    
    .vertical-divider {
        width: 1px;
        background: linear-gradient(to bottom, 
                      transparent 0%, 
                      #e0e0e0 10%, 
                      #e0e0e0 90%, 
                      transparent 100%);
        margin: 15px 0;
    }
    
    .receipt-title, .customer-title {
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .receipt-title {
        font-size: 22px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 12px;
    }
    
    .customer-title {
        font-size: 18px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }
    
    .meta-row, .detail-row {
        display: flex;
        margin-bottom: 10px;
        align-items: center;
    }
    
    .meta-label, .detail-label {
        font-weight: 600;
        min-width: 120px;
        color: #555;
        font-size: 14px;
    }
    
    .meta-value, .detail-value {
        color: #333;
        font-size: 14px;
    }
    
    .status-badge {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    
    .status-paid {
        background: #e6f7eb;
        color: #0a5c36;
        border: 1px solid #b7ebc2;
    }
    
    .status-pending, .status-awaiting {
        background: #fff9e6;
        color: #ad8b00;
        border: 1px solid #ffe58f;
    }
    
    /* Font Awesome icons */
    .fas {
        color: #6c757d;
    }
    
    @media print {
        .receipt-header-card {
            box-shadow: none;
            border: none;
            background: transparent;
        }
        .vertical-divider {
            background: #e0e0e0;
        }
    }
    
    
    @media (max-width: 768px) {
        .receipt-header-container {
            flex-direction: column;
        }
        .vertical-divider {
            width: 100%;
            height: 1px;
            margin: 0;
            background: linear-gradient(to right, 
                          transparent 0%, 
                          #e0e0e0 10%, 
                          #e0e0e0 90%, 
                          transparent 100%);
        }
        .meta-label, .detail-label {
            min-width: 100px;
        }
    }
        .receipt-container {
            display: flex;
            width: 100%;
            /*gap: 20px;*/
        }
        .receipt-copy {
            width: 50%;
            border: 1px dashed #ccc;
            padding: 15px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .customer-info, .order-info {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
        }
        .copy-label {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 5px;
            background-color: #f2f2f2;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Receipt
        </button>
        <button onclick="window.location.href='{{ route('orders.list') }}'" style="padding: 10px 20px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Back to Orders
        </button>
    </div>

    <div class="receipt-container">
        <!-- Admin Copy -->
        <div class="receipt-copy">
            <div class="copy-label">ADMIN COPY</div>
            <div class="receipt-header-card">
                <div class="receipt-header-container">
                    <!-- Left Side - Order Information -->
                    <div class="order-info-section">
                        <h2 class="receipt-title">
                            Order Receipt
                        </h2>
                        <div class="order-meta">
                            <div class="meta-row">
                                <span class="meta-label">Order #:</span>
                                <span class="meta-value">{{ $order->order_number }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Date:</span>
                                <span class="meta-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Status:</span>
                                <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Payment Method:</span>
                                <span class="meta-value">{{ ucfirst($order->payment_method) }}</span>
                            </div>
                            @if($order->transaction_id)
                            <div class="meta-row">
                                <span class="meta-label">Transaction ID:</span>
                                <span class="meta-value">{{ $order->transaction_id }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Vertical Divider -->
                    <!--<div class="vertical-divider"></div>-->
                    
                    <!-- Right Side - Customer Information -->
                    <div class="customer-info-section">
                        <h3 class="customer-title">
                            Customer Details
                        </h3>
                        <div class="customer-details">
                            <div class="detail-row">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value">{{ $order->user->name }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">ID:</span>
                                <span class="detail-value">{{ $order->user->binaryNode->member_number }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Contact:</span>
                                <span class="detail-value">{{ $order->user->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $order->user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-info">
                <h3 style="text-align: center;">Order Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Variation</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product_title }}</td>
                            <td>{{ $item->variation ? $item->variation->value : '-' }}</td>
                            <td>{{ number_format($item->product_unit_price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Subtotal:</td>
                            <td>{{ number_format($order->price_subtotal, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Total:</td>
                            <td>{{ number_format($order->price_total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Customer Copy -->
        <div class="receipt-copy">
            <div class="copy-label">CUSTOMER COPY</div>
            <div class="receipt-header-card">
                <div class="receipt-header-container">
                    <!-- Left Side - Order Information -->
                    <div class="order-info-section">
                        <h2 class="receipt-title">
                            Order Receipt
                        </h2>
                        <div class="order-meta">
                            <div class="meta-row">
                                <span class="meta-label">Order #:</span>
                                <span class="meta-value">{{ $order->order_number }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Date:</span>
                                <span class="meta-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Status:</span>
                                <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            <div class="meta-row">
                                <span class="meta-label">Payment Method:</span>
                                <span class="meta-value">{{ ucfirst($order->payment_method) }}</span>
                            </div>
                            @if($order->transaction_id)
                            <div class="meta-row">
                                <span class="meta-label">Transaction ID:</span>
                                <span class="meta-value">{{ $order->transaction_id }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Vertical Divider -->
                    <!--<div class="vertical-divider"></div>-->
                    
                    <!-- Right Side - Customer Information -->
                    <div class="customer-info-section">
                        <h3 class="customer-title">
                            Customer Details
                        </h3>
                        <div class="customer-details">
                            <div class="detail-row">
                                <span class="detail-label">Name:</span>
                                <span class="detail-value">{{ $order->user->name }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">ID:</span>
                                <span class="detail-value">{{ $order->user->binaryNode->member_number }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Contact:</span>
                                <span class="detail-value">{{ $order->user->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">Email:</span>
                                <span class="detail-value">{{ $order->user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="order-info">
                <h3 style="text-align: center;">Order Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Variation</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product_title }}</td>
                            <td>{{ $item->variation ? $item->variation->value : '-' }}</td>
                            <td>{{ number_format($item->product_unit_price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Subtotal:</td>
                            <td>{{ number_format($order->price_subtotal, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="5" style="text-align: right;">Total:</td>
                            <td>{{ number_format($order->price_total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>