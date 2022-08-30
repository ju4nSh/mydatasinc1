<script type="application/javascript">
$(document).ready(function() {
    var q = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                search: '',
                snack: false,
                snackColor: '',
                snackText: '',
                loading: true,
                columnas: [{
                        text: 'Nombre',
                        value: 'Nombre',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Contenido',
                        value: 'Contenido',
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
            $.ajax({
                type: "GET",
                url: '<?= base_url("/mostrarRolesRegistrados") ?>',
                success: function(response) {
                    var json = JSON.parse(response);
                    q.articulos = json
                    q.loading = false
                }
            });
        },
        methods: {
            deleteItem(item, Identificacion) {
                swal({
                        title: "¿Estás seguro?",
                        text: "Una vez eliminado, no podrá recuperar este archivo",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "post",
                                url: '<?= base_url("/eliminarClienteRef") ?>',
                                data: {
                                    "identificacion": Identificacion
                                },
                                success: function(response) {
                                    swal("Eliminado Correctamente", {
                                        icon: "success",
                                    });
                                    q.articulos.splice(q.articulos.indexOf(item), 1);
                                }
                            });

                        }
                    });
            },
            select: function(e) {
                var select = document.getElementById('prueba');
                var selected = [...select.selectedOptions]
                    .map(option => option.value);
                var nombre = document.getElementById('nombre').value;
                $.ajax({
                    type: "post",
                    url: '<?= base_url("/agregarNuevoRol") ?>',
                    data: {
                        'select': selected.toString(),
                        'nombre': nombre
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        if (json.error) {
                            swal("Verfique llenar todos los campos", {
                                icon: "warning",
                            });
                        } else {
                            q.articulos.push(json);
                            swal("Agregado Correctamente", {
                                icon: "success",
                            });
                            q.loading = false
                        }
                    }

                });


            }
        }
    })
});
</script>