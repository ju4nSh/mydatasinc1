<script>
    $(document).ready(data => {



        var subCategory = Vue.component("sub-category", {
            template: `
                    <div class="form-control">
                        <div v-on:click="$emit(\'add\')" :id="id">
                            {{name}}
                        </div>
                    </div>
                    `,

            props: ["id", "name"]

        });
        var campos = Vue.component("campos", {
            template: `
                    <div class="form-group col-md-6">
                        <label class="col-form-label" for="my-input">{{name}}:</label>

                            <div v-if="typedata === 'number_unit'"> 
                                <input :id="id" class="form-control" type="number" name="">
                                <select  class="form-control">
                                    <option v-for="b in allowed_units" :value="b.name">{{b.name}}</option>
                                </select>
                            </div>
                            <input :placeholder="hint" :id="id" v-if="typedata === 'string'" class="form-control" type="text" name="">
                            <input :id="id" v-if="typedata === 'number'" class="form-control" type="number" name="">

                            <select :id="id" v-if="typedata === 'boolean'" class="form-control">
                                <option v-for="b in data" :value="b.name">{{b.name}}</option>
                            </select>

                            <select :id="id" v-if="typedata === 'list'" class="form-control" type="text" name="">
                                <option v-for="b in data" :value="b.name">{{b.name}}</option>
                            </select>

                    </div>
                `,

            props: ["typedata", "name", "data", "id", "allowed_units", "hint"]

        });
        var app = new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            components: {
                subCategory: subCategory,
                campos: campos
            },
            data: {
                categoriasEncontradas: [],
                detallesEncontrados: [],
                childrenCategories: [],
                camposRequeridos: [],
                inputImagen: [],
                camposVacios: false,
                // search: '',
                // columnas: [{
                //         text: 'IMAGEN',
                //         value: 'imagen',
                //         // src: 'imagen[0]',
                //         sortable: false,
                //         class: 'blue accent-2'
                //     },
                //     {
                //         text: 'NOMBRE',
                //         value: 'nombre',
                //         class: 'blue accent-2'
                //     },
                //     {
                //         text: 'CODIGO',
                //         value: 'codigo',
                //         class: 'blue accent-2'
                //     },

                //     {
                //         text: 'CATEGORIA',
                //         value: 'categoria',
                //         class: 'blue accent-2'
                //     },

                //     {
                //         text: 'STOCK',
                //         value: 'cantidad',
                //         class: 'blue accent-2'
                //     },
                //     {
                //         text: 'PRECIO',
                //         value: 'precio',
                //         class: 'blue accent-2'
                //     },

                //     {
                //         text: 'LINK',
                //         value: 'link',
                //         sortable: false,
                //         class: "blue accent-2"
                //     },
                //     {
                //         text: 'Actions',
                //         value: 'actions',
                //         sortable: false,
                //         class: 'blue accent-2'
                //     }

                // ],
                productos: [],
            },
            mounted: function() {

            },
            created: function() {
                var url = "<?= base_url("/obtenerproductos") ?>";
                // this.articulos = JSON.parse(response);
                $.ajax({
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        app.productos = response.data
                    }
                });
            },

            filters: {},
            methods: {
                buscar: function(url) {
                    window.open(url, "_blank")
                },
                crearInputImagen: function() {
                    app.inputImagen.push({
                        clase: "input",
                    })
                },
                subcategory: function(id, index) {
                    $.ajax({
                        url: "<?= base_url("obtenerdetallescategoria") ?>/" + id,
                        dataType: "json",
                        success: function(response) {
                            if (response.children_categories.length) {
                                app.delete = app.childrenCategories.splice((index + 1))
                                app.childrenCategories.push(response.children_categories)
                            } else {


                                var altura = $(".modal-xl").height();

                                $("html, body").animate({
                                    scrollTop: altura + "px"
                                });
                                app.childrenCategories.splice((index + 1))
                                app.camposRequeridos.splice(0)
                                app.atributesCategory(id);
                            }
                        }
                    });
                },
                atributesCategory: function(param) {
                    $("#categoriaPN").val(param)
                    // tipos de datos
                    // string
                    // number_unit
                    // list
                    // boolen
                    // 
                    $.ajax({
                        url: "<?= base_url("attributesCategory") ?>/" + param,
                        dataType: "json",
                        success: function(response) {
                            console.log(response)
                            $.each(response, function(index, value) {
                                if (value.tags.required || value.tags.conditional_required) {
                                    console.log(value.name, value.tags, value.value_type)
                                    app.camposRequeridos.push({
                                        "id": value.id,
                                        "name": value.name,
                                        "value_type": value.value_type,
                                        "data": value.values,
                                        "hint": value.hint,
                                        "allowed_units": value.allowed_units,
                                    })
                                }
                            });
                        }
                    });
                },
                categoriasProductos: function(param) {
                    $.ajax({
                        url: "<?= base_url("/obtenercategoria") ?>",
                        dataType: "json",
                        success: function(response) {
                            // console.log(response)
                            app.categoriasEncontradas = response;

                        }
                    });
                },
                detallesCategoria: function(param, i) {
                    $.ajax({
                        url: "<?= base_url("obtenerdetallescategoria") ?>/" + param,
                        dataType: "json",
                        success: function(response) {
                            app.childrenCategories.splice(0)
                            app.detallesEncontrados = response.children_categories
                        }
                    });
                },
                publicarAC: function() {
                    $.ajax({
                        async: false,
                        type: "post",
                        url: "<?= base_url("actualizarproducto") ?>",
                        data: "id=" + $("#codigoPaActualizar").val() + "&codigo=" + $("#codigoProductoAC").val() + "&nombre=" + $("#nombreAC").val() + "&precio=" + $("#precioAC").val() + "&descripcion=" + $("#descripcionAC").val() + "&cantidad=" + $("#cantidadAC").val(),
                        dataType: "json",
                        success: function(response) {
                            // console.log(response)
                            if (response.result == 1) {
                                swal("Bien", "producto actualizado!", "success");
                                app.camposVacios = false;
                                $("#cerrarAC").click();
                            }else if (response.result == 30) {
                                app.camposVacios = true;
                                console.log(response.data)
                            } else {
                                swal("Error", "No se pudo Actualizar", "info");
                                console.log(response)
                            }
                        }
                    });
                },
                publicarPN: function(param) {
                    let attributes = [];
                    $.each(app.camposRequeridos, function(index, value) {
                        attributes.push({
                            "id": value.id,
                            "value_name": $(`#${value.id}`).val()
                        })
                        //  console.log($(`#${value.id}`).val());
                    });
                    // console.log(attributes)
                    let imagenes = [];
                    $.each($(".input"), function(indexInArray, valueOfElement) {
                        if (valueOfElement.value !== "")
                            imagenes.push(valueOfElement.value)
                    });
                    $.ajax({
                        async: false,
                        type: "post",
                        url: "<?= base_url("publicarMercadolibre") ?>",
                        data: "nombre=" + $("#nombrePN").val() + "&categoria=" + $("#categoriaPN").val() + "&precio=" + $("#precioPN").val() + "&cantidad=" + $("#cantidadPN").val() + "&imagen=" + JSON.stringify(imagenes) + "&attributes=" + JSON.stringify(attributes),
                        dataType: "json",
                        success: function(response) {
                            console.log(response)
                            if (response.result == 1) {
                                swal("Bien", "producto publicado!", "success");
                                $("#cerrarPN").click();
                            }  else {
                                swal("Error", "No se pudo Publicar", "info");
                                console.log(response.data)
                            }
                        }
                    });
                },
            },
            watch: {}
        });
        $('.carousel').carousel()
        $('#modalActualizarProductos').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            let nombre = button[0].parentElement.parentElement.childNodes[1].innerText;
            let codigoMercadolibre = button[0].parentElement.parentElement.childNodes[2].innerText;
            let cantidad = button[0].parentElement.parentElement.childNodes[4].innerText;
            let precio = button[0].parentElement.parentElement.childNodes[5].innerText;
            let descripcion = '';
            let codigoBD = '';

            $.ajax({
                async: false,
                type: 'post',
                url: "<?= base_url("/obtenercategoriaId") ?>",
                dataType: "json",
                data: "codigo=" + codigoMercadolibre,
                success: function(response) {
                    console.log(response)
                    descripcion = response.data.descripcion
                    codigoBD = response.data.id
                }
            });
            var modal = $(this)
            modal.find('#nombreAC').val(nombre)
            modal.find('#precioAC').val(precio)
            modal.find('#cantidadAC').val(cantidad)
            modal.find("#codigoPaActualizar").val(codigoMercadolibre)
            modal.find('#descripcionAC').val(descripcion)
            modal.find("#codigoProductoAC").val(codigoBD)
        })
    })
</script>