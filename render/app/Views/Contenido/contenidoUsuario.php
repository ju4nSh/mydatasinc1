<?= $this->extend("Dis/dashboard"); ?>

<?= $this->section("title"); ?>
Usuarios
<?= $this->endSection() ?>

<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral"); ?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba"); ?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<div class="row mt-3">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="row p-3">
           
            <div class="card col-md-12">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-content-center">
                        <h4 class="mb-2">Mis clientes</h4>

                    </div>
                </div>
                <div class="container">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">identifiación</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">correo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">dirección</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="usuario in usuariosBD">
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{usuario.nombre}}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{usuario.identificacion}}</p>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">{{usuario.correo}}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{usuario.direccion}}</span>
                                        </td>
                                        <td v-if="usuarioActivo" class="align-middle text-center">
                                            <a data-target="#modalActualizarProductos" data-toggle="modal" href="javascript:void(0);" class="text-light font-weight-bold text-xs badge badge-sm bg-info" data-original-title="Edit user">
                                                Editar
                                            </a>
                                        </td>
                                        <td v-if="!usuarioActivo" class="align-middle text-center">
                                            <a data-target="#modalActualizarProductos" data-toggle="modal" href="javascript:void(0);" class="text-light font-weight-bold text-xs badge badge-sm bg-info" data-original-title="Edit user">
                                                Activar
                                            </a>
                                        </td>
                                        <td hidden class="align-middle text-center">
                                            <input type="text" value="">
                                        </td>
                                        <td hidden class="align-middle text-center">
                                            <input type="text" value="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section("funciones"); ?>
<?= $this->include("scripts/usuarios") ?>
<?= $this->endSection() ?>