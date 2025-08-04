<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Minutes of Meeting</title>

    <style>
        /* All of your existing styles */
        body {
            font-family: sans-serif;
            margin-top: 50px; /* Add margin-top to prevent content from being hidden by the fixed header */
        }
        .pdf-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 40px; /* Adjust height as needed */
            padding: 5px;
            background-color: #fff; /* Ensure the header has a white background */
            z-index: 1000;
        }

        .table {
             width: 100%;
             margin-bottom: 0.3rem;
            border-collapse: collapse;
        }
        .table thead {
            display: table-header-group;
            vertical-align: top;
        }
        .table tbody {
            display: table-row-group;
            vertical-align: middle;
        }
        .table tr {
            display: table-row;
        }
        .table th, td {
            border: 1px solid rgb(16, 16, 16);
            padding: 4px;
            font-size: 14px;
            text-align: left;
        }
        .table-sm td, th {
            padding: 0.3rem;
        }

        .logo {
            height: 30px;
        }

        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .text-left {
            text-align: left !important;
        }
        .align-middle {
            vertical-align: middle;
        }

        .border-0 {
            border: 0 !important;
        }
        .text-muted {
            color: #6c757d !important;
        }
        .text-uppercase {
            text-transform: uppercase !important;
        }
        .text-bold {
            font-weight: bold !important;
        }
        .text-justify {
            text-align: justify !important;
        }

        .w-50 {
            width: 50% !important;
        }

        .bg-gray {
            background-color: rgba(8, 8, 8, 1);
            color: white;
        }
        .bg-info {
            background-color: rgba(223, 223, 223, 1);
        }
        .bg-primary {
            background-color: rgba(182, 217, 255, 1);
        }

        .float-right {
            float: right;
        }

        .bg-status {
            padding-left: 5px;
            padding-right: 5px;
            padding-bottom: 3px;
            border-radius: 5px;
        }

        .bg-secondary {
            background-color: gray;
        }
        .bg-danger {
            background-color: red;
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .bg-warning {
            background-color: yellow;
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        .bg-success {
            background-color: green;
            padding-left: 5px;
            padding-right: 5px;
            padding-top: 3px;
            padding-bottom: 3px;
        }
        /* New and updated styles for the log section */
        .log-date {
            background-color: #f0f0f0;
            font-weight: bold;
            padding: 8px;
            display: block;
            margin-top: 10px;
        }
        .log-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .log-list li {
            border-bottom: 1px solid #eee;
            padding: 5px 0;
        }
        .log-list li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>

    <div class="pdf-header">
        <table class="table border-0">
            <tr>
                <td class="align-middle border-0">
                    <img src="{{public_path('/assets/logo/BEVI.jpg')}}" alt="logo" class="logo">
                    <img src="{{public_path('/assets/logo/asia.jpg')}}" alt="logo" class="logo">
                </td>
                <td class="text-right align-middle border-0" style="font-size: 14px">
                    <u class="text-muted">{{$mom->mom_number}}</u>
                </td>
            </tr>
        </table>
    </div>

    <div class="main-content">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" class="bg-gray">
                        HEADER DETAILS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="w-50">
                        <span>PREPARED BY: </span>
                        <strong class="text-uppercase">{{$mom->user->name}}</strong>
                    </td>
                    <td class="w-50">
                        <span>DATE PREPARED: </span>
                        <strong class="text-uppercase">{{date('F j, Y', strtotime($mom->created_at))}}</strong>
                    </td>
                </tr>
                <tr>
                    <td class="w-50">
                        <span>STATUS: </span>
                        <strong class="text-uppercase">{{$mom->status}}</strong>
                    </td>
                    <td class="w-50">
                        <span>DATE OF THE MEETING: </span>
                        <strong class="text-uppercase">{{$mom->meeting_date}}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>PURPOSE OF THE MEETING: </span><br>
                        <strong class="text-justify">
                            {{$mom->agenda}}
                        </strong>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th class="bg-gray">
                        ATTENDEES
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <ol>
                            @foreach($mom->participants as $participant)
                                <li class="text-bold align-middle">
                                    {{$participant->name}}
                                </li>
                            @endforeach
                        </ol>
                    </td>
                </tr>
            </tbody>
        </table>

        @foreach($mom->details as $detail)
            @php
                $status = \App\Http\Controllers\MomController::checkDaysExtended($detail);
            @endphp
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="4" class="bg-gray">
                            TOPIC
                            <span class="bg-status bg-{{$status_arr[$status]}} float-right">{{$status}}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center align-middle bg-info">TOPIC</th>
                        <th class="text-center align-middle bg-info">NEXT STEPS</th>
                        <th class="text-center align-middle bg-info">RESPONSIBLE</th>
                        <th class="text-center align-middle bg-info">TARGET DATE</th>
                    </tr>
                    <tr>
                        <td>
                            {{$detail->topic}}
                        </td>
                        <td class="text-justify">
                            {{$detail->next_step}}
                        </td>
                        <td class="text-center">
                            @foreach($detail->responsibles as $responsible)
                                <strong>{{$responsible->name}}</strong> <br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            {{date('F j, Y', strtotime($detail->target_date))}}
                        </td>
                    </tr>
                    @if($detail->actions->count() > 0)
                        @foreach ($detail->actions as $action)
                            <tr>
                                <th class="text-center align-middle bg-primary">ACTION TAKEN</th>
                                <th class="text-center align-middle bg-primary">REMARKS</th>
                                <th class="text-center align-middle bg-primary">USER</th>
                                <th class="text-center align-middle bg-primary">DATE</th>
                            </tr>
                            <tr>
                                <td class="text-justify">
                                    {{$action->action_taken}}
                                </td>
                                <td class="text-justify">
                                    {{$action->remarks}}
                                </td>
                                <td class="text-center">
                                    {{$action->user->name}}
                                </td>
                                <td class="text-center">
                                    {{date('F j, Y H:i:s a', strtotime($action->created_at))}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th class="text-center align-middle bg-primary">ACTION TAKEN</th>
                            <th class="text-center align-middle bg-primary">REMARKS</th>
                            <th class="text-center align-middle bg-primary">USER</th>
                            <th class="text-center align-middle bg-primary">DATE</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-center">
                                - No action taken yet -
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach
        

        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" class="bg-gray">
                        REMARKS
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" class="text-justify">
                        {{$mom->remarks}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- MOM HISTORY LOGS -->
    <div class="pdf-footer">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="2" class="bg-gray">MOM HISTORY LOGS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($approval_data as $date => $data)
                    <tr>
                        <td colspan="2">
                            <span class="log-date">{{date('F j, Y', strtotime($date))}}</span>
                            <ul class="log-list">
                                @foreach($data as $approval)
                                    <li>
                                        <strong>{{date('F j, Y H:i:s a', strtotime($approval->created_at))}}</strong> - {{ $approval->user->name }} - {{ $approval->remarks }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>