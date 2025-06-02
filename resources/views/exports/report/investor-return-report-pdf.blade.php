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
                <th>Name</th>
                <th>ID</th>
                <th>Amount</th>
                <th>Total Installment</th>
                <th>Installment Amount Per Month</th>
                <th>Paid Installment</th>
                <th>Paid Amount</th>
                <th>Due Paid</th>
                <th>Start Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->binaryNode->member_number }}</td>
                    <td>{{ $item->total_amount }}</td>
                    <td>{{ $item->total_installment_month }}</td>
                    <td>{{ $item->installment_amount_per_month }}</td>
                    <td>{{ $item->month_count }}</td>
                    <td>{{ $item->total_disbursed_amount }}</td>
                    <td>{{ abs($item->total_paying_amount - $item->total_disbursed_amount) }}</td>
                    <td>{{ $item->start_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>