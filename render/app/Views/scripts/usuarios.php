<script>
    $(document).ready(data => {
        // $.ajax({
        //     async: false,
        //     url: "<?= base_url("/listarClientes")?>",
        //     dataType: "json",
        //     success: function (response) {
        //         alert(1)
        //         app.usuariosBD = response;
        //     }
        // });
        $('#usuarios').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "_MENU_ entradas por página",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": ">",
                    "previous": "<"
                }
            },
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


        },

        filters: {},
        methods: {

        },
        watch: {}
    });
</script>