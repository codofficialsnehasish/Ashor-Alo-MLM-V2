<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tds Full Report</title>
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
                <th>Sl. No.</th>
                <th>Issue Date</th>
                <th>Amount</th>
                <th>Paid Date</th>
                <th>Mode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ formated_date($item->end_date,'-') }}</td>
                    <td>{{ $item->total_payout }}</td>
                    <td>{{ !empty($item->paid_date) ? formated_date($item->paid_date,'-') : '' }}</td>
                    <td>{{ $item->paid_mode }}</td>
                    <td>{!! paid_unpaid($item->id,$item->user_id) !!}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No transactions found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>