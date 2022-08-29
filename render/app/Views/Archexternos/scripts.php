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
                        swal("Actualizado Correctamente", {
                            icon: "success",
                        });
                        q.datos = eval(response)
                    }
                });
            }
        });
} 
function ConectarMerLi(){
    $.ajax({
                type: "GET",
                url: '<?= base_url("/validarConexionMerLi") ?>',
                success: function(response) {
                    if(response==="Bien"){
                        $('#exampleModalLong').modal('show');
                    }else{
                        swal("Esta funcion no se encuentra habilitada para usted", {
                                        icon: "warning",
                                    });
                    }
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