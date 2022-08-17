<div class="row mt-3">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="row p-3">
            <div class="card col-md-auto m-1 d-flex justify-content-between">
                <a data-target="#agregarProductoModal" @click="categoriasProductos" data-toggle="modal" class="addProductBoton"><i class="fas fa-plus"></i>Agregar producto</a>
            </div>
            <div class="card col-md-12">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-content-center">
                        <h4 class="mb-2">Mis productos</h4>

                    </div>
                </div>
                <div class="container">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">codigo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">categoria</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">stock</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">precio</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">link</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // var_dump($productos)
                                    foreach ($productos as $value) {
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="<?= json_decode($value["imagen"])[0] ?>" class="avatar avatar-sm me-3" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm"><?= $value["nombre"] ?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0"><?= $value["codigo"] ?></p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success"><?= $value["categoria"] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?= $value["cantidad"] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold"><?= $value["precio"] ?></span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a target="_blank" href="<?= $value["link"] ?>" class="text-secondary text-xs font-weight-bold">Visitar</a>
                                            </td>
                                            <td class="align-middle">
                                                <?php
                                                if ($value["estado"]) {
                                                ?>
                                                    <a href="javascript:;" class="text-light font-weight-bold text-xs badge badge-sm bg-info" data-toggle="tooltip" data-original-title="Edit user">
                                                        Editar
                                                    </a> <?php
                                                        } else {
                                                            ?>
                                                    <a href="javascript:;" class="text-light font-weight-bold text-xs badge badge-sm bg-warning" data-toggle="tooltip" data-original-title="Edit user">
                                                        Activar
                                                    </a>

                                                <?php
                                                        }
                                                ?>

                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
                                <input type="text" class="form-control col-md-11" id="nombrePN">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="message-text" class="col-form-label">Categoria:</label>
                                <input class="form-control" type="text" name="" id="categoriaPN">
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
                                <input id="imagenPN" class="form-control" type="text" name="">
                            </div>
                        </div>
                        <div class="row">
                            <div v-for="(item, p) in camposRequeridos" is="campos" v-bind:typedata="item.value_type" v-bind:id="item.id" v-bind:name="item.name" v-bind:data="item.data" v-bind:allowed_units="item.allowed_units"></div>
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
</div>

<?= $this->include("scripts/productos") ?>