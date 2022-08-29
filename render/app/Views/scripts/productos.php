<script>
	var app;
	let limite = 0;
	let numLinks = 6;
	let limit = 16;
	let offset = 1;
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
		var imagenes = Vue.component("imagenes", {
			template: `
						<div class="form-group col-md-2 col-sm-3 col-4 shadow rounded">
							<i style="cursor: pointer" @click="$emit(\'click\')" class="fas fa-trash"></i>
							<img style="height: 140px; object-fit: cover"  class="img w-100" :src="src" :alt="src" />
						</div>
					`,
			props: ["src"],
		})
		var inputImagenes = Vue.component("input-imagenes", {
			template: `
						<div class="col-md-12 col-sm-12 col-12">
							<input @change="$emit(\'change\')" class="form-control" :value="src" type="text" />
						</div>
					`,
			props: ["src"],
		})
		app = new Vue({
			el: '#app',
			vuetify: new Vuetify(),
			components: {
				subCategory: subCategory,
				campos: campos,
				imagenes: imagenes,
				inputImagenes: inputImagenes
			},
			data: {
				categoriasEncontradas: [],
				detallesEncontrados: [],
				childrenCategories: [],
				camposRequeridos: [],
				inputImagen: [],
				camposVacios: false,
				productos: [],
				countInput: 0,
				inputsActualizar: [],
				inputsActualizarAux: [],
			},
			mounted: async function() {

			},
			created: async function() {

				// let url1 = "<?#= base_url("getAllProduct") ?>";
				// await $.ajax({
				// 	type: "post",
				// 	url: url1,
				// 	dataType: "json",
				// 	success: function (response) {
				// 		if(response.result)
				// 			console.log(response)	
				// 		else 
				// 			swal("Error", `ocurrió un error: ${response.mensaje}`, "error")
				// 	}
				// });

				let url = "<?= base_url("getData") ?>/" + limit + "/" + offset + "/" + numLinks + "/null";
				// this.articulos = JSON.parse(response);
				await $.ajax({
					url: url,
					dataType: "json",
					success: function(response) {
						limite = response.limit
						app.productos = response.data
						$("#botonNavegacion").html(response.html)
						$('.carousel').carousel({
							interval: 2000
						})
					}
				});

			},

			filters: {},
			methods: {
				/*
				https:\/\/joyeriainter.com\/wp-content\/uploads\/2022\/06\/m50535-0002_modelpage_flagship_landscape.jpg
				https:\/\/static3.depositphotos.com\/1000501\/122\/i\/600\/depositphotos_1223337-stock-photo-colombian-flag.jpg
				https:\/\/www.motor.com.co\/__export\/1645199062631\/sites\/motor\/img\/2022\/02\/18\/20220218_094422465_615231d537e21_r_1632776804770_49-43-1121-578.jpeg_242310155.jpeg
				*/
				
				removeImagenModalActualizar: function (param) {
					app.inputsActualizar.splice(param, 1);
				},
				crearInputImagenActualizar: function () {
					app.inputsActualizar.push({valor: ''})
				},
				removeImagen: function(param) {
					app.inputImagen.splice(param, 1);
				},
				eliminarPublicacion: async function(e) {
					let codigoMercadolibre = e.target.parentElement.parentElement.firstChild.getAttribute("id");
					if (codigoMercadolibre != null) {
						let status = 'closed'
						await swal({
								title: `Deseas eliminar la publicación?`,
								icon: "warning",
								button: {
									text: `Eliminar!`,
									closeModal: false,
								},
							})
							.then(async resp => {
								if (!resp) throw null;

								await $.ajax({
									url: "<?= base_url("actualizarStatus") ?>/" + codigoMercadolibre + "/" + status,
									dataType: "json",
									success: function(response) {
										console.log(response)
										if (response.result) {
											e.target.parentElement.parentElement.remove()
											swal("Bien", `Producto eliminado`, "success");
										} else {
											swal("Oh!", "Fallo el borrado", "error")
										}
									}
								});
							})
							.catch(err => {
								if (err) {
									swal("Fallo", "ocurrió un error", "error");
								} else {
									// swal.stopLoading();
									// swal.close();

								}
							});
					} else {
						codigoMercadolibre = e.target.parentElement.parentElement.parentElement.firstChild.getAttribute("id")
						let status = 'closed'
						await swal({
								title: `Deseas eliminar la publicación?`,
								icon: "warning",
								button: {
									text: `Eliminar!`,
									closeModal: false,
								},
							})
							.then(async resp => {
								if (!resp) throw null;

								await $.ajax({
									url: "<?= base_url("actualizarStatus") ?>/" + codigoMercadolibre + "/" + status,
									dataType: "json",
									success: function(response) {
										console.log(response)
										if (response.result) {
											e.target.parentElement.parentElement.parentElement.remove()

											swal("Bien", `Producto eliminado`, "success");
										} else {
											let error = [];
											$.each(response.cause, function(indexInArray, valueOfElement) {
												console.log(valueOfElement.message)
												error.push(valueOfElement.message)
											});
											error.push(response.mensaje)
											swal("Error", JSON.stringify(error), "info");
										}
									}
								});
							})
							.catch(err => {
								if (err) {
									swal("Fallo", "ocurrió un error", "error");
								} else {
									// swal.stopLoading();
									// swal.close();

								}
							});
					}
				},
				pausarPublicacion: async function(e) {
					let codigoMercadolibre = e.target.parentElement.parentElement.firstChild.getAttribute("id");
					if (codigoMercadolibre != null) {
						let status = parseInt(e.target.getAttribute("data-estado")) ? 'paused' : 'active'
						await swal({
								title: `Deseas ${status == 'paused' ? 'pausar' : 'activar'} la publicación?`,
								icon: "warning",
								button: {
									text: `${status == 'paused' ? 'Pausar!' : 'Activar!'}`,
									closeModal: false,
								},
							})
							.then(async resp => {
								if (!resp) throw null;

								await $.ajax({
									url: "<?= base_url("actualizarStatus") ?>/" + codigoMercadolibre + "/" + status,
									dataType: "json",
									success: function(response) {
										console.log(response)
										if (response.result) {
											e.target.setAttribute("data-estado", status == "paused" ? 0 : 1)
											// cambiando color al botón
											e.target.classList.remove(status == "paused" ? 'btn-warning' : 'btn-info')
											e.target.classList.add(status == "paused" ? 'btn-info' : 'btn-warning')
											// cambiando el icono al botón
											e.target.firstChild.classList.remove(status == "paused" ? 'fa-pause' : 'fa-play')
											e.target.firstChild.classList.add(status == "paused" ? 'fa-play' : 'fa-pause')
											swal("Bien", `Producto ${status == 'paused' ? 'pausado' : 'activado'}`, "success");
										} else {
											let error = [];
											$.each(response.cause, function(indexInArray, valueOfElement) {
												console.log(valueOfElement.message)
												error.push(valueOfElement.message)
											});
											error.push(response.mensaje)
											swal("Error", JSON.stringify(error), "info");
										}
									}
								});
							})
							.catch(err => {
								if (err) {
									swal("Fallo", "ocurrió un error", "error");
								} else {
									// swal.stopLoading();
									// swal.close();

								}
							});
					} else {
						codigoMercadolibre = e.target.parentElement.parentElement.parentElement.firstChild.getAttribute("id")
						let status = parseInt(e.target.parentElement.getAttribute("data-estado")) ? 'paused' : 'active'
						await swal({
								title: `Deseas ${status == 'paused' ? 'pausar' : 'activar'} la publicación?`,
								icon: "warning",
								button: {
									text: `${status == 'paused' ? 'Pausar!' : 'Activar!'}`,
									closeModal: false,
								},
							})
							.then(async resp => {
								if (!resp) throw null;

								await $.ajax({
									url: "<?= base_url("actualizarStatus") ?>/" + codigoMercadolibre + "/" + status,
									dataType: "json",
									success: function(response) {
										console.log(response)
										if (response.result) {
											e.target.parentElement.setAttribute("data-estado", status == "paused" ? 0 : 1)
											// cambiando color al botón
											e.target.parentElement.classList.remove(status == "paused" ? 'btn-warning' : 'btn-info')
											e.target.parentElement.classList.add(status == "paused" ? 'btn-info' : 'btn-warning')
											e.target.classList.remove(status == "paused" ? 'fa-pause' : 'fa-play')
											// cambiando el icono al botón
											e.target.classList.add(status == "paused" ? 'fa-play' : 'fa-pause')
											swal("Bien", `Producto ${status == 'paused' ? 'pausado' : 'activado'}`, "success");
										} else {
											let error = [];
											$.each(response.cause, function(indexInArray, valueOfElement) {
												console.log(valueOfElement.message)
												error.push(valueOfElement.message)
											});
											error.push(response.mensaje)
											swal("Error", JSON.stringify(error), "info");
										}
									}
								});
							})
							.catch(err => {
								if (err) {
									swal("Fallo", "ocurrió un error", "error");
								} else {
									swal.stopLoading();
									swal.close();

								}
							});
					}
				},
				buscar: function(url) {
					window.open(url, "_blank")
				},
				crearInputImagen: function() {
					
					// app.inputImagen.push({
					// 	valor: "input"+ ++app.countInput
					// })
					app.inputImagen.push({valor: "", clase:'input'})
				},
				subcategory: function(id, index) {
					// <?#= base_url("obtenerdetallescategoria") ?>/
					$("#spinnerAgregarProducto").addClass("spinner-border")
					$.ajax({
						url: "https://api.mercadolibre.com/categories/" + id,
						dataType: "json",
						success: function(response) {
							if (response.children_categories.length) {
								app.delete = app.childrenCategories.splice((index + 1))
								app.childrenCategories.push(response.children_categories)
								$("#spinnerAgregarProducto").removeClass("spinner-border")
							} else {



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
							var altura = $("#agregarProductoModal").height();

							$("#agregarProductoModal").animate({
								scrollTop: altura + "px"
							});
						}
					});
				},
				categoriasProductos: function(param) {
					$("#spinnerAgregarProducto").addClass("spinner-border")
// <?#= base_url("/obtenercategoria") ?>
					$.ajax({
						url: "https://api.mercadolibre.com/sites/MCO/categories",
						dataType: "json",
						success: function(response) {
							// console.log(response)
							app.categoriasEncontradas = response;
							$("#spinnerAgregarProducto").removeClass("spinner-border")

						}
					});
				},
				detallesCategoria: function(param, i) {
					// <?#= base_url("obtenerdetallescategoria") ?>/
					$("#spinnerAgregarProducto").addClass("spinner-border")
					$.ajax({
						url: "https://api.mercadolibre.com/categories/" + param,
						dataType: "json",
						success: function(response) {
							app.childrenCategories.splice(0)
							app.detallesEncontrados = response.children_categories
							$("#spinnerAgregarProducto").removeClass("spinner-border")
						}
					});
				},
				publicarAC: async function() {
					($("#actualizarProductoN").parent()).addClass("disabled")
					$("#actualizarProductoN").addClass("spinner-border spinner-border-sm");
					let imagenes = [];
					$.each($(".inputAC"), function(indexInArray, valueOfElement) {
						if (valueOfElement.value !== "")
							imagenes.push(valueOfElement.value)
					});
					await $.ajax({
						type: "post",
						url: "<?= base_url("actualizarproducto") ?>",
						data: "id=" + $("#codigoPaActualizar").val() + "&codigo=" + $("#codigoProductoAC").val() + "&nombre=" + $("#nombreAC").val() + "&precio=" + $("#precioAC").val() + "&descripcion=" + $("#descripcionAC").val() + "&cantidad=" + $("#cantidadAC").val() + "&imagen=" + JSON.stringify(imagenes),
						dataType: "json",
						success: function(response) {
							// console.log(response)
							if (response.result == 1) {
								document.getElementById("form_actualizar_producto").reset();

								swal("Bien", "producto actualizado!", "success");
								app.camposVacios = false;
								$("#cerrarAC").click();
							} else if (response.result == 30) {
								swal("Error", "Rellene todos los datos", "info")
							} else {
								let error = [];
								$.each(response.cause, function(indexInArray, valueOfElement) {
									console.log(valueOfElement.message)
									error.push(valueOfElement.message)
								});
								error.push(response.mensaje)
								swal("Error", JSON.stringify(error), "info")
							}
						}
					});
					$("#actualizarProductoN").removeClass("spinner-border spinner-border-sm");
					($("#actualizarProductoN").parent()).removeClass("disabled")
				},
				publicarPN: async function(param) {
					($("#publicarProductoN").parent()).addClass("disabled")
					$("#publicarProductoN").addClass("spinner-border spinner-border-sm");
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
					await $.ajax({
						type: "post",
						url: "<?= base_url("publicarMercadolibre") ?>",
						data: "nombre=" + $("#nombrePN").val() + "&categoria=" + $("#categoriaPN").val() + "&descripcion=" + $("#descripcionPN").val() + "&precio=" + $("#precioPN").val() + "&cantidad=" + $("#cantidadPN").val() + "&imagen=" + JSON.stringify(imagenes) + "&attributes=" + JSON.stringify(attributes),
						dataType: "json",
						success: async function(response) {

							if (response.result == 1) {
								document.getElementById("form_agregar_producto").reset();
								await buscarNuevo(limit, offset)
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
					$("#publicarProductoN").removeClass("spinner-border spinner-border-sm");
					($("#publicarProductoN").parent()).removeClass("disabled")

				},
			},
			watch: {}
		});
		$('#modalActualizarProductos').on('show.bs.modal', async function(event) {
			app.inputsActualizar = []
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
					app.inputsActualizarAux = [...response.data.imagen]
					$.each(app.inputsActualizarAux, function (indexInArray, valueOfElement) { 
						 app.inputsActualizar.push({valor: valueOfElement})
					});
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
	async function buscarNuevo(limit1, offset1) {
		var url = "<?= base_url("getData") ?>/" + limit1 + "/" + offset1 + "/" + numLinks + "/" + limite;
		// this.articulos = JSON.parse(response);
		await $.ajax({
			url: url,
			dataType: "json",
			success: function(response) {
				console.log(response)
				limite = response.limit
				app.productos = response.data
				$("#botonNavegacion").html(response.html)
			}
		});
	}
</script>