<script>
$(document).ready(function() {
    ajaxGrafCircular();
    ajaxGrafLine();
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            countForYears: [{
                    year: 2020,
                    count: 50
                },
                {
                    year: 2019,
                    count: 32
                },
                {
                    year: 2018,
                    count: 51
                },
                {
                    year: 2017,
                    count: 16
                }
            ]
        }),
        computed: {
            values() {
                return this.countForYears.map(x => x.count);
            },
            labels() {
                return this.countForYears.map(x => x.year);
            }
        }
    });




});
</script>
<script type="text/javascript">
function ajaxGrafCircular() {
    var xValues = [];
    var yValues = [];
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];
    $.ajax({
        type: "GET",
        url: '<?= base_url("/graficoCircular") ?>',
        success: function(response) {
            var json = JSON.parse(response);
            for (let i in json) {
                xValues[i] = [json[i]["Ciudad"]];
                yValues[i] = [json[i]["Numero"]];
            }
            var chartdata = {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            };
            var graphTarget = $("#myChart");
            var barGraph = new Chart(graphTarget, {
                type: 'doughnut',
                data: chartdata,
                options: {
                    title: {
                        display: true,
                        text: "World Wide Wine Production 2018"
                    }
                }
            });

        }
    });

}


function ajaxGrafLine() {
    var xValues = [];
    var yValues = [];
    var barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];
    $.ajax({
        type: "GET",
        url: '<?= base_url("/graficoLineaProducto") ?>',
        success: function(response) {
            var json = JSON.parse(response);
            for (let i in json) {
                xValues[i] = [json[i]["codigo"]];
                yValues[i] = [json[i]["cantidad"]];
            }
            var chartdata = {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: barColors,
                    data: yValues
                }]
            };
            var graphTarget1 = $("#myChart1");
            var barGraph1 = new Chart(graphTarget1, {
                type: 'bar',
                data: chartdata,
                options: {
                    legend: {display: false},
                }
            });

        }
    });

}
</script>