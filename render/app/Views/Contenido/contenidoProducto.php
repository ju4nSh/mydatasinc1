<?= $this->extend("Dis/dashboard"); ?>


<?= $this->section("head"); ?>
<?= $this->include("Partes/head"); ?>
<?= $this->endSection() ?>

<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral"); ?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba"); ?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>

<div class="row mt-3" id="contenidoProducto">
	<div class="col-lg-12 mb-lg-0 mb-4">
		<div class="row p-3">
			<div class="card col-md-auto m-1 d-flex justify-content-between">
				<a data-target="#agregarProductoModal" @click="categoriasProductos" data-toggle="modal" class="addProductBoton"><i class="fas fa-plus"></i>Agregar producto</a>
			</div>
			<div class="card col-md-12">
				<div class="card-header pb-0">
					<div class="row">
						<h4 class="mb-2">Mis productos</h4>
						<div class="productosCargados">
							<div class="shadow-lg rounded-3" v-for="(p, index) in productos">
								<div :id="p.codigo" class="carousel slide " data-ride="carousel">
									<div class="carousel-inner">
										<div class="carousel-item " :class="{ 'active' : index == 0}" v-for="(img, index) in p.imagen">
											<img :src="img" class="d-block w-100 rounded-top" alt="...">
										</div>
									</div>
									<template v-if="p.imagen.length > 1">
										<button class="carousel-control-prev" type="button" :data-target=`#${p.codigo}` data-slide="prev">
											<span class="carousel-control-prev-icon" aria-hidden="true"></span>
											<span class="sr-only">Previous</span>
										</button>
										<button class="carousel-control-next" type="button" :data-target=`#${p.codigo}` data-slide="next">
											<span class="carousel-control-next-icon" aria-hidden="true"></span>
											<span class="sr-only">Next</span>
										</button>
									</template>
									<div class="p-1 detallesProductos">
										<label for="">{{p.nombre}}</label>
										<div class="cantidadProducto">
											<label>Stock: {{p.cantidad}}</label>
											<label> {{new Intl.NumberFormat("es-CO", {style:"currency", currency: "COP", minimumFractionDigits:0}).format(p.precio)}}</label>
										</div>
										<div class="categoria">
											<label>Categoria: {{p.categoria}}</label>
										</div>
									</div>
								</div>
								<div class="btn-group col-md-12" role="group" aria-label="Button group">
									<a :href="p.link" target="_blank" class="btn btn-light" type="button"><i class="fas fa-location-arrow"></i></a>
									<button class="btn btn-primary " type="button" data-target="#modalActualizarProductos" data-toggle="modal"><i class="fas fa-edit"></i></button>
									<button class="btn btn-info" type="button"><i class="fas fa-pause"></i></button>
									<button class="btn btn-danger" type="button"><i class="fas fa-trash-alt"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="container">
						<div class="card-body px-0 pt-0 pb-2">

						</div>
					</div>
				</div>
				<template>
					<div id="botonNavegacion">

					</div>
				</template>
			</div>
		</div>

		<!-- MODAL AGREGAR UN NUEVO PRODUCTO -->
		<div class="modal fade" id="agregarProductoModal" tabindex="-1" role="dialog" aria-labelledby="agregarProductoModal" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Publicar un producto nuevo</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form>
							<div class="text-center">
								<div id="spinnerAgregarProducto" class="" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
							</div>
							<input id="codigoPaPublicar" type="hidden" name="" value="">
							<div class="row categoriesDetail">
								<div class="form-group col-md-auto">
									<div v-for="(c, index) in categoriasEncontradas" :key="index" class="form-control">
										<div @click="detallesCategoria(c.id, index)" for="my-input">{{c.name}}</div>
									</div>
								</div>
								<div class="form-group col-md-auto">
									<div v-for="(c, index) in detallesEncontrados" :key="index" class="form-control">
										<div @click="subcategory(c.id, -1)" :id="c.id" for="my-input">{{c.name}}</div>
									</div>
								</div>

								<div class="form-group col-md-auto" v-for="(item, p) in childrenCategories">
									<div is="sub-category" v-for="(j, index) in item" v-bind:id="j.id" v-bind:name="j.name" v-on:add="subcategory(j.id, p)"></div>
								</div>

							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="recipient-name" class="col-form-label">Nombre:</label>
									<input type="text" class="form-control col-md-11 " id="nombrePN">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="message-text" class="col-form-label">Categoria:</label>
									<input class="form-control animate__animated" type="text" name="" id="categoriaPN">
								</div>
								<div class="form-group col-md-6">
									<label for="message-text" class="col-form-label">Precio:</label>
									<input class="form-control" type="text" name="" id="precioPN">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="message-text" class="col-form-label">Cantidad:</label>
									<input class="form-control" type="text" name="" id="cantidadPN">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label" for="my-input">Imagen url:</label>
									<a @click="crearInputImagen" href="javascript:;" class="bg-info p-1"><i class="fas fa-plus"></i></a>

									<div class="fieldInput" class="form-control">
										<input v-for="input in inputImagen" id="imagenPN" class="form-control" :class="input.clase" type="text" name="">
									</div>

								</div>
							</div>
							<div class="row">
								<div v-for="(item, p) in camposRequeridos" is="campos" v-bind:typedata="item.value_type" v-bind:id="item.id" v-bind:name="item.name" v-bind:data="item.data" v-bind:allowed_units="item.allowed_units" v-bind:hint="item.hint"></div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="cerrarPN" data-dismiss="modal">Cerrar</button>
						<button @click="publicarPN" type="button" class="btn btn-primary">Publicar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN MODAL AGREGAR UN NUEVO PRODUCTO -->

		<!-- MODAL ACTUALIZAR PRODUCTO -->
		<div class="modal fade" id="modalActualizarProductos" tabindex="-1" role="dialog" aria-labelledby="labelActualizar" aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="labelActualizar">Actualizar producto</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div v-if="camposVacios" class="alert alert-danger" role="alert">
							<h4 class="alert-heading">Campos Vacios</h4>
							Rellena todos los campos
						</div>
						<div class="text-center">
							<div id="spinnerActualizarProducto" class="" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
						<form>
							<input id="codigoPaActualizar" type="hidden" name="" value="">
							<input id="codigoProductoAC" type="hidden" name="" value="">
							<div class="row">
								<div class="form-group col-md-12">
									<label for="recipient-name" class="col-form-label">Nombre:</label>
									<input type="text" class="form-control" id="nombreAC">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
									<label for="message-text" class="col-form-label">Cantidad:</label>
									<input class="form-control" type="text" name="" id="cantidadAC">
								</div>
								<div class="form-group col-md-6">
									<label for="message-text" class="col-form-label">Precio:</label>
									<input class="form-control" type="text" name="" id="precioAC">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="my-input">Descripción:</label>
									<textarea class="form-control" name="" id="descripcionAC" cols="30" rows="10"></textarea>
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" id="cerrarAC" data-dismiss="modal">Cerrar</button>
						<button @click="publicarAC" type="button" class="btn btn-primary">Actualizar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- FIN MODAL ACTUALIZAR PRODUCTO -->

	</div>
	<?= $this->endSection() ?>

	<?= $this->section("funciones"); ?>
	<?= $this->include("scripts/productos") ?>
	<?= $this->endSection() ?>


	<!-- <div class="table-responsive p-0">
							<table id="productos" class="table align-items-center mb-0">
								<div data-app="true" class="v-application v-application--is-ltr theme--light">
									<v-main>
										<v-spacer></v-spacer>
										<div class="row">
											<div class="container">
												<div class="col-4" class="mover">
													<v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
												</div>
											</div>

										</div>
										<br>
										<div class="container">
											<v-data-table :headers="columnas" :items="productos" class="elevation-19" :search="search">
												<template v-slot:item.imagen="{ item }">
													<img height="50px" style="object-fit: contain; border-radius: 100%;" width="50px" :src="JSON.parse(item.imagen)[0]" :alt="JSON.parse(item.imagen)[0]">
												</template>
												<template v-slot:item.link="{ item }">
													<a :href="item.link" target="_blank" style="text-decoration: none;">
														visitar
													</a>
												</template>
												<template v-slot:item.actions="{ item }">
													<v-icon small data-target="#modalActualizarProductos" data-toggle="modal" href="javascript:void(0);">
														mdi-pencil
													</v-icon>
													
												</template>
											</v-data-table>
										</div>
									</v-main>
								</div>
								</tbody>
							</table>
						</div> -->