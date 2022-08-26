<script type="application/javascript">
function enviar() {
    $.ajax({
        async: false,
        type: 'post',
        url: '<?= base_url("/guardar") ?>',
        data: $('#form').serialize(),
        success: function(data) {
            if (data==="Bien") {
                location.replace('<?= base_url("/index") ?>');
            } else {
                swal(data, {
                    icon: "warning",
                });
            }
        }
    });
}
</script>