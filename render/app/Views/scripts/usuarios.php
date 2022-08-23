<script>
    $(document).ready(function () {
        var app = new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data() {
                return {
                    search: '',
                    columnas: [{
                            text: 'IDENTIFICACION',
                            value: 'id',
                            class: 'blue accent-2'
                        },
                        {
                            text: 'NOMBRE',
                            value: 'nombre',
                            class: 'blue accent-2'
                        },
                        {
                            text: 'EMAIL',
                            value: 'correo',
                            class: 'blue accent-2'
                        },
    
                        {
                            text: 'Direccion',
                            value: 'direccion',
                            class: 'blue accent-2'
                        },
                        {
                            text: 'Actions',
                            value: 'actions',
                            sortable: false,
                            class: 'blue accent-2'
                        }
                    ],
                    articulos: [],
                }
            },
            created() {
                // axios.get(url).then(response => {
                var url = "<?= base_url("/listarClientes") ?>";
                // this.articulos = JSON.parse(response);
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        app.articulos = response.data
                    }
                });
                // });
                // $.ajax({
                //     url: "<? #= base_url("/listarClientes") ?>",
                //     dataType: "json",
                //     success: function(response) {
                //         console.log(response)
                //         this.articulos = response.data
                //     }
                // });
    
            },
            methods: {
                deleteItem(item) {
                    this.articulos.splice(this.articulos.indexOf(item), 1);
                },
                editItem(item) {
                    alert(item)
                    // this.articulos.splice(this.articulos.indexOf(item), 1);
                },
            }
        })
    });
</script>