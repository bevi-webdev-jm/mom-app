@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', __('adminlte::adminlte.welcome'))
@section('content_header_title', __('adminlte::adminlte.home'))
@section('content_header_subtitle', __('adminlte::adminlte.welcome'))

{{-- Content body: main page content --}}

@section('content_body')
    <a href="{{route('test-notification')}}" class="btn btn-primary btn-sm test-notification-btn">
        {{ __('adminlte::adminlte.test_notification') }}
    </a>

    <div class="row">
        <div class="col-lg-6">
            <livewire:dashboard.status/>
        </div>
        <div class="col-lg-6">
            <livewire:dashboard.user-completed/>
        </div>
    </div>
    

@stop

{{-- Push extra CSS --}}

@push('css')
    <style>
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            /* max-width: 660px; */
            margin: 1em auto;
            margin-bottom: 0;
            margin-top: 0;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tbody tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    

    

</script>
@endpush
