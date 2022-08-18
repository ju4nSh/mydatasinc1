<script>
    $(document).ready(data => {
        $('#modalActualizarProductos').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            // console.log(button[0].parentElement.parentElement.childNodes)
                let nombre = button[0].parentElement.parentElement.childNodes[0].innerText;
                let codigoMercadolibre = button[0].parentElement.parentElement.childNodes[2].innerText;
                let cantidad = button[0].parentElement.parentElement.childNodes[6].innerText;
                let precio = button[0].parentElement.parentElement.childNodes[8].innerText;
                let descripcion = button[0].parentElement.parentElement.childNodes[14].firstChild.value;
                let codigoBD = button[0].parentElement.parentElement.childNodes[16].firstChild.value;
                // let nombre = button[0].parentNode.parentNode.childNodes[0].innerText;
                // let precio = button[0].parentNode.parentNode.childNodes[3].innerText.split(":")[1].trim().split(".").join("");
                // let cantidad = button[0].parentNode.parentNode.childNodes[5].innerText.split(":")[1].trim();
                // let codigo = button[0].parentNode.parentNode.childNodes[15].value;
                // let descripcion = button[0].parentNode.parentNode.childNodes[17].value;
                // let codigoProductoActualizar = button[0].parentNode.parentNode.childNodes[19].value;
                // // Button that triggered the modal
                // // var recipient = button.data('whatever') // Extract info from data-* attributes
                // // // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // // // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#nombreAC').val(nombre)
                modal.find('#precioAC').val(precio)
                modal.find('#cantidadAC').val(cantidad)
                modal.find('#descripcionAC').val(descripcion)
                modal.find("#codigoPaActualizar").val(codigoMercadolibre)
                modal.find("#codigoProductoAC").val(codigoBD)
            })
    })
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
                            <input :id="id" v-if="typedata === 'string'" class="form-control" type="text" name="">
                            <input :id="id" v-if="typedata === 'number'" class="form-control" type="number" name="">

                            <select :id="id" v-if="typedata === 'boolean'" class="form-control">
                                <option v-for="b in data" :value="b.name">{{b.name}}</option>
                            </select>

                            <select :id="id" v-if="typedata === 'list'" class="form-control" type="text" name="">
                                <option v-for="b in data" :value="b.name">{{b.name}}</option>
                            </select>

                    </div>
                `,

        props: ["typedata", "name", "data", "id", "allowed_units"]

    });
    var app = new Vue({
        el: '#app',
        components: {
            subCategory: subCategory,
            campos: campos
        },
        data: {
            categoriasEncontradas: [],
            detallesEncontrados: [],
            childrenCategories: [],
            camposRequeridos: [],
        },
        mounted: function() {
            // $("#nombrePN").keyup(c => {
            // 	// alert($("#nombrePN").val())
            // 	// console.log(encodeURIComponent($("#nombrePN").val()))
            // 	$.ajax({
            // 		type: "get",
            // 		url: "http://localhost/mercado/public/buscarcategoria/" + encodeURIComponent($("#nombrePN").val()),
            // 		dataType: "json",
            // 		success: function(response) {
            // 			// console.log(response)
            // 			app.isCategory = true
            // 			app.categoriasEncontradas = response;

            // 		}
            // 	});
            // })
        },
        created: function() {
        },

        filters: {},
        methods: {
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

                            // console.log(response.settings)
                        }
                        // app.detallesEncontrados = response.children_categories
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
                            if (value.tags.required) {
                                console.log(value.name, value.tags, value.value_type)
                                app.camposRequeridos.push({
                                    "id": value.id,
                                    "name": value.name,
                                    "value_type": value.value_type,
                                    "data": value.values,
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
            publicarAC: function () {
                $.ajax({
                    async: false,
                    type: "post",
                    url: "<?= base_url("actualizarproducto") ?>",
                    data: "id=" + $("#codigoPaActualizar").val() + "&codigo=" + $("#codigoProductoAC").val() + "&nombre=" + $("#nombreAC").val() + "&precio=" + $("#precioAC").val() + "&descripcion=" + $("#descripcionAC").val() + "&cantidad=" + $("#cantidadAC").val(),
                    dataType: "json",
                    success: function (response) {
                        // console.log(response)
                        if (response.result) {
                            swal("Bien", "producto actualizado!", "success");
                            $("#cerrarAC").click();
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
                $.ajax({
                    async: false,
                    type: "post",
                    url: "<?= base_url("publicarMercadolibre") ?>",
                    data: "nombre=" + $("#nombrePN").val() + "&categoria=" + $("#categoriaPN").val() + "&precio=" + $("#precioPN").val() + "&cantidad=" + $("#cantidadPN").val() + "&imagen=" + $("#imagenPN").val() + "&attributes=" + JSON.stringify(attributes),
                    dataType: "json",
                    success: function(response) {
                        console.log(response)
                        if (response.result) {
                            swal("Bien", "producto publicado!", "success");
                            $("#cerrarPN").click();
                        } else {
                            swal("Error", "No se pudo Publicar", "info");
                            console.log(response.data)
                        }
                    }
                });
            },
            // agregarCategory: function () {
            //     $.ajax({
            //         type: "get",
            //         url: "http://localhost/mercado/public/buscarcategoria/" + encodeURIComponent($("#nombrePN").val()),
            //         dataType: "json",
            //         success: function (response) {
            //             console.log(response[0].category_id)
            //             app.isCategory = false
            //             $("#categoriaPN").val(response[0].category_id)


            //         }
            //     });
            //     // console.log($("#categoriasRetornadas").val())
            //     // $("#categoriaPN").val($("#categoriasRetornadas").val())
            // },
            // publicar: function () {
            //     $.ajax({
            //         async: false,
            //         type: "post",
            //         data: "nombre=" + $("#nombre").val() + "&categoria=" + $("#categoria").val() + "&precio=" + $("#precio").val() + "&cantidad=" + $("#cantidad").val() + "&descripcion=" + $("#descripcion").val(),
            //         url: "http://localhost/mercado/public/publicar",
            //         dataType: "json",
            //         success: function (response) {
            //             // app.productos = response

            //             console.log(response)
            //             app.addLinkProduct(response.id, response.category_id, response.permalink);
            //             app.link = response.permalink;
            //             app.linkBool = true;
            //         },
            //         error: function () {
            //             // alert("1")
            //         }
            //     });
            // },
            // // NO UTILIZO
            // addLinkProduct: function (code, category, link) {
            //     $.ajax({
            //         type: "post",
            //         url: "http://localhost/mercado/public/addLink",
            //         data: "codigoproducto=" + $("#codigoPaPublicar").val() + "&codigo=" + code + "&categoria=" + category + "&link=" + link,
            //         dataType: "json",
            //         success: function (response) {
            //             if (response.result) {
            //                 swal("Bien", "producto publicado!", "success");
            //                 $("#cerrar").click();
            //             } else {
            //                 swal("Error", "link no encontrado!", "info");
            //             }
            //         }
            //     });
            // },

            // infoProduct: function (param) {
            //     app.contrasena = false;
            //     app.productosView = true;
            //     $.ajax({
            //         async: false,
            //         url: "http://localhost/mercado/public/showproduct",
            //         dataType: "json",
            //         success: function (response) {
            //             app.productos = response
            //             console.log(response)
            //         },
            //         error: function () {
            //             // alert("1")
            //         }
            //     });
            // },
            // actualizar_datos: function () {

            //     $.ajax({
            //         type: "post",
            //         url: "http://localhost/mercado/public/update",
            //         data: "nombre=" + $("#nombre").val() + "&usuario=" + $("#usuario").val() + "&email=" + $("#email").val() + "&contrasena=" + $("#contrasena").val(),
            //         dataType: "json",
            //         success: function (response) {
            //             if (response.result) {
            //                 console.log(response)
            //                 swal("Bien", "Datos actualizados", "success");
            //             } else {
            //                 console.log(response)

            //                 swal("Error", "No se pudo actualizar", "info");
            //             }
            //         }
            //     });
            // },
            // infoUser: function () {
            //     app.productosView = false;

            //     $.ajax({
            //         // type: "post",
            //         // method: 'post',
            //         url: "http://localhost/mercado/public/infoUser",
            //         dataType: "json",
            //         success: function (response) {
            //             if (response.result) {
            //                 console.log(response.data)
            //                 app.infouser = response.data
            //                 app.nombre = response.data.nombre
            //                 app.contrasena = true;
            //             } else {
            //                 console.log(response.error)
            //                 swal("Error", "No se pudo registrar", "info");
            //             }
            //         }
            //     });
            // }
        },
        watch: {}
    });
</script>