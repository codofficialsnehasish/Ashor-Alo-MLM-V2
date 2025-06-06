<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payout Full Report</title>
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
                <th class="text-wrap">Paid / Unpaid</th>
                <th class="text-wrap">ID</th>
                <th class="text-wrap">Total Payout Amount</th>
                <th class="text-wrap">Account Name (As Per Bank)</th>
                <th class="text-wrap">Bank Name</th>
                <th class="text-wrap">Account Number</th>
                <th class="text-wrap">IFSC</th>
                <th class="text-wrap">Account Type</th>
                <th class="text-wrap">UPI Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        {{ $item->paid_unpaid ? 'Paid' : 'Unpaid' }}
                    </td>
                    <td class="text-wrap">{{ $item->user->name ?? '' }} ({{ $item->user->member_number ?? '' }})</td>
                    <td class="text-wrap">{{ $item->total_payout ?? '' }}</td>
                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_name ?? '' }}</td>
                    <td class="text-wrap">{{ $item->user?->bankDetails?->bank_name ?? '' }}</td>
                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_number ?? '' }}</td>
                    <td class="text-wrap">{{ $item->user?->bankDetails?->ifsc_code ?? '' }}</td>
                    <td class="text-wrap">{{ $item->user?->bankDetails?->account_type ?? '' }}</td>
                    <td>
                        <Strong>UPI Type : </Strong> {{ $item->user?->bankDetails?->upi_type ?? '' }}<br>
                        <Strong>UPI Number : </Strong> {{ $item->user?->bankDetails?->upi_number ?? '' }}<br>
                        <Strong>UPI Name : </Strong> {{ $item->user?->bankDetails?->upi_name ?? '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>