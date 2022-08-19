<?= $this->extend("Dis/dashboard"); ?>

<?= $this->section("head"); ?>
<?= $this->include("Partes/head"); ?>
<?= $this->endSection() ?>

<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral");?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba");?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<div class="container-fluid py-4" id="app">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tabla clientes referenciados</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-right mb-0" id="table_id">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nombre</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Correo</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ciudad</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Pais</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(variable, p) in clienteRef">
                                    <tr>
                                        <td>{{variable.Nombre}} {{variable.Apellido}}</td>
                                        <td>{{variable.Correo}}</td>
                                        <td>{{variable.Ciudad}}</td>
                                        <td>{{variable.Pais}}</td>
                                        <td class="align-middle">
                                            <a @click="elimiarClienteRef(variable.Identificacion,p)" class="text-secondary font-weight-bold text-xs"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Eliminar
                                            </a>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Agregar Clientes</h6>
                    <hr class="horizontal dark">
                </div>
                <div class="container">
                <div class="card-body px-0 pt-0 pb-2">
                    <form id="forms">
                    <div class="row">
                    <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Identificacion</label>
                                <input class="form-control" type="text" required id="Id" name="Id" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">First name</label>
                                <input class="form-control" type="text" required id="Nombre" name="Nombre" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Last name</label>
                                <input class="form-control" type="text" required id="Apellido" name="Apellido" >
                            </div>
                        </div>
                      </div>
                </div>
                <hr class="horizontal dark">
                <p class="text-uppercase text-sm">Contact Information</p>
                <div class="row">
                <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" required id="Correo" name="Correo" >
                            </div>
                        </div>
                        </div>
                        <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">City</label>
                            <input class="form-control" type="text" required id="Ciudad" name="Ciudad" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="example-text-input" class="form-control-label">Country</label>
                            <input class="form-control" type="text" required id="Pais" name="Pais" >
                        </div>
                    </div>
                    </div>
                    <hr class="horizontal dark">
                    <p class="text-uppercase text-sm">Informacion para Inicio de session</p>
                <div class="row">
                <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Usuario</label>
                                <input class="form-control" type="text" required id="Usuario" name="Usuario" >
                            </div>
                        </div>
                        </div>
                <hr class="horizontal dark">
                <button class="btn btn-success" onclick="AgregarCliente()" value="hgsd">Agregar</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
</div>

<?= $this->endSection("contenido") ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scriptsClienteRef")?>
<?= $this->endSection() ?>
