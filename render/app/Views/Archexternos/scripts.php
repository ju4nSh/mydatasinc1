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
                            var p = eval(response);
                            if(p[0]["Validar"]){
                                if (p[0]["Apellido"] != '') {q.valApellido = p[0]["Apellido"];q.CondicionvalApellido = true} 
                                else {q.valApellido = '';q.CondicionvalApellido = false}

                                if (p[0]["Ciudad"] != '') {q.valCiudad  = p[0]["Ciudad"];q.CondicionvalCiudad = true} 
                                else {q.valCiudad  = '';q.CondicionvalCiudad = false}

                                if (p[0]["Correo"] != '') {q.valCorreo = p[0]["Correo"];q.CondicionvalCorreo = true} 
                                else {q.valCorreo = '';q.CondicionvalCorreo = false}

                                if (p[0]["SobreMi"] != '') {q.valSobreMi = p[0]["SobreMi"];q.CondicionvalSobreMi = true} 
                                else {q.valSobreMi = '';q.CondicionvalSobreMi = false}

                                if (p[0]["Nombre"] != '') {q.valNombre = p[0]["Nombre"];q.CondicionvalNombre = true} 
                                else {q.valNombre = '';q.CondicionvalNombre = false}

                                if (p[0]["Pais"] != '') {q.valPais = p[0]["Pais"];q.CondicionvalPais = true} 
                                else {q.valPais = '';q.CondicionvalPais = false}

                                if (p[0]["Direccion"] != '') {q.valDireccion = p[0]["Direccion"];q.CondicionvalDireccion = true} 
                                else {q.valDireccion = '';q.CondicionvalDireccion = false}

                                if (p[0]["Foto"] != '') {q.valFoto = p[0]["Foto"];q.CondicionvalFoto = true} 
                                else {q.valFoto = '';q.CondicionvalFoto = false}

                            }else{
                                swal("Modificado Correctamente", {
                                icon: "success",
                            });
                            q.datos=p;
                            Borrar();
                            }
                        }
                    });
                }
            });
    }

    function Borrar(){
      
                    q.CondicionvalApellido = false;
                    q.CondicionvalCiudad = false;
                    q.CondicionvalCorreo = false;
                    q.CondicionvalSobreMi = false;
                    q.CondicionvalNombre = false;
                    q.CondicionvalPais = false;
                    q.CondicionvalDireccion = false;
                    q.CondicionvalFoto = false;

    }

    function ConectarMerLi(varriable) {
        if (varriable == 0) {
            $('#exampleModalLong').modal('show');
        } else {
            swal("Esta funcion no se encuentra habilitada para usted", {
                icon: "warning",
            });
        }
    }

    var q = new Vue({
        el: '#app',
        data: {
            datos: [],
            valDireccion: '',
            CondicionvalDireccion: '',
            valNombre: '',
            CondicionvalNombre: '',
            valApellido: '',
            CondicionvalApellido: '',
            valCorreo: '',
            CondicionvalCorreo: '',
            valCiudad: '',
            CondicionvalCiudad: '',
            valPais: '',
            CondicionvalPais: '',
            valSobreMi: '',
            CondicionvalSobreMi: '',
            valFoto: '',
            CondicionvalFoto: '',
        },
        methods: {
            send: function(e) {
                $.ajax({
                    type: "post",
                    url: '<?= base_url("/ModificarPasswordPerfil") ?>',
                    data: $('#formularioPass').serialize(),
                    success: function(response) {
                        var json = JSON.parse(response);
                        if (json.error) {
                            swal("Verfique la informacion enviada", {
                                icon: "warning",
                            });
                        } else {
                            swal("Modificado Correctamente", {
                                icon: "success",
                            });
                            document.getElementById("PassActual").value = "";
                            document.getElementById("PassNueva").value = "";
                            document.getElementById("PassNuevaConfir").value = "";
                            $('#exampleModal').modal('hide');

                        }

                    }
                });
            }
        }
    })
</script>