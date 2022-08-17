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
</script>