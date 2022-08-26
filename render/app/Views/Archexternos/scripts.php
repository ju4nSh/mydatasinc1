<script type="application/javascript">
$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: '<?= base_url("/llenarPerfil") ?>',
        success: function(response) {
            q.datos = eval(response)
        }
    });
});

function Actualizar() {
    swal({
            title: "¿Desea Actualizar la informacion?",
            text: "Una vez actualizada, no podrá recuperar dicha informacion",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "post",
                    url: '<?= base_url("/ModificarPerfil") ?>',
                    data: $('#formulario').serialize(),
                    success: function(response) {
                        var json = JSON.parse(response);
                        if (json.error) {
                            swal("Verfique llenar todos los campos", {
                                icon: "warning",
                            });
                        } else {
                            swal("Actualizado Correctamente", {
                            icon: "success",
                        });
                        q.datos = eval(response)
                        }
                       
                    }
                });
            }
        });
}
var q = new Vue({
    el: '#app',
    data: {
        datos: [],
    }
})
</script>