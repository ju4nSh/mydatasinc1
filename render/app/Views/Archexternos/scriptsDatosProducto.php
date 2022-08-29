<script type="application/javascript">
$(document).ready(function() {
    var q = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                search: '',
                Estado: false,
                loading: true,
                page: 1,
                tamaño: 1,
                limit: 4,
                columnas: [{
                        text: 'Imagen',
                        value: 'foto',
                        class: 'blue accent-2'
                    },
                    {
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
                    },
                    {
                        value: 'form',
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
                    console.log(response);
                    var json = JSON.parse(response);
                    q.articulos = json
                    q.Estado = true;
                    q.loading = false
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
            next2() {
                q.Estado = false;
                q.loading = true;


                // if ("mas" === resultado) {
                //     q.count = q.count + 1;
                $.ajax({
                    type: "post",
                    url: '<?= base_url("/obtenerDatosProducto") ?>',
                    data: {
                        'offset': q.page
                    },
                    success: function(response) {
                        var json = JSON.parse(response);
                        q.articulos = json
                        q.Estado = true;
                        q.loading = false
                    }
                });

                // } else {
                //     q.count = q.count - 1;
                //     $.ajax({
                //         type: "post",
                //         url: '<?= base_url("/obtenerDatosProducto") ?>',
                //         data: {
                //             'offset': q.count
                //         },
                //         success: function(response) {
                //             var json = JSON.parse(response);
                //             q.articulos = json
                //             q.Estado=true;
                //             q.loading = false
                //         }
                //     });
                // }

            },

        }
    })

    Llenar_Paginacion();

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

    function Llenar_Paginacion() {
        $.ajax({
            type: "post",
            url: '<?= base_url("/obtenerPaginacion") ?>',
            data: {
                'limit': q.limit
            },
            success: function(response) {
               q.tamaño=parseInt(response);
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