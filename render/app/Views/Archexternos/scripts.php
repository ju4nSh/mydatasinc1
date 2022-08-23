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

  function Actualizar(){
    swal({
                    title: "¿Desea Actualizar la informacion?",
                    text: "Una vez actualizada, no podrá recuperar dicha informacion",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                      var formulario = document.getElementById("formulario");
                      formulario.submit();
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