<html>
<head>
    <title></title>
</head>
<body>
    <p> <?php echo $body?></p>
</body>
</html>
{{-- <!DOCTYPE html>
<html>
<head>
    <title>Meeting Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #ffffff;
            margin: 50px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .logo {
            max-width: 150px; /* Adjust logo width as needed */
            height: auto;
            display: block;
            margin: 0 auto;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content p {
            margin-bottom: 15px;
        }
        .footer {
            background-color: #f4f4f4;
            color: #aaaaaa;
            text-align: center;
            padding: 10px;
            border-radius: 0 0 10px 10px;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img class="logo" src="{{ asset('images/logo/Seser_logo_horizontal_purple.png') }}" alt="Logo">
            <h2>{{ $meetingDetails['title'] }}</h2>
        </div>
        <div class="content">
            <p>Dear {{ $meetingDetails['recipient_name'] }},</p>
            <p>You are invited to a meeting.</p>
            <p><strong>Date:</strong> {{ $meetingDetails['date'] }}</p>
            <p><strong>Time:</strong> {{ $meetingDetails['time'] }}</p>
            <p><strong>Location:</strong> {{ $meetingDetails['location'] }}</p>
            <p><strong>Agenda:</strong> {{ $meetingDetails['agenda'] }}</p>
            <p>Looking forward to your participation.</p>
            <p>Best regards,<br>{{ $meetingDetails['sender_name'] }}</p>
            <p>To add this meeting to your calendar, please use the attached file.</p>
            <p>
                Please let us know if you will be attending:<br>
                <a href="{{ url('/rsvp/' . $meetingDetails['id'] . '/yes?email=' . urlencode($meetingDetails['recipient_email'])) }}" style="color: green;">Yes</a> |
                <a href="{{ url('/rsvp/' . $meetingDetails['id'] . '/no?email=' . urlencode($meetingDetails['recipient_email'])) }}" style="color: red;">No</a>
            </p>
        </div>
        <div class="footer">
            <p>If you have any questions, please contact {{ $meetingDetails['sender_name'] }} at <a href="mailto:{{ $meetingDetails['s'] }}">{{ $meetingDetails['sender_email'] }}</a>.</p>
        </div>
    </div>
</body>
</html> --}}


