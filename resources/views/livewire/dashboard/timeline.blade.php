<div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <figure class="highcharts-figure">
                <div id="container-timeline"></div>
            </figure>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            window.addEventListener('update-chart-3', event => {
                const data = event.detail.data;

                Highcharts.ganttChart('container-timeline', {
                    chart: {
                        height: 600
                    },

                    title: {
                        text: 'Mom Timeline'
                    },

                    yAxis: {
                        uniqueNames: true,
                        scrollbar: {
                            enabled: true
                        },
                        max: 10,
                        labels: {
                            style: {
                                lineHeight: '14px'
                            }
                        }
                    },

                    tooltip: {
                        useHTML: true,
                        formatter: function() {
                            var point = this.point;
                            return '<b>Mom Number:</b> ' + point.name + '<br/>' +
                                   '<b>Title:</b> ' + (point.options.title || '') + '<br/>' +
                                   '<b>Status:</b> ' + (point.options.status || '') + '<br/>' +
                                   '<b>Start:</b> ' + Highcharts.dateFormat('%Y-%m-%d', point.start) + '<br/>' +
                                   '<b>End:</b> ' + Highcharts.dateFormat('%Y-%m-%d', point.end);
                        }
                    },

                    plotOptions: {
                        gantt: {
                            completed: {
                                color: 'green'
                            },
                            color: 'navy'
                        }
                    },

                    navigator: {
                        enabled: true,
                        liveRedraw: true,
                        series: {
                            type: 'gantt',
                            pointPlacement: 0.5,
                            pointPadding: 0.25,
                            accessibility: {
                                enabled: false
                            }
                        },
                        yAxis: {
                            min: 0,
                            max: 3,
                            reversed: true,
                            categories: []
                        }
                    },

                    scrollbar: {
                        enabled: true
                    },

                    rangeSelector: {
                        enabled: true,
                        selected: 0
                    },

                    accessibility: {
                        point: {
                            descriptionFormat: '{yCategory}. ' +
                                '{#if completed}Task {(multiply completed.amount 100):.1f}% ' +
                                'completed. {/if}' +
                                'Start {x:%Y-%m-%d}, end {x2:%Y-%m-%d}.'
                        },
                        series: {
                            descriptionFormat: '{name}'
                        }
                    },

                    lang: {
                        accessibility: {
                            axis: {
                                xAxisDescriptionPlural: 'The chart has a two-part X axis ' +
                                    'showing time in both week numbers and days.',
                                yAxisDescriptionPlural: 'The chart has one Y axis showing ' +
                                    'task categories.'
                            }
                        }
                    },

                    series: [{
                        name: 'Timeline and Completion',
                        data: data
                    }]
                });
            });
        });
    </script>
</div>
