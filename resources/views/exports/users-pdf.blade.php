<!DOCTYPE html>
<html>
<head>
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
        <div class="title">Leaders List</div>
        <div class="date">Generated on: {{ format_datetime(now()) }}</div>
        @if($query)
        <div class="filter-info">Filtered by: "{{ $query }}"</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Reg Date</th>
                <th>Active Date</th>
                <th>Name</th>
                <th>Position</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Status</th>
                <th>Sponsor ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ format_datetime($user->created_at) }}</td>
                <td>{{ !empty($user->binaryNode->activated_at) ? format_datetime($user->binaryNode->activated_at) : '' }}</td>
                <td>{{ $user->name }} ({{$user->binaryNode->member_number}})</td>
                <td>{{ isset($user->binaryNode) ? ucfirst($user->binaryNode->position) : '' }}</td>
                <td>{{ $user->phone ?? '' }}</td>
                <td>{{ $user->email }}</td>
                <td>{!! check_status($user->binaryNode->status) !!}</td>
                <td>{{ $user->binaryNode?->sponsor?->user?->name ?? '' }} @if($user->binaryNode?->sponsor)({{$user->binaryNode?->sponsor?->member_number}})@endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Leaders: {{ $users->count() }} | Exported by {{ auth()->user()->name ?? 'System' }}
    </div>
</body>
</html>