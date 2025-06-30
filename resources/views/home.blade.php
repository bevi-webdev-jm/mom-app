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


    
<div class="dashboard-header">
    <h2 class="dashboard-title" >Project management dashboard</h2>
    <p class="dashboard-description">Current progress in <b>week 22</b></p>
</div>
<div id="container-3">
    <div class="row">
        <div class="cell" id="current-sprint-kpi">
            <div class="row" id="current-sprint">
                <div class="cell" id="dashboard-kpi-1"></div>
                <div class="cell" id="dashboard-kpi-2"></div>
            </div>
        </div>
        <div class="cell" id="dashboard-kpi-4"></div>
    </div>
    <div class="row" id="charts-1">
        <div class="cell" id="dashboard-chart-1"></div>
        <div class="cell" id="dashboard-chart-2"></div>
    </div>
    <div class="row" id="cumulative">
        <div class="cell" id="dashboard-chart-cumulative"></div>
    </div>
</div>
    

@stop

{{-- Push extra CSS --}}

@push('css')
    <link rel="stylesheet" href="https://code.highcharts.com/css/highcharts.css">
    <style>
        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                "Apple Color Emoji",
                "Segoe UI Emoji",
                "Segoe UI Symbol",
                sans-serif;
        }

        :root,
        .highcharts-light {
            /* Colors for data series and points */
            --highcharts-color-0:rgb(16, 38, 99);
            --highcharts-color-1:rgb(47, 156, 4);
            --highcharts-color-2: #727e8d;
            --highcharts-color-3: #fc6556;
            --highcharts-color-5:rgb(36, 35, 35);
            --highcharts-neutral-color-100:rgb(0, 0, 0);
            --highcharts-neutral-color-5: #f2f2f2;
            --highcharts-neutral-color-3: #f7f7f7;
            --highcharts-neutral-color-0: #fff;

            /* General */
            --highcharts-background-color: #fff;

            /* Extra colors */
            --gray: #ccc;
        }

        /* @media (prefers-color-scheme: dark) {
            
        } */

        #container-3 {
            /* background-color: var(--highcharts-neutral-color-5); */
            padding: 20px 10px;
            position: relative;
        }

        .row {
            display: flex;
            position: relative;
        }

        .cell {
            border: 1px solid transparent;
            border-radius: 10px;
            position: relative;
            min-width: 20px;
            height: 300px;
        }

        .highcharts-dashboards-component {
            color: var(--highcharts-neutral-color-100);
        }

        .highcharts-dashboards-component-title {
            font-size: 1.2em;
            text-align: left;
            margin: 1em;
        }

        .cell > .highcharts-dashboards-component {
            position: relative;
            background-color: var(--highcharts-background-color);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            margin: 5px;
            border-radius: 10px;
            overflow: hidden;
        }

        .dashboard-header .dashboard-title {
            padding-top: 20px;
        }

        .dashboard-header .dashboard-title,
        .dashboard-header .dashboard-description {
            background-color: var(--highcharts-neutral-color-5);
            color: var(--highcharts-neutral-color-100);
            margin: 0;
            padding-left: 20px;
        }

        .highcharts-dashboards-component-kpi-content {
            display: flex;
            flex-direction: column;
        }

        .highcharts-dashboards-component.highcharts-dashboards-component-kpi-value {
            font-size: 4em;
            margin-top: 40px;
        }

        .highcharts-dashboards-component-kpi {
            text-align: center;
        }

        .highcharts-dashboards-component-kpi-content .highcharts-dashboards-component-subtitle {
            font-size: 1.4em;
        }

        #dashboard-kpi-3 .highcharts-dashboards-component .highcharts-point.highcharts-color-0 {
            fill: var(--highcharts-neutral-color-100);
        }

        .highcharts-dashboards-component.highcharts-dashboards-component-kpi,
        .highcharts-dashboards-component.highcharts-dashboards-component-highcharts {
            border-radius: 10px;
        }

        .highcharts-dashboards-component.highcharts-dashboards-component-kpi-chart-container .highcharts-background {
            fill: transparent;
        }

        #dashboard-chart-1 .highcharts-point.highcharts-color-0,
        #dashboard-chart-2 .highcharts-color-0 {
            fill: var(--highcharts-color-5);
            stroke: var(--highcharts-color-5);
        }

        #dashboard-chart-2 .highcharts-grid-axis .highcharts-tick,
        #dashboard-chart-2 .highcharts-axis-line {
            stroke-width: 0;
        }

        #dashboard-chart-2 .highcharts-data-label text {
            fill: var(--highcharts-neutral-color-0);
        }

        .highcharts-plot-line {
            stroke-width: 3px;
            stroke: #f00;
        }

        .highcharts-plot-line-label {
            fill: var(--highcharts-neutral-color-100);
            font-size: 1em;
            font-weight: bold;
        }

        #dashboard-kpi-1,
        #dashboard-kpi-2,
        #dashboard-kpi-4,
        #current-sprint-kpi {
            flex: 1 1 50%;
            height: 300px;
        }

        #dashboard-chart-1,
        #dashboard-chart-2,
        #dashboard-chart-cumulative {
            height: 350px;
        }

        #dashboard-chart-1 {
            flex: 1 1 20%;
        }

        #dashboard-chart-2 {
            flex: 1 1 60%;
        }

        #dashboard-chart-cumulative {
            flex: 1 1 100%;
        }

        /* LARGE */
        @media (max-width: 1200px) {
            #dashboard-kpi-1,
            #dashboard-kpi-2,
            #current-sprint-kpi,
            #dashboard-kpi-4 {
                flex: 1 1 50%;
            }

            #dashboard-chart-1 {
                flex: 1 1 20%;
            }

            #dashboard-chart-2 {
                flex: 1 1 60%;
            }
        }

        /* MEDIUM */
        @media (max-width: 992px) {
            .row {
                flex-direction: column;
            }

            #current-sprint-kpi {
                height: auto;
            }

            #current-sprint.row {
                flex-direction: row;
            }

            #dashboard-kpi-1,
            #dashboard-kpi-2 {
                flex: 1 1 50%;
            }

            #dashboard-kpi-4,
            #dashboard-chart-1,
            #dashboard-chart-2,
            #current-sprint-kpi {
                flex: 1 1 100%;
            }
        }

        /* MEDIUM */
        @media (max-width: 576px) {
            #current-sprint,
            #current-sprint.row {
                flex-direction: column;
                flex-wrap: wrap;
            }
        }

        .highcharts-description {
            margin: 0.3rem 10px;
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
                styledMode: true
            }
        });
        const plotLines = [{
            label: {
                text: 'Today',
                align: 'left',
                rotation: 0,
                y: 0
            },
            value: Date.UTC(2025, 4, 16),
            zIndex: 7
        }];

        Highcharts.setOptions({
            credits: {
                enabled: false
            },
            title: {
                text: ''
            }
        });

        Dashboards.board('container-3', {
            dataPool: {
                connectors: [{
                    id: 'cumulativeData',
                    type: 'JSON',
                    options: {
                        data: [
                            ['Date', 'Done', 'To Do', 'Blocked'],
                            [Date.UTC(2025, 4, 1), 0, 156, 30],
                            [Date.UTC(2025, 4, 8), 23, 134, 30],
                            [Date.UTC(2025, 4, 15), 45, 111, 30],
                            [Date.UTC(2025, 4, 22), 68, 89, 13],
                            [Date.UTC(2025, 4, 29), 85, 93, 2],
                            [Date.UTC(2025, 5, 5), 113, 51, 8],
                            [Date.UTC(2025, 5, 12), null, 51, 8]
                        ]
                    }
                }, {
                    id: 'taskByAssignee',
                    type: 'JSON',
                    options: {
                        data: [
                            ['Assignee', 'Completed tasks'],
                            ['Alex', 41],
                            ['Jasmine', 28],
                            ['Ryan', 15],
                            ['Emily', 14],
                            ['Jordan', 4]
                        ]
                    }
                }]
            },
            components: [{
                renderTo: 'dashboard-kpi-1',
                type: 'KPI',
                title: 'Completed tasks',
                subtitle: 'tasks completed',
                linkedValueTo: {
                    enabled: false
                }
            }, {
                renderTo: 'dashboard-kpi-2',
                type: 'KPI',
                title: 'Incomplete tasks',
                subtitle: 'to be done',
                linkedValueTo: {
                    enabled: false
                }
            }, {
                renderTo: 'dashboard-kpi-4',
                type: 'Highcharts',
                title: 'Tasks by status',
                chartOptions: {
                    series: [{
                        type: 'pie',
                        keys: ['name', 'y'],
                        innerSize: '50%',
                        size: '110%',
                        showInLegend: true,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}: {point.percentage:,.1f}%'
                        }
                    }],
                    legend: {
                        enabled: true,
                        align: 'right',
                        verticalAlign: 'center',
                        layout: 'vertical'
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: `<span style="color:{point.color}">\u25CF</span>
                            Tasks {point.name}: <b>{point.y}</b><br/>`
                    },
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 450
                            },
                            chartOptions: {
                                legend: {
                                    align: 'center',
                                    verticalAlign: 'bottom',
                                    layout: 'horizontal'
                                }
                            }
                        }]
                    },
                    lang: {
                        accessibility: {
                            chartContainerLabel: `Tasks by status, current sprint.
                                Highcharts Interactive Chart.`
                        }
                    },
                    accessibility: {
                        description: `The chart shows the number of tasks by status.
                            Pie is divided into four parts, to do, in progress, done and
                            blocked.`,
                        point: {
                            descriptionFormat: '{name}: {y} tasks.'
                        }
                    }
                }
            }, {
                renderTo: 'dashboard-chart-1',
                type: 'Highcharts',
                title: 'Total tasks by assignee',
                connector: {
                    id: 'taskByAssignee'
                },
                chartOptions: {
                    chart: {
                        type: 'column'
                    },
                    xAxis: {
                        type: 'category',
                        accessibility: {
                            description: 'Developer'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Completed tasks'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    lang: {
                        accessibility: {
                            chartContainerLabel: `Total tasks by assignee. Highcharts
                                Interactive Chart.`
                        }
                    },
                    accessibility: {
                        description: `The chart shows the number of completed tasks by
                            assignee.`
                    }
                }
            }, {
                renderTo: 'dashboard-chart-2',
                type: 'Highcharts',
                title: 'Timeline',
                chartConstructor: 'ganttChart',
                chartOptions: {
                    chart: {
                        marginLeft: 10
                    },
                    xAxis: [{
                        plotLines,
                        dateTimeLabelFormats: {
                            day: '%e<br><span style="opacity: 0.5; font-size: ' +
                                '0.7em;">%a</span>'
                        },
                        grid: {
                            borderWidth: 0
                        },
                        accessibility: {
                            description: 'Timeline axis.'
                        }
                    }],
                    yAxis: {
                        labels: {
                            enabled: false
                        },
                        staticScale: 20
                    },
                    plotOptions: {
                        series: {
                            borderRadius: '50%',
                            groupPadding: 0,
                            colorByPoint: false,
                            dataLabels: [{
                                enabled: true,
                                format: '{point.name}'
                            }]
                        }
                    },
                    tooltip: {
                        headerFormat: ''
                    },
                    series: [{
                        data: [{
                            name: 'F:1352',
                            start: Date.UTC(2025, 4, 1, 9),
                            end: Date.UTC(2025, 4, 19, 17)
                        }, {
                            name: 'I.20-00',
                            start: Date.UTC(2025, 4, 1, 9),
                            end: Date.UTC(2025, 4, 5, 17)
                        }, {
                            name: 'I.20-01',
                            start: Date.UTC(2025, 4, 8, 9),
                            end: Date.UTC(2025, 4, 12, 17)
                        }, {
                            name: 'F:2741',
                            start: Date.UTC(2025, 4, 15, 9),
                            end: Date.UTC(2025, 5, 2, 17)
                        }, {
                            name: 'I.20-02',
                            start: Date.UTC(2025, 4, 15, 9),
                            end: Date.UTC(2025, 4, 19, 17)
                        }, {
                            name: 'I.20-03',
                            start: Date.UTC(2025, 4, 22, 9),
                            end: Date.UTC(2025, 4, 26, 17)
                        }, {
                            name: 'I.20-04',
                            start: Date.UTC(2025, 4, 29, 9),
                            end: Date.UTC(2025, 5, 2, 17)
                        }, {
                            name: 'I.20-05',
                            start: Date.UTC(2025, 5, 5, 9),
                            end: Date.UTC(2025, 5, 9, 17)
                        }, {
                            name: 'F:1982',
                            start: Date.UTC(2025, 4, 1, 9),
                            end: Date.UTC(2025, 4, 26, 17)
                        }, {
                            name: 'F:673',
                            start: Date.UTC(2025, 4, 29, 9),
                            end: Date.UTC(2025, 5, 9, 17)
                        }]
                    }],
                    lang: {
                        accessibility: {
                            chartContainerLabel: `Timeline of the project. Highcharts
                                Interactive Chart.`
                        }
                    },
                    accessibility: {
                        description: `The chart shows the timeline of the project. It is
                            divided into tasks. There also is a line indicating today's
                            date.`,
                        typeDescription: `The Gantt chart shows the timeline of
                            the project.`,
                        point: {
                            descriptionFormatter: function (point) {
                                return `Task ${point.name} starts on
                                ${Highcharts.dateFormat('%e %b %Y', point.start)}, ends
                                on ${Highcharts.dateFormat('%e %b %Y', point.end)}.`;
                            }
                        }
                    }
                }
            }, {
                renderTo: 'dashboard-chart-cumulative',
                type: 'Highcharts',
                title: 'Cumulative flow',
                connector: {
                    id: 'cumulativeData',
                    columnAssignment: [{
                        seriesId: 'Done',
                        data: ['Date', 'Done']
                    }, {
                        seriesId: 'To Do',
                        data: ['Date', 'To Do']
                    }, {
                        seriesId: 'Blocked',
                        data: ['Date', 'Blocked']
                    }]
                },
                chartOptions: {
                    chart: {
                        type: 'area'
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal',
                            label: {
                                enabled: true,
                                useHTML: true
                            }
                        }
                    },
                    xAxis: {
                        type: 'datetime',
                        plotLines,
                        accessibility: {
                            description: `Axis showing the time from the start of the
                            project (1 May 2023) to the end of if (12 June 2023). With
                            today's date marked.`
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Number of tasks'
                        },
                        accessibility: {
                            description: 'Number of tasks.'
                        }
                    },
                    legend: {
                        enabled: true,
                        align: 'left',
                        verticalAlign: 'top',
                        floating: false
                    },
                    lang: {
                        accessibility: {
                            chartContainerLabel: `Tasks status over time. Highcharts
                                Interactive Chart.`
                        }
                    },
                    accessibility: {
                        description: `The chart shows the number of tasks by status
                            over time. The chart is divided into three parts, to do,
                            done and blocked. There also is a line indicating today's
                            date.`,
                        point: {
                            descriptionFormatter: function (point) {
                                return `Week from
                                    ${Highcharts.dateFormat('%e %b %Y', point.x)} Tasks
                                    ${point.series.name}: ${point.y}`;
                            }
                        },
                        series: {
                            descriptionFormat: 'Tasks that are {series.name}.'
                        }
                    }
                }
            }]
        }, true).then(dashboard => {
            const completedTaskKPI = dashboard.mountedComponents[0].component,
                incompleteTaskKPI = dashboard.mountedComponents[1].component,
                taskByStatusChart = dashboard.mountedComponents[2].component,
                connectors = dashboard.dataPool.connectors,
                cumulativeData = connectors.cumulativeData.table.columns,
                completedTask = cumulativeData.Done[5] - cumulativeData.Done[4],
                planedTask = cumulativeData['To Do'][4] - cumulativeData['To Do'][5],
                blockedTask = cumulativeData.Blocked[5] - cumulativeData.Blocked[4],
                inProgressTask = planedTask - completedTask;

            completedTaskKPI.setValue(completedTask);
            incompleteTaskKPI.setValue(inProgressTask);

            taskByStatusChart.chart.series[0].update({
                data: [
                    ['Done', completedTask],
                    ['To Do', inProgressTask],
                    ['In Progress', inProgressTask],
                    ['Blocked', blockedTask]
                ]
            });
        });

    </script>
@endpush
