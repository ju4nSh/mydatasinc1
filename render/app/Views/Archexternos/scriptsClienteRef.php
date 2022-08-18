<script type="application/javascript">
$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: '<?= base_url("/mostrarClientesReferenciados") ?>',
        success: function(response) {
            q.clienteRef = eval(response)
        }
    });
});

function AgregarCliente() {
    var Id = document.getElementById("Id").value;
    var Nombre = document.getElementById("Nombre").value;
    var Apellido = document.getElementById("Apellido").value;
    var Correo = document.getElementById("Correo").value;
    var Ciudad = document.getElementById("Ciudad").value;
    var Pais = document.getElementById("Pais").value;
    var Usuario = document.getElementById("Usuario").value;
    $.ajax({
        type: "post",
        url: '<?= base_url("/agregarClienteRef") ?>',
        data: {
            "Id": Id,
            "Nombre": Nombre,
            "Apellido": Apellido,
            "Correo": Correo,
            "Ciudad": Ciudad,
            "Pais": Pais,
            "Usuario": Usuario
        },
        error: function() {
            alert('No pudo ser agregado este cliente, verifique la informacion');
        },
        success: function(response) {
            swal("Agregado Correctamente", {
                            icon: "success",
                        });
            limpiar();
            var js = eval(response);
            q.clienteRef.push({
                "Identificacion": Id,
                "Apellido": Apellido,
                "Ciudad": Ciudad,
                "Correo": Correo,
                "Nombre": Nombre,
                "Pais": Pais
            });
        }
    });
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
}

var q = new Vue({
    el: '#app',
    data: {
        clienteRef: [],
    },
    methods: {
        elimiarClienteRef(identificacion, posicion) {
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
                    "identificacion": identificacion
                },
                success: function(response) {
                    swal("Eliminado Correctamente", {
                            icon: "success",
                        });
                    q.clienteRef.splice(posicion, 1);
                }
            });
                    }
                });
        }
    }
})
</script>