<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Quotation Invoice</h1>
    <p>Quotation ID: {{ $quotation->id }}</p>
    <p>Date: {{ $quotation->created_at->format('d M, Y') }}</p>
    <p>Customer: {{ $quotation->user_name }}</p>
    <p>Mobile No: {{ $quotation->mobile_no }}</p>

    <h2>Items</h2>
    <table>
        <thead>
            <tr>
                <th>Panel Brand</th>
                <th>Quality Preference</th>
                <th>Quantity</th>
                <th>Price per Unit</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $item)
                <tr>
                    <td>{{ $item->panelBrand->name }}</td>
                    <td>{{ $item->qualityPreference->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price_per_unit, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total: ${{ number_format($quotation->total, 2) }}</h3>
</body>
</html>
