<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .success-box {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #374151;
            width: 30%;
        }
        .value {
            color: #6b7280;
            width: 70%;
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
        }
        @media (max-width: 600px) {
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
            .label, .value {
                width: 100%;
                text-align: left;
            }
            .value {
                margin-top: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 24px;">📧 Thank You for Your Message!</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">We've received your message and will get back to you soon</p>
    </div>

    <div class="content">
        <div class="success-box">
            <h3 style="margin: 0 0 10px 0; color: #1d4ed8;">Your Message Has Been Received</h3>
            <p style="margin: 0; line-height: 1.8;">Thank you for contacting Ipswich Mosque. We have successfully received your message and our team will review it shortly. We typically respond within 24-48 hours.</p>
        </div>

        <div style="margin: 30px 0;">
            <h3 style="margin: 0 0 20px 0; color: #374151;">Your Submission Details:</h3>
            <div class="detail-row">
                <span class="label">Subject:</span>
                <span class="value">{{ $contact->subject }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Your Name:</span>
                <span class="value">{{ $contact->name }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Your Email:</span>
                <span class="value">{{ $contact->email }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Phone:</span>
                <span class="value">{{ $contact->phone ?? 'Not provided' }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Preferred Contact:</span>
                <span class="value">{{ ucfirst($contact->contact_method) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Submitted:</span>
                <span class="value">{{ $contact->created_at->format('M d, Y \a\t h:i A') }}</span>
            </div>
        </div>

        <div style="margin: 30px 0;">
            <h3 style="margin: 0 0 15px 0; color: #374151;">Your Message:</h3>
            <div style="background: #f8fafc; border: 1px solid #e5e7eb; padding: 20px; border-radius: 6px; line-height: 1.8;">
                {!! nl2br(e($contact->message)) !!}
            </div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <p style="margin: 0 0 15px 0; color: #6b7280;">If you need immediate assistance, you can also reach us at:</p>
            <p style="margin: 0; font-weight: 600; color: #1d4ed8;">Phone: +44 123 456 7890</p>
            <p style="margin: 5px 0 0 0; color: #6b7280;">Email: info@ipswichmosque.org</p>
        </div>

        <div class="footer">
            <p>This is an automated confirmation email from Ipswich Mosque</p>
            <p>Reference ID: {{ $contact->id }}</p>
            <p>Submitted from: {{ url('/') }}</p>
        </div>
    </div>
</body>
</html>