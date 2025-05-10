<!DOCTYPE html>
<html>
<head>
    <title>Products Export</title>
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
        <div class="title">Products List</div>
        <div class="date">Generated on: {{ format_datetime(now()) }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>SL. No</th>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Image</th>
                <th>Visibility</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td> <!-- SL. No -->
                <td>{{ $product->title }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ $product->price }}</td>
                <td>{!! $product->getFirstMediaUrl('products') ? 'Image Available' : 'No Image' !!}</td>
                <td>{{ $product->is_visible ? 'Visible' : 'Hidden' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Total Products: {{ $products->count() }} | Exported by {{ auth()->user()->name ?? 'System' }}
    </div>
</body>
</html>