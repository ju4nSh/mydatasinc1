
<script type="application/javascript">
async function enviar(e) {
    await $.ajax({
        async: false,
        type: 'post',
        url: '<?= base_url("/guardar") ?>',
        data: $('#form').serialize(),
        dataType: "json",
        success:async function(data) {
            if (data.result == 1) {
                alert(2)
                location.replace('<?= base_url("index") ?>');
            } else if(data.result == 3) {
                await swal("Error", "rellene los campos", "error")
            } else if (data.result == 2) {
                await swal("Error", "Usuario o contraseña erroneos", "error")
            }
             else {
                swal("Error", "Ocurrio un error", "error", {
                    icon: "warning",
                });
            }
        }
    });
}
</script>