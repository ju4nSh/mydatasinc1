<script type="application/javascript">
    let login = new Vue({
        el: "#login_vue",
        data() {
            return {
                errors: []
            }
        },
        methods: {
            async enviar(e) {
                await $.ajax({
                    async: false,
                    type: 'post',
                    url: '<?= base_url("guardar") ?>',
                    data: $('#form').serialize(),
                    dataType: "json",
                    success: async function(data) {
                        login.errors =[]
                        if (data.errors) {
                            login.errors = data.errors
                        }else{
                            if (data.result == 1) {
                                location.replace('<?= base_url("index") ?>');
                            }else if (data.result == 2) {
                                await swal("Error", "Usuario o contraseña erroneos", "error")
                            } else {
                                swal("Error", "Ocurrio un error", "error", {
                                    icon: "warning",
                                });
                            }
                        }                       
                        
                    }
                });
            }
        },
    })
</script>