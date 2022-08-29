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
						<div class="row mb-2">
							<h4 class="col-md-3">Mis productos</h4>
							<div class="form-group col-md-6 p-3">
								<input class="col-md-6 p-2 border" type="text" placeholder="Buscar productos" v-model="inputProducts">
								<button @click="searchProduts" class="btn btn-outline-success col-md-4 p-2 m-0" type="button">
									<span id="loadSearchProduts" class="" role="status" aria-hidden="true"></span>
									Buscar
								</button>
							</div>
						</div>
						<div class="productosCargados">
							<div class="shadow-lg rounded-3" v-for="(p, index) in productos">
								<div :id="p.codigo" class="carousel slide" data-ride="carousel">
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
									<button id="editarProductos" class="btn btn-primary " type="button" data-target="#modalActualizarProductos" data-toggle="modal"><i class="fas fa-edit"></i></button>
									<button @click="pausarPublicacion" :data-estado="p.estado" class="btn" :class="{'btn-warning' : p.estado == 1 , 'btn-info' : p.estado == 0}" type="button"><i class="fas" :class="{'fa-pause' : p.estado == 1, 'fa-play': p.estado == 0}"></i></button>
									<button @click="eliminarPublicacion" class="btn btn-danger" type="button"><i class="fas fa-trash-alt"></i></button>
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
								<div id="spinnerAgregarProducto">
									<div id="spiner" role="status">
										<span class="visually-hidden">Loading...</span>
									</div>
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
								<label for="recipient-name" class="col-form-label">Imagenes:</label>
								<div @click="removeImagen(p)" v-for="(item, p) in inputImagen" :indice="p" is="imagenes" v-bind:src="item.valor" v-if="item.valor != ''"></div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="recipient-name" class="col-form-label">Nombre:</label>
									<input type="text" class="form-control col-md-12 " id="nombrePN">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-md-12">
									<label for="recipient-name" class="col-form-label">Descripción:</label>
									<textarea class="form-control col-md-12" name="" id="descripcionPN" cols="30" rows="5"></textarea>
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
										<div v-for="input in inputImagen">
											<input class="form-control" :class="input.clase" type="text" name="" v-model="input.valor">
										</div>
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
						<button @click="publicarPN" class="btn btn-primary" type="button">
							<span id="publicarProductoN" class="" role="status" aria-hidden="true"></span>
							Publicar
						</button>
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
								<label for="recipient-name" class="col-form-label">Imagenes:</label>
								<div @click="removeImagenModalActualizar(p)" v-for="(item, p) in inputsActualizar" is="imagenes" v-bind:src="item.valor" v-if="item.valor != ''"></div>
							</div>
							<div class="row">
								<div class="form-group col-md-6">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label" for="my-input">Imagen url:</label>
									<a @click="crearInputImagenActualizar" href="javascript:;" class="bg-info p-1"><i class="fas fa-plus"></i></a>
									<div class="fieldInput">
										<input v-for="i in inputsActualizar" class="form-control inputAC" type="text" name="" v-model="i.valor">
									</div>
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
						<button @click="publicarAC" type="button" class="btn btn-primary">
							<span id="actualizarProductoN" class="" role="status" aria-hidden="true"></span>
							Actualizar</button>
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
