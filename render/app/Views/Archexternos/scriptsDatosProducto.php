<script type="application/javascript">
$(document).ready(function() {

    var url = "https://jsonplaceholder.typicode.com/comments";
    var q = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                search: '',
                count: 1,
                Estado: true,
                columnas: [{
                        text: 'IDENTIFICACION',
                        value: 'Id',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'PRODUCTO',
                        value: 'Title',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'CALIDAD',
                        value: 'grafica',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'ACCIONES PARA MEJORAR',
                        value: 'Acciones',
                        sortable: false,
                        class: 'blue accent-2'
                    }
                ],
                articulos: [],
            }
        },
        created() {
            $.ajax({
                type: "post",
                url: '<?= base_url("/obtenerDatosProducto") ?>',
                data: {
                    'offset': 1
                },
                success: function(response) {
                    var json = JSON.parse(response);
                    q.articulos = json

                }
            });
        },
        methods: {
            deleteItem(item) {
                swal({
                        title: "¿Estás seguro?",
                        text: "Una vez eliminado, no podrá recuperar este archivo",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            this.articulos.splice(this.articulos.indexOf(item), 1);
                        }
                    });

            },
            Paginar(resultado) {
                q.Estado=false;
                if ("mas" === resultado) {
                    q.count = q.count + 1;
                    $.ajax({
                        type: "post",
                        url: '<?= base_url("/obtenerDatosProducto") ?>',
                        data: {
                            'offset': q.count
                        },
                        success: function(response) {
                            var json = JSON.parse(response);
                            q.articulos = json
                            q.Estado=true;
                        }
                    });

                } else {
                    q.count = q.count - 1;
                    $.ajax({
                        type: "post",
                        url: '<?= base_url("/obtenerDatosProducto") ?>',
                        data: {
                            'offset': q.count
                        },
                        success: function(response) {
                            var json = JSON.parse(response);
                            q.articulos = json
                            q.Estado=true;
                        }
                    });
                }

            },
        }
    })

    function ajaxGrafLine(xValues, yValues) {
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
                        legend: {
                            display: false
                        },
                    }
                });

            }
        });

    }


});
</script>

<style>
.mover {
    float: right;
}
</style>