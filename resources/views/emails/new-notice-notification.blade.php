<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Notice from Ipswich Mosque</title>
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
        .notice-category {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .notice-title {
            color: #1f2937;
            font-size: 20px;
            margin: 10px 0;
        }
        .notice-content {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
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
            <p>New Notice Announcement</p>
        </div>

        <p>Assalamu Alaikum {{ $subscriber->name ?? 'Brother/Sister' }},</p>

        <p>We have posted a new notice on our mosque notice board:</p>

        <div class="notice-category">{{ $notice->category_label }}</div>
        <h2 class="notice-title">{{ $notice->title }}</h2>

        <div class="notice-content">
            @if($notice->summary)
                <p>{{ $notice->summary }}</p>
            @else
                <p>{{ Str::limit(strip_tags($notice->content), 200) }}</p>
            @endif
        </div>

        <div style="text-align: center;">
            <a href="{{ url('/notices/' . $notice->id) }}" class="btn">Read Full Notice</a>
        </div>

        <p>JazakAllah Khair for staying connected with our community.</p>

        <div class="footer">
            <p>This email was sent to {{ $subscriber->email }} because you subscribed to our newsletter.</p>
            <p><a href="{{ $unsubscribeUrl }}">Unsubscribe from future notices</a></p>
            <p>&copy; {{ date('Y') }} Ipswich Mosque. All rights reserved.</p>
        </div>
    </div>
</body>
</html>