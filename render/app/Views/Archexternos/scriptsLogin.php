<script type="application/javascript">
function enviar() {
    $.ajax({
        type: 'post',
        url: '<?= base_url("/guardar") ?>',
        data: $('#form').serialize(),
        success: function(data) {
            if (data==="Bien") {
                window.location.replace('<?= base_url("/index") ?>');
            } else {
                swal(data, {
                    icon: "warning",
                });
            }
        }
    });
}
</script>