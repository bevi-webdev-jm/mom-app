<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailTitle ?? 'MOM Detail Submitted' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f0f2f5; /* Lighter background */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #f6ebdb;
            padding: 30px; /* Increased padding */
            border-radius: 8px;
            border: 1px solid #e0e0e0; /* Subtle border */
            box-shadow: 0 4px 12px rgba(0,0,0,0.08); /* Softer shadow */
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            margin-bottom: 20px; /* Added margin for separation */
            border-bottom: 1px black solid; /* Lighter border */
        }
        .header h1 {
            margin: 0;
            font-size: 24px; /* Slightly larger */
            color: #1d2d35; /* Darker, more professional color */
            text-transform: uppercase; /* Make text uppercase */
        }
        .content {
            padding: 10px 0; /* Adjusted padding */
            font-size: 16px;
            color:rgb(41, 41, 41);
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 15px;
            background-color:rgb(255, 248, 232); /* Make table background white */
        }
        .content th, .content td {
            text-align: left;
            padding: 5px 10px; /* Increased padding */
            border-bottom: 1px solid #e9ecef; /* Lighter border */
        }
        .content th {
            background-color:rgb(155, 141, 104); /* Light background for headers */
            color: #ffffff;
            font-weight: 600;
        }
        .content tr:last-child td {
            border-bottom: none; /* Remove border from last row */
        }
        .button-container {
            text-align: center;
            padding: 25px 0; /* Increased padding */
        }
        .button {
            background-color: #001f3f; /* Theme button color */
            color:rgb(255, 255, 255) !important; /* Light text for contrast, !important for email clients */
            padding: 12px 25px; /* Adjusted padding */
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-weight: 500;
            font-size: 16px;
            border: 1px solid #E7D8C0; /* Border matching the theme */
            transition: background-color 0.2s ease-in-out;
        }
        .button:hover {
            background-color:rgb(1, 64, 128); /* Darker shade of theme on hover */
            color: rgb(255, 255, 255) !important; /* Ensure hover text color also overrides defaults */
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 20px; /* Added margin for separation */
            border-top: 1px black solid; /* Lighter border */
            font-size: 0.9em;
            color: #1d2d35; /* Softer footer text color */
        }
        .logo-placeholder { /* Optional: if you want to add a logo */
            max-width: 150px;
            margin-bottom: 15px;
        }
        .confidentiality-notice {
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid black;
            font-size: 0.8em;
            color: #1d2d35;
            background-color:rgb(240, 187, 177);
        }
        .confidentiality-notice p {
            margin: 0;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{-- Optional: Add a logo here --}}
            <img src="{{ asset('/images/mom-logo.png') }}" alt="{{ config('app.name', 'MOM App') }} Logo" class="logo-placeholder">
            <h1>{{ $emailHeading ?? 'MOM DETAIL SUBMITTED' }}</h1>
        </div>
        <div class="content">
            @if(isset($greeting) && !empty($greeting))
                <p>{{ $greeting }}</p>
            @endif
            @foreach($introLines ?? [] as $line)
                <p>{!! $line !!}</p>
            @endforeach
            <table>
                <tr>
                    <th>Field</th>
                    <th>Value</th>
                </tr>
                <tr>
                    <td>Topic</td>
                    <td>{{ $detail->topic }}</td>
                </tr>
                <tr>
                    <td>Next Step</td>
                    <td>{{ $detail->next_step }}</td>
                </tr>
                <tr>
                    <td>Target Date</td>
                    <td>{{ \Carbon\Carbon::parse($detail->target_date)->format('F j, Y') }}</td>
                </tr>
            </table>
        </div>
        <div class="button-container">
            <a href="{{ url('mom/' . encrypt($mom->id)) }}" class="button">View MOM</a>
        </div>
        <div class="content">
            @foreach($outroLines ?? [] as $line)
                <p>{!! $line !!}</p>
            @endforeach
        </div>
        <div class="footer">
            <p>Thank you,<br><strong>{{ config('app.name') }}</strong></p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
        <div class="confidentiality-notice">
            <strong>CONFIDENTIALITY NOTICE:</strong> 
            <p>
                This communication is intended solely for the individual(s) to whom it is addressed. This email which includes any attachments is confidential. If you are not the intended recipient of this communication, you may not disseminate, distribute, copy or otherwise disclose or use the contents of this communication without the written authority of Beauty Elements Ventures, Inc. If you have received this communication in error, please delete and destroy all copies and kindly notify the sender by email or call them immediately. Thank you.
            </p>
        </div>
    </div>
</body>
</html>