<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        @if($start_date && $end_date)
        <p>Date Range: {{ formated_date($start_date) }} to {{ formated_date($end_date) }}</p>
        @endif
    </div>

    @foreach($groupedBusiness as $level => $users)
        <h3>Level {{ $level }}</h3>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Registration Date</th>
                    <th>Position</th>
                    <th>Sponsor ID</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user['user_id'] ?? '' }}</td>
                    <td>{{ $user['name'] ?? '' }}</td>
                    <td>{{ $user['phone'] ?? '' }}</td>
                    <td>{{ $user['reg_date'] ? $user['reg_date']->format('Y-m-d') : '' }}</td>
                    <td>{{ $user['position'] ?? '' }}</td>
                    <td>{{ $user['sponsor_id'] ?? '' }}</td>
                    <td>{{ $user['status'] ?? '' }}</td>
                    <td>{{ number_format($user['total_business']->total_amount ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="summary">
        <p>Total Users: {{ $total_user_count }}</p>
        <p>Total Amount: {{ number_format($total_amount, 2) }}</p>
    </div>
</body>
</html>