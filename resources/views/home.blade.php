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
