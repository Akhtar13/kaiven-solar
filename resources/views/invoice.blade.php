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
    <p>Panel Brand: {{ $quotation->pabelBrand->name }}</p>
    <p>Quality Preference: {{ $quotation->qualityPreference->name }}</p>
    <p>Expected Amount: {{ $quotation->total }}</p>
</body>
</html>
