<!DOCTYPE html>
<html>
<head>
    <title>Leaders Export</title>
    <meta charset="utf-8">
    {{-- <style>
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
    </style> --}}
</head>
<body>
    {{-- <div class="header">         
        <div class="title">Members of </div>
        <div class="date">Generated on: {{ format_datetime(now()) }}</div>
    </div> --}}

    {{-- <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <h6 class="mb-1 text-muted">Total Members : {{ number_format($totalMembers) }}</h6>
        </div>
        <div class="col-md-4 mb-2">
            <h6 class="mb-1 text-muted">Active Members : {{ number_format($activeMembers) }}</h6>
        </div>
        <div class="col-md-4 mb-2">
            <h6 class="mb-1 text-muted">Inactive Members : {{ number_format($inactiveMembers) }}</h6>
        </div>
    </div> --}}

    {{-- <table>
        <thead>
            <tr>
                <th>Reg Date</th>
                <th>Name</th>
                <th>ID</th>
                <th>Phone Number</th>
                <th>Position</th>
                <th>Sponsor Name</th>
                <th>Sponsor ID</th>
                <th>Status</th>
                <th>Activated Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td>{{ format_datetime($member->created_at) }}</td>
                    <td>{{ $member->user->name }}</td>
                    <td>{{ $member->member_number }}</td>
                    <td>{{ $member->user->phone }}</td>
                    <td>
                        <span class="badge {{ $member->position === 'left' ? 'bg-success' : 'bg-info' }}">
                            {{ ucfirst($member->position) }}
                        </span>
                    </td>
                    <td>
                        @if($member->sponsor)
                            {{ $member->sponsor->user->name ?? 'N/A' }}
                        @else
                            Root
                        @endif
                    </td>
                    <td>{{ $member->sponsor->member_number }}</td>
                    
                    <td>
                        <span class="badge {{ $member->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $member->status == 1 ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        {{ $member->activated_at ? $member->activated_at : 'Not activated' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-muted">
                        No members found matching your criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table> --}}

    {{-- <div class="footer">
        Total Leaders: {{ $members->count() }} | Exported by {{ auth()->user()->name ?? 'System' }}
    </div> --}}
</body>
</html>