<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leaders Export</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .filter-info {
            font-size: 12px;
            color: #555;
            margin-bottom: 15px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th { 
            background-color: #f2f2f2;
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        td { 
            padding: 8px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">{{ $title }}</div>
        <div class="date">Generated on: {{ format_datetime(now()) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Place Date</th>
                <th>Order ID</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Payment Mode</th>
                <th>Order Status</th>
                <th>Entry By</th>
                <th>Delivered At</th>
                <th>Delivered By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ format_datetime($item->created_at) }}</td>
                    <td>{{ $item->order_number }}</td>
                    <td>{{ $item->user->name ?? 'N/A' }} ({{ $item->user->member_number ?? 'N/A' }})</td>
                    <td>{{ $item->price_total }}</td>
                    <td>{{ $item->category?->name ?? 'N/A' }}</td>
                    <td>{{ $item->payment_method }} ({{ $item->payment_status }})</td>
                    <td>{{ $item->order_status }}</td>
                    <td>{{ $item->placed_by }}</td>
                    <td>@if($item->status) {{ !empty($item->delivered_date) ? format_datetime($item->delivered_date) : format_datetime($item->updated_at) }} @endif</td>
                    <td>{{ $item->delivered_by ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>