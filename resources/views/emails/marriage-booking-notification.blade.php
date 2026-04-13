<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: 'Instrument Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #1b1b18;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #1b1b18;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 30px;
            border: 1px solid #e3e3e0;
        }
        .booking-info {
            background-color: white;
            border: 1px solid #e3e3e0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .booking-info h2 {
            margin-top: 0;
            color: #1b1b18;
            font-size: 18px;
            border-bottom: 2px solid #f53003;
            padding-bottom: 10px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
        }
        .info-label {
            font-weight: 600;
            color: #706f6c;
            min-width: 140px;
        }
        .info-value {
            color: #1b1b18;
        }
        .message-box {
            background-color: #f5f5f5;
            border-left: 4px solid #f53003;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background-color: #1b1b18;
            color: #706f6c;
            padding: 15px;
            text-align: center;
            font-size: 14px;
            border-radius: 0 0 8px 8px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            background-color: #f53003;
            color: white;
            border-radius: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ipswich Mosque</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px;">New Marriage Booking Request</p>
    </div>

    <div class="content">
        <p>Assalamu Alaikum,</p>
        
        <p>A new marriage/nikah booking request has been submitted through the website. Here are the details:</p>

        <div class="booking-info">
            <h2>Booking Details</h2>
            
            <div class="info-row">
                <span class="info-label">Name:</span>
                <span class="info-value">{{ $booking->name }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $booking->email }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Phone:</span>
                <span class="info-value">{{ $booking->phone ?? 'Not provided' }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Service Type:</span>
                <span class="info-value">{{ $booking->service_type_label }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Proposed Date:</span>
                <span class="info-value">{{ $booking->proposed_date ?? 'Not specified' }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Proposed Time:</span>
                <span class="info-value">{{ $booking->proposed_time ?? 'Not specified' }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Expected Guests:</span>
                <span class="info-value">{{ $booking->expected_guests ?? 'Not specified' }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">Submitted:</span>
                <span class="info-value">{{ $booking->created_at->format('M d, Y H:i') }}</span>
            </div>
        </div>

        @if($booking->message)
            <div class="message-box">
                <strong>Message from applicant:</strong>
                <p style="margin: 10px 0 0 0;">{{ $booking->message }}</p>
            </div>
        @endif

        <p style="margin-top: 20px;">
            <a href="{{ route('admin.marriage-bookings.show', $booking) }}" 
               style="display: inline-block; padding: 12px 24px; background-color: #1b1b18; color: white; text-decoration: none; border-radius: 6px; font-weight: 500;">
                View Booking in Admin Panel
            </a>
        </p>
    </div>

    <div class="footer">
        <p style="margin: 0;">Ipswich Mosque - Marriage Booking System</p>
        <p style="margin: 5px 0 0 0; font-size: 12px;">This email was sent automatically. Please do not reply.</p>
    </div>
</body>
</html>