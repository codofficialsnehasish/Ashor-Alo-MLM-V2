<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt - {{ $order->order_number }}</title>
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
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .header p {
            color: #7f8c8d;
            margin-top: 0;
        }
        .payment-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .payment-info, .customer-info {
            width: 48%;
        }
        .section-title {
            background-color: #2c3e50;
            color: white;
            padding: 8px 15px;
            margin-top: 0;
            border-radius: 4px;
            font-size: 16px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            border-bottom: 1px dashed #eee;
            padding-bottom: 8px;
        }
        .detail-label {
            font-weight: bold;
            min-width: 150px;
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .payment-summary {
            margin-top: 30px;
        }
        .payment-summary table {
            width: 100%;
            border-collapse: collapse;
        }
        .payment-summary th, .payment-summary td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .payment-summary th {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
            display: inline-block;
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
        .signature-area {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
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
        <div class="header">
            <h1>PAYMENT RECEIPT</h1>
            <p>Transaction Reference: {{ $order->order_number }}</p>
        </div>
        
        <div class="payment-details">
            <div class="payment-info">
                <h3 class="section-title">Payment Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Receipt Number:</span>
                    <span class="detail-value">{{ $order->order_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Status:</span>
                    <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                @if($order->transaction_id)
                <div class="detail-row">
                    <span class="detail-label">Transaction ID:</span>
                    <span class="detail-value">{{ $order->transaction_id }}</span>
                </div>
                @endif
            </div>
            
            <div class="customer-info">
                <h3 class="section-title">Customer Information</h3>
                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value">{{ $order->user->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Member ID:</span>
                    <span class="detail-value">{{ $order->user->binaryNode->member_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Contact Number:</span>
                    <span class="detail-value">{{ $order->user->phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email Address:</span>
                    <span class="detail-value">{{ $order->user->email }}</span>
                </div>
            </div>
        </div>
        
        <div class="payment-summary">
            <h3 class="section-title">Payment Summary</h3>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_title }} @if($item->variation) ({{ $item->variation->value }}) @endif</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->product_unit_price, 2) }}</td>
                        <td>{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Subtotal:</td>
                        <td>{{ number_format($order->price_subtotal, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Total Paid:</td>
                        <td>{{ number_format($order->price_total, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="3" style="text-align: right;">Payment Status:</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->payment_status) }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="signature-area">
            <div class="signature-box">
                Customer Signature
            </div>
            <div class="signature-box">
                Authorized Signature
            </div>
        </div>
        
        <div class="footer">
            <p>Thank you for your payment. This is an official receipt.</p>
            <p>For any inquiries, please contact our customer service.</p>
            <p>Generated on: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>