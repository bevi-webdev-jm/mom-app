<div>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <figure class="highcharts-figure">
                <div id="container-2"></div>
            </figure>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            window.addEventListener('update-chart-2', event => {
                const data = event.detail.data;

                Highcharts.chart('container-2', {
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Historic World Population by Region'
                    },
                    subtitle: {
                        text: 'Source: <a ' +
                            'href="https://en.wikipedia.org/wiki/List_of_continents_and_continental_subregions_by_population"' +
                            'target="_blank">Wikipedia.org</a>'
                    },
                    xAxis: {
                        categories: data.categories,
                        title: {
                            text: null
                        },
                        gridLineWidth: 1,
                        lineWidth: 0
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Topics',
                            align: 'high'
                        },
                        labels: {
                            overflow: 'justify'
                        },
                        gridLineWidth: 0
                    },
                    tooltip: {
                        valueSuffix: ' Topics'
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: '50%',
                            dataLabels: {
                                enabled: true
                            },
                            groupPadding: 0.1
                        }
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        x: -40,
                        y: 80,
                        floating: true,
                        borderWidth: 1,
                        backgroundColor:
                            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
                        shadow: true
                    },
                    credits: {
                        enabled: false
                    },
                    series: data.series
                });
            });
        });
    </script>
</div>
