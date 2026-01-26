<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .info { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #4CAF50; }
        .info table { width: 100%; }
        .info td { padding: 5px; }
        .items-table { width: 100%; border-collapse: collapse; margin: 20px 0; background: white; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .items-table th { background-color: #4CAF50; color: white; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Material Transfer Request</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>A new material transfer request has been submitted with {{ count($items) }} item(s).</p>
            
            <div class="info">
                <table>
                    <tr>
                        <td><strong>Transfer Route:</strong></td>
                        <td>{{ ucwords(str_replace('-', ' ', $items[0]->transfer_route)) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Reference No:</strong></td>
                        <td>{{ $items[0]->ref_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ $items[0]->transfer_date ? $items[0]->transfer_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Company:</strong></td>
                        <td>{{ $items[0]->company_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Submitted By:</strong></td>
                        <td>{{ $submittedBy }}</td>
                    </tr>
                </table>
            </div>
            
            <h3>Items:</h3>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>SL No.</th>
                        <th>Part No.</th>
                        <th>Showroom Req.</th>
                        <th>Unit</th>
                        <th>Allocatable Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->sl_no }}</td>
                            <td>{{ $item->part_no }}</td>
                            <td>{{ $item->showroom_requirement }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->allocatable_qty ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <p>Please log in to the system to review and approve this request.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} Material Transfer System</p>
        </div>
    </div>
</body>
</html>
