<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #4CAF50; color: white; padding: 20px; text-align: center; }
        .content { background-color: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .details { background-color: white; padding: 15px; margin: 15px 0; border-left: 4px solid #4CAF50; }
        .details table { width: 100%; }
        .details td { padding: 8px; }
        .details td:first-child { font-weight: bold; width: 40%; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Material Transfer Request Approved</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>A material transfer request has been approved.</p>
            
            <div class="details">
                <table>
                    <tr>
                        <td>Transfer Route:</td>
                        <td>{{ ucwords(str_replace('-', ' ', $transfer->transfer_route)) }}</td>
                    </tr>
                    <tr>
                        <td>Reference No:</td>
                        <td>{{ $transfer->ref_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Serial No:</td>
                        <td>{{ $transfer->sl_no }}</td>
                    </tr>
                    <tr>
                        <td>Part No:</td>
                        <td>{{ $transfer->part_no }}</td>
                    </tr>
                    <tr>
                        <td>Company:</td>
                        <td>{{ $transfer->company_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Showroom Requirement:</td>
                        <td>{{ $transfer->showroom_requirement }} {{ $transfer->unit }}</td>
                    </tr>
                    <tr>
                        <td>Allocatable Qty:</td>
                        <td>{{ $transfer->allocatable_qty }} {{ $transfer->unit }}</td>
                    </tr>
                    <tr>
                        <td>Approved By:</td>
                        <td>{{ $transfer->approved_by }}</td>
                    </tr>
                    <tr>
                        <td>Approved At:</td>
                        <td>{{ $transfer->approved_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
            
            <p>Please log in to the system to view more details.</p>
        </div>
        
        <div class="footer">
            <p>This is an automated email. Please do not reply.</p>
            <p>&copy; {{ date('Y') }} Material Transfer System</p>
        </div>
    </div>
</body>
</html>
