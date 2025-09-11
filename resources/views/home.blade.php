@extends('layouts.app')

{{-- Customize layout sections --}}

@section('subtitle', __('adminlte::adminlte.welcome'))
@section('content_header_title', __('adminlte::adminlte.home'))
@section('content_header_subtitle', __('adminlte::adminlte.welcome'))

{{-- Content body: main page content --}}

@section('content_body')
<div class="dashboard-header mb-2">
    <h2 class="dashboard-title" >MoM Dashboard</h2>
    <p class="dashboard-description">Current progress in <b>{{\Carbon\Carbon::now()->weekOfYear}} Week\s</b></p>
</div>

<div id="container-3">
    <div class="row">
        <div class="col-lg-6">
            <livewire:dashboard.status/>
        </div>
        <div class="col-lg-6">
            <livewire:dashboard.user-completed/>
        </div>

        <div class="col-12">
            <livewire:dashboard.timeline/>
        </div>
    </div>
</div>
    

@stop

{{-- Push extra CSS --}}

@push('css')
    <style>
        .dashboard-header {
            background-color: white;
            padding-left: 10px;
            border-radius: 2px;
        }
        .dark-mode .dashboard-header {
            background-color: #1e1e1e;
        }
    </style>

    <style>
        .dark-mode .highcharts-background {
            fill: black;
        }
        .dark-mode .highcharts-title {
            color: white !important;
            fill: white !important;
        }
        .dark-mode .highcharts-subtitle {
            color: white !important;
            fill: white !important;
        }
        .dark-mode .highcharts-axis-title,
        .dark-mode .highcharts-axis-labels > text,
        .dark-mode .highcharts-legend-item > text {
            color: white !important;
            fill: white !important;
        }

        .dark-mode .highcharts-markers > path {
            fill: rgb(255, 128, 0) !important;
            stroke:rgb(235, 148, 17) !important;
        }

        .dark-mode .highcharts-series > rect {
            fill:rgb(0, 195, 249) !important;
        }
        .dark-mode .highcharts-graph {
            stroke: rgb(235, 148, 17);
        }

        .dark-mode .highcharts-series-1 .highcharts-point {
            fill: rgb(255, 128, 0) !important;
        }
        .dark-mode .highcharts-series-0 .highcharts-point {
            fill:rgb(0, 195, 249) !important;
        }


        .dark-mode .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #ebebeb;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .dark-mode .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .dark-mode.highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .dark-mode .highcharts-data-table td,
        .dark-mode .highcharts-data-table th,
        .dark-mode .highcharts-data-table caption {
            padding: 0.5em;
        }

        .dark-mode .highcharts-data-table thead tr,
        .dark-mode .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .dark-mode .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }
    </style>
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/gantt/modules/gantt.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/dashboards/dashboards.js"></script>
    <script src="https://code.highcharts.com/dashboards/modules/layout.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script>
        Highcharts.setOptions({
            chart: {
                style: {
                    fontSize: '12px',
                    fontFamily: 'Arial, sans-serif',
                    lineHeight: '14px'
                }
            },
            title: {
                style: {
                    fontSize: '16px',
                    lineHeight: '14px'
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    lineHeight: '12px'
                }
            },
            legend: {
                itemStyle: {
                    fontSize: '12px',
                    lineHeight: '12px'
                }
            },
            xAxis: {
                labels: {
                    style: {
                        fontSize: '12px',
                        lineHeight: '12px'
                    }
                }
            },
            yAxis: {
                labels: {
                    style: {
                        fontSize: '12px',
                        lineHeight: '12px'
                    }
                }
            }
        });
    </script>
@endpush
