<script>
    $(document).ready(data => {
        $('#modalActualizarProductos').on('show.bs.modal', function(event) {
            // var button = $(event.relatedTarget)
            // let nombre = button[0].parentElement.parentElement.childNodes[0].innerText;
            // let codigoMercadolibre = button[0].parentElement.parentElement.childNodes[2].innerText;
            // let cantidad = button[0].parentElement.parentElement.childNodes[6].innerText;
            // let precio = button[0].parentElement.parentElement.childNodes[8].innerText;
            // let descripcion = button[0].parentElement.parentElement.childNodes[14].firstChild.value;
            // let codigoBD = button[0].parentElement.parentElement.childNodes[16].firstChild.value;
            // var modal = $(this)
            // modal.find('#nombreAC').val(nombre)
            // modal.find('#precioAC').val(precio)
            // modal.find('#cantidadAC').val(cantidad)
            // modal.find('#descripcionAC').val(descripcion)
            // modal.find("#codigoPaActualizar").val(codigoMercadolibre)
            // modal.find("#codigoProductoAC").val(codigoBD)
        })
    })
    // var subCategory = Vue.component("sub-category", {
    //     template: `
    //                 <div class="form-control">
    //                     <div v-on:click="$emit(\'add\')" :id="id">
    //                         {{name}}
    //                     </div>
    //                 </div>
    //                 `,

    //     props: ["id", "name"]

    // });
    // var campos = Vue.component("campos", {
    //     template: `
    //                 <div class="form-group col-md-6">
    //                     <label class="col-form-label" for="my-input">{{name}}:</label>

    //                         <div v-if="typedata === 'number_unit'"> 
    //                             <input :id="id" class="form-control" type="number" name="">
    //                             <select  class="form-control">
    //                                 <option v-for="b in allowed_units" :value="b.name">{{b.name}}</option>
    //                             </select>
    //                         </div>
    //                         <input :id="id" v-if="typedata === 'string'" class="form-control" type="text" name="">
    //                         <input :id="id" v-if="typedata === 'number'" class="form-control" type="number" name="">

    //                         <select :id="id" v-if="typedata === 'boolean'" class="form-control">
    //                             <option v-for="b in data" :value="b.name">{{b.name}}</option>
    //                         </select>

    //                         <select :id="id" v-if="typedata === 'list'" class="form-control" type="text" name="">
    //                             <option v-for="b in data" :value="b.name">{{b.name}}</option>
    //                         </select>

    //                 </div>
    //             `,

    //     props: ["typedata", "name", "data", "id", "allowed_units"]

    // });
    var app = new Vue({
        el: '#app',
        components: {

        },
        data: {
            usuariosBD: [],
            usuarioActivo: true,
        },
        mounted: function() {

        },
        created: function() {
            $.ajax({
                url: "<?= base_url("/listarClientes") ?>",
                dataType: "json",
                success: function(response) {
                    if (response.result)
                        app.usuariosBD = response.data
                    else
                        swal("error", "no se encontraron usuarios", "error");
                }
            });
        },

        filters: {},
        methods: {

        },
        watch: {}
    });
</script>