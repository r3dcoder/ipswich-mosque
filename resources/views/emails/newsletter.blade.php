<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #10b981;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #10b981;
            margin: 0;
            font-size: 24px;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
        .footer a {
            color: #10b981;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Ipswich Mosque</h1>
            <p>Newsletter</p>
        </div>

        <p>Assalamu Alaikum {{ $subscriber->name ?? 'Brother/Sister' }},</p>

        <div class="content">
            {!! $content !!}
        </div>

        @if($notice)
            <div style="margin-top: 30px; padding: 20px; background-color: #f9fafb; border-radius: 4px; border-left: 4px solid #10b981;">
                <h3 style="margin-top: 0; color: #1f2937;">Related Notice</h3>
                <p><strong>{{ $notice->title }}</strong></p>
                <p>{{ Str::limit(strip_tags($notice->content), 150) }}</p>
                <p><a href="{{ url('/notices/' . $notice->id) }}" style="color: #10b981;">Read more →</a></p>
            </div>
        @endif

        <p>JazakAllah Khair for being part of our community.</p>

        <div class="footer">
            <p>This email was sent to {{ $subscriber->email }} because you subscribed to our newsletter.</p>
            <p><a href="{{ $unsubscribeUrl }}">Unsubscribe from future newsletters</a></p>
            <p>&copy; {{ date('Y') }} Ipswich Mosque. All rights reserved.</p>
        </div>
    </div>
</body>
</html>