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
                            text: 'Rol',
                            value: 'Rol',
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
                    roles: [],
                    Id: '',
                    Password: '',
                    valId: '',
                    CondicionvalId: '',
                    valNombre: '',
                    CondicionvalNombre: '',
                    valApellido: '',
                    CondicionvalApellido: '',
                    valCorreo: '',
                    CondicionvalCorreo: '',
                    valCiudad: '',
                    CondicionvalCiudad: '',
                    valPais: '',
                    CondicionvalPais: '',
                    valUsuario: '',
                    CondicionvalUsuario: '',
                }
            },
            methods: {
                llenarDatosTablaCliente() {
                    $.ajax({
                        type: "GET",
                        url: '<?= base_url("/mostrarClientesReferenciados") ?>',
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
                Hola() {
                    q.CondicionvalApellido = false;
                    q.CondicionvalCiudad = false;
                    q.CondicionvalCorreo = false;
                    q.CondicionvalId = false;
                    q.CondicionvalNombre = false;
                    q.CondicionvalPais = false;
                    q.CondicionvalUsuario = false;
                },
                send: function(e) {
                    $.ajax({
                        type: 'post',
                        url: '<?= base_url("/agregarClienteRef") ?>',
                        data: $('#form').serialize(),
                        success: function(data) {
                            var json = JSON.parse(data);
                            if (json.error) {
                                swal(json.error, {
                                    icon: "warning",
                                });
                            } else if (json.Validar) {
                                if (json.Id != '') {
                                    q.valId = json.Id;
                                    q.CondicionvalId = true
                                } else {
                                    q.valId = '';
                                    q.CondicionvalId = false
                                }
                                if (json.Nombre != '') {
                                    q.valNombre = json.Nombre;
                                    q.CondicionvalNombre = true
                                } else {
                                    q.valNombre = '';
                                    q.CondicionvalNombre = false
                                }
                                if (json.Apellido != '') {
                                    q.valApellido = json.Apellido;
                                    q.CondicionvalApellido = true
                                } else {
                                    q.valApellido = '';
                                    q.CondicionvalApellido
                                }
                                if (json.Correo != '') {
                                    q.valCorreo = json.Correo;
                                    q.CondicionvalCorreo = true
                                } else {
                                    q.valCorreo = '';
                                    q.CondicionvalCorreo = false
                                }
                                if (json.Direccion != '') {
                                    q.valDireccion = json.Direccion;
                                    q.CondicionvalDireccion = true
                                } else {
                                    q.valDireccion = '';
                                    q.CondicionvalDireccion = false
                                }
                                if (json.Ciudad != '') {
                                    q.valCiudad = json.Ciudad;
                                    q.CondicionvalCiudad = true
                                } else {
                                    q.valCiudade = '';
                                    q.CondicionvalCiudad = false
                                }
                                if (json.Pais != '') {
                                    q.valPais = json.Pais;
                                    q.CondicionvalPais = true
                                } else {
                                    q.valPais = '';
                                    q.CondicionvalPais = false
                                }
                                if (json.Usuario != '') {
                                    q.valUsuario = json.Usuario;
                                    q.CondicionvalUsuario = true
                                } else {
                                    q.valUsuario = '';
                                    q.CondicionvalUsuario = false
                                }
                            } else {
                                console.log()
                                q.articulos.push(json);
                                swal("Agregado Correctamente", {
                                    icon: "success",
                                });
                                q.Hola();
                                limpiar();
                                q.loading = false
                            }
                        }
                    });


                },
                modificarRolUsuario: function(e) {
                    $.ajax({
                        type: 'post',
                        url: '<?= base_url("/modificarRol") ?>',
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
                            if (data === "true") {
                                swal("Modificado Correctamente", {
                                    icon: "success",
                                });
                                $('#exampleModalCenter').modal('hide');
                            } else {
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

    function prueba(x, y, z) {
        $('#exampleModal').modal('show');
        $('#efirstname').val(x);
        $('#elastname').val(y);
        $('#eaddress').val(z);
    }

    function limpiar() {
        document.getElementsByTagName("input")[0].value = "";
        document.getElementById("Id").value = "";
        document.getElementById("Nombre").value = "";
        document.getElementById("Apellido").value = "";
        document.getElementById("Correo").value = "";
        document.getElementById("Ciudad").value = "";
        document.getElementById("Pais").value = "";
        document.getElementById("Usuario").value = "";
        document.getElementById("Pass").value = "";


    }

    function validar(Id, Nombre, Apellido, Correo, Ciudad, Pais, Usuario) {
        if (Id.length == 0 || Nombre.length == 0 || Apellido.length == 0 || Correo.length == 0 || Ciudad.length == 0 || Pais
            .length == 0) {
            swal("Verfique llenar todos los campos", {
                icon: "warning",
            });
            return false;
        } else {
            return true;
        }
    }
</script>
<script type="text/javascript">
    function enviar() {
        $.ajax({
            async: false,
            type: 'post',
            url: '<?= base_url("/agregarClienteRef") ?>',
            data: $('#form').serialize(),
            success: function(data) {
                var json = JSON.parse(data);
                if (json.error) {
                    swal("Verfique llenar todos los campos", {
                        icon: "warning",
                    });
                } else {
                    console.log()
                    q.articulos.push(json);
                    swal("Agregado Correctamente", {
                        icon: "success",
                    });
                    limpiar();
                }

            }
        });
    }
</script>