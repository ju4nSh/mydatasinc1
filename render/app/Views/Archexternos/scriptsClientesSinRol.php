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
                        value: 'fulname',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Correo',
                        value: 'Correo',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Ciudad',
                        value: 'Ciudad',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Pais',
                        value: 'Pais',
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
                Id: '',
                roles: [],
            }
        },
        methods: {
            llenarDatosTablaCliente(){
            $.ajax({
                type: "GET",
                url: '<?= base_url("/PersonasRolNull") ?>',
                success: function(response) {
                    var json = JSON.parse(response);
                    q.articulos = json
                    q.loading = false
                }
            });
            $.ajax({
                type: "GET",
                url: '<?= base_url("/mostrarRolesRegistrados") ?>',
                success: function(response) {
                    var json = JSON.parse(response);
                    q.roles = json
                }
            });               
        },
            ActualizarItem(item, Identificacion) {
                swal({
                        title: "¿Estás seguro?",
                        text: "Una vez actualizado, no podrá recuperar este archivo",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $('#exampleModal').modal('show');
                            q.Id = Identificacion;
                            // $.ajax({
                            //     type: "post",
                            //     url: '<?= base_url("/modificarRol") ?>',
                            //     data: {
                            //         "identificacion": Identificacion
                            //     },
                            //     success: function(response) {
                            //         var json = JSON.parse(response);
                            //         q.articulos = json
                            //     }
                            // });

                        }
                    });
            },
            ActualizarContraseña(item, Identificacion) {
                swal({
                        title: "¿Estás seguro?",
                        text: "Una vez actualizado, no podrá recuperar este archivo",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "post",
                                url: '<?= base_url("/ValidarModificarContraseña") ?>',
                                data: {
                                    "identificacion": Identificacion
                                },
                                success: function(data) {
                                    if ("error" === data) {
                                        swal("El usuario no ha completado su registro", {
                                            icon: "warning",
                                        });
                                    } else {
                                        $('#exampleModalCenter').modal('show');
                                        q.Id = Identificacion;
                                        q.Password = data;
                                    }
                                }
                            });
                        }
                    });
            },
            modificarRolUsuario: function(e) {
                $.ajax({
                    type: 'post',
                    url: '<?= base_url("/modificarRolNull") ?>',
                    data: $('#formularioModificarRolUsuario').serialize(),
                    success: function(data) {
                        $('#exampleModal').modal('hide');
                        var json = JSON.parse(data);
                        q.articulos = json
                    }
                });
            }, 
            modificarPassClient: function(e) {
                $.ajax({
                    type: 'post',
                    url: '<?= base_url("/PassClienteRef") ?>',
                    data: $('#formPassw').serialize(),
                    success: function(data) {
                        if(data === "true"){
                            swal("Modificado Correctamente", {
                                icon: "success",
                            });
                            $('#exampleModalCenter').modal('hide');
                        }else{
                            swal(data, {
                                icon: "warning",
                            });
                        }
                    }
                });


            }

        },
        created() {
           this.llenarDatosTablaCliente();
        },
    })
});

</script>