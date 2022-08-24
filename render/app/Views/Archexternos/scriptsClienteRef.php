<script type="application/javascript">
$(document).ready(function() {
   var q =new Vue({
        el: '#app1',
        vuetify: new Vuetify(),
        data() {
            return {
                search: '',
                columnas: [{
                        text: 'Nombre',
                        value: 'Nombre',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Correo',
                        value: 'Correo',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Ciudad',
                        value: 'Ciudad',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Pais',
                        value: 'Pais',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Actions',
                        value: 'actions',
                        sortable: false,
                        class: 'blue accent-2'
                    }
                ],
                articulos: [],
            }
        },
        created() {
            $.ajax({
        type: "GET",
        url: '<?= base_url("/mostrarClientesReferenciados") ?>',
        success: function(response) {
            var json = JSON.parse(response);
            q.articulos = json
        }
    });
        },
        methods: {
            deleteItem(item) {
                swal({
                    title: "¿Estás seguro?",
                    text: "Una vez eliminado, no podrá recuperar este archivo",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.articulos.splice(this.articulos.indexOf(item), 1);
                    }
                });
                
            },
        }
    })
});



function limpiar() {
    document.getElementsByTagName("input")[0].value = "";
    document.getElementById("Id").value = "";
    document.getElementById("Nombre").value = "";
    document.getElementById("Apellido").value = "";
    document.getElementById("Correo").value = "";
    document.getElementById("Ciudad").value = "";
    document.getElementById("Pais").value = "";
}

function validar(Id,Nombre,Apellido,Correo,Ciudad,Pais,Usuario) {
  if (Id.length == 0 || Nombre.length == 0 || Apellido.length == 0 || Correo.length == 0 || Ciudad.length == 0 || Pais.length == 0) {
    swal("Verfique llenar todos los campos", {
                            icon: "warning",
        });
    return false;
  }else{
    return true;
  }
}


</script>
<script type="text/javascript">
$('#formulario').submit(function (ev) {
  $.ajax({
    type: 'post', 
    url: '<?= base_url("/agregarClienteRef") ?>',
    data: $('#formulario').serialize(),
    success: function (data) { 
        var json = JSON.parse(data);
        if(json.error){
            swal("Verfique llenar todos los campos", {
                            icon: "warning",
        });
        }else{
            q.clienteRef.push(eval(json));
            swal("Agregado Correctamente", {
                            icon: "success",
                        });
                        limpiar();
        }
      
    } 
  });
  ev.preventDefault();
});
</script>