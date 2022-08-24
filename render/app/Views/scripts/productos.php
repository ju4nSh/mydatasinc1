<script>
	var app;
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

							<div class="row m-1" v-if="typedata === 'number_unit'"> 
								<input :placeholder="hint" :id="id" class="form-control col-md-11" type="number" name="">
								<select  class="form-control col-md-1 p-0">
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
		app = new Vue({
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
				productos: [],
			},
			mounted: function() {

			},
			created: async function() {
				var url = "<?= base_url("getData") ?>/" + 2 + "/" + 1;
				// this.articulos = JSON.parse(response);
				let limite = '';
				await $.ajax({
					url: url,
					dataType: "json",
					success: function(response) {
						console.log(response)
						limite = response.limit
						app.productos = response.data
					}
				});
				// generar los primeros links
				let url2 = "<?= base_url("createLinks") ?>/" + 7 + "/" + limite;
				await $.ajax({
					url: url2,
					success: function(response) {
						console.log(response)
						$("#botonNavegacion").html(response)

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
					$("#spinnerAgregarProducto").addClass("spinner-border")
					$.ajax({
						url: "<?= base_url("obtenerdetallescategoria") ?>/" + id,
						dataType: "json",
						success: function(response) {
							if (response.children_categories.length) {
								app.delete = app.childrenCategories.splice((index + 1))
								app.childrenCategories.push(response.children_categories)
								$("#spinnerAgregarProducto").removeClass("spinner-border")
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
					$("#spinnerAgregarProducto").addClass("spinner-border")
					$("#categoriaPN").val(param)
					$("#categoriaPN").addClass("animate__rubberBand");
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
							$("#spinnerAgregarProducto").removeClass("spinner-border")
							$("#categoriaPN").removeClass("animate__rubberBand");
						}
					});
				},
				categoriasProductos: function(param) {
					$("#spinnerAgregarProducto").addClass("spinner-border")

					$.ajax({
						url: "<?= base_url("/obtenercategoria") ?>",
						dataType: "json",
						success: function(response) {
							// console.log(response)
							app.categoriasEncontradas = response;
							$("#spinnerAgregarProducto").removeClass("spinner-border")

						}
					});
				},
				detallesCategoria: function(param, i) {
					$("#spinnerAgregarProducto").addClass("spinner-border")
					$.ajax({
						url: "<?= base_url("obtenerdetallescategoria") ?>/" + param,
						dataType: "json",
						success: function(response) {
							app.childrenCategories.splice(0)
							app.detallesEncontrados = response.children_categories
							$("#spinnerAgregarProducto").removeClass("spinner-border")
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
							} else if (response.result == 30) {
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
							"value_name": $(`#${value.id}`).next().length == 0 ? $(`#${value.id}`).val() : $(`#${value.id}`).val() + " " + ($(`#${value.id}`).next())[0].value
						})
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
							if (response.result == 1) {
								swal("Bien", "producto publicado!", "success");
								$("#cerrarPN").click();
							} else {
								let error = [];
								$.each(response.cause, function(indexInArray, valueOfElement) {
									console.log(valueOfElement.message)
									error.push(valueOfElement.message)
								});
								error.push(response.mensaje)
								swal("Error", JSON.stringify(error), "info");
								// console.log(response.data)
							}
						}
					});
				},
			},
			watch: {}
		});
		$('.carousel').carousel()
		$('#modalActualizarProductos').on('show.bs.modal', async function(event) {
			var button = $(event.relatedTarget)
			let nombre = ''
			let cantidad = ''
			let precio = ''
			let descripcion = '';
			let codigoBD = '';
			let codigoMercadolibre = button[0].parentElement.previousElementSibling.getAttribute("id");
			$("#spinnerActualizarProducto").addClass("spinner-border")
			await $.ajax({
				async: true,
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
			$("#spinnerActualizarProducto").removeClass("spinner-border")

			if (button[0].parentElement.previousElementSibling.childNodes[6]) {
				nombre = button[0].parentElement.previousElementSibling.childNodes[6].childNodes[0].innerText;
				cantidad = button[0].parentElement.previousElementSibling.childNodes[6].childNodes[2].firstChild.innerText.split(":")[1].trim();
				precio = button[0].parentElement.previousElementSibling.childNodes[6].childNodes[2].lastChild.innerText.split(".").join("").split("$")[1].trim();
			} else {
				nombre = button[0].parentElement.previousElementSibling.childNodes[4].childNodes[0].innerText;
				cantidad = button[0].parentElement.previousElementSibling.childNodes[4].childNodes[2].firstChild.innerText.split(":")[1].trim();
				precio = button[0].parentElement.previousElementSibling.childNodes[4].childNodes[2].lastChild.innerText.split(".").join("").split("$")[1].trim();
			}



			var modal = $(this)
			modal.find('#nombreAC').val(nombre)
			modal.find('#precioAC').val(precio)
			modal.find('#cantidadAC').val(cantidad)
			modal.find("#codigoPaActualizar").val(codigoMercadolibre)
			modal.find('#descripcionAC').val(descripcion)
			modal.find("#codigoProductoAC").val(codigoBD)
		})


	})

	async function buscarNuevo(limit, offset) {
		var url = "<?= base_url("getData") ?>/" + limit + "/" + offset;
		// this.articulos = JSON.parse(response);
		let limite = '';
		await $.ajax({
			url: url,
			dataType: "json",
			success: function(response) {
				console.log(response)
				limite = response.limit
				app.productos = response.data
			}
		});
		// generar los primeros links
		let url2 = "<?= base_url("createLinks") ?>/" + 7 + "/" + limite;
		await $.ajax({
			url: url2,
			success: function(response) {
				console.log(response)
				$("#botonNavegacion").html(response)

			}
		});
	}
</script>