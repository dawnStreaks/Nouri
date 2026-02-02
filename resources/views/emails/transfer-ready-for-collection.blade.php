<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9fafb; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #4F46E5; color: white; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Material Transfer Ready for Collection</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>The following material transfer items are now ready for collection:</p>
            
            <table>
                <thead>
                    <tr>
                        <th>Ref No.</th>
                        <th>Part No.</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Route</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->ref_no ?? '-' }}</td>
                        <td>{{ $item->part_no }}</td>
                        <td>{{ number_format($item->actual_qty_received ?? $item->allocatable_qty, 2) }}</td>
                        <td>{{ $item->unit }}</td>
                        <td>{{ ucwords(str_replace('-', ' ', $item->transfer_route)) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <p><strong>Prepared by:</strong> {{ $preparedBy }}</p>
            <p>Please proceed with the collection at your earliest convenience.</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from the Material Transfer System.</p>
        </div>
    </div>
</body>
</html>
