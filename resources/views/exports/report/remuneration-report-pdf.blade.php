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
                <th class="text-wrap">Name</th>
                <th class="text-wrap">ID</th>
                <th>Rank</th>
                <th>Target Achived</th>
                <th class="text-wrap">Amount</th>
                <th class="text-wrap">Month Validity</th>
                <th class="text-wrap">Month Paid</th>
                <th class="text-wrap">Start Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->user->name ?? 'N/A' }}</td>
                    <td>{{ $item->user->member_number }}</td>
                    <td>{{ $item->rank }}</td>
                    <td>{{ $item->target }}</td>
                    <td>{{ $item->amount }}</td>
                    <td>{{ $item->month_validity }}</td>
                    <td>{{ $item->month_count }}</td>
                    <td>{{ formated_date($item->start_date) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>