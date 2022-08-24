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
            }
        },
        created() {
            $.ajax({
                type: "GET",
                url: '<?= base_url("/mostrarClientesReferenciados") ?>',
                success: function(response) {
                    var json = JSON.parse(response);
                    q.articulos = json
                }
            });
        },
        methods: {
            deleteItem(item,Identificacion) {
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
            send: function(e) {
                $.ajax({
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

        }
    })
});

function prueba(x,y,z){
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
<style>
#borde {
    border-bottom: 2px solid #d9d9d9;
}
</style>