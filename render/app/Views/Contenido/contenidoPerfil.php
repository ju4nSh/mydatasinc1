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
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Profile</p>
                        <button class="btn btn-primary btn-sm ms-auto" onclick='ConectarMerLi("<?=$rol?>")'>Settings</button>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">User Information</p>
                    <form method="post" id="formulario">
                        <div class="row">
                            <template v-for="variable in datos">
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">First
                                                name</label>
                                            <input class="form-control" type="text" :value="variable.Nombre" id="Nombre"
                                                name="Nombre" minlength="3" maxlength="15" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="example-text-input" class="form-control-label">Last name</label>
                                            <input class="form-control" type="text" :value="variable.Apellido"
                                                id="Apellido" name="Apellido" minlength="6" maxlength="20" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" :value="variable.Correo" id="Correo"
                                            name="Correo" minlength="9" maxlength="30" required>
                                    </div>
                                </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">Contact Information</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Address</label>
                                    <input class="form-control" type="text" :value="variable.Direccion" id="Direccion"
                                        name="Direccion" minlength="9" maxlength="40" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">City</label>
                                    <input class="form-control" type="text" :value="variable.Ciudad" id="Ciudad"
                                        name="Ciudad" minlength="3" maxlength="20" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Country</label>
                                    <input class="form-control" type="text" minlength="4" maxlength="20"
                                        :value="variable.Pais" id="Pais" name="Pais" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Contraseña</label>
                                    <input class="form-control" type="password" minlength="4" maxlength="20"
                                        :value="variable.Password" id="Pass" name="Pass" required>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <p class="text-uppercase text-sm">About me</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">About me</label>
                                    <input class="form-control" type="text" :value="variable.SobreMi" minlength="10"
                                        maxlength="250" id="SobreMi" name="SobreMi" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="example-text-input" class="form-control-label">Foto Url</label>
                                    <input class="form-control" type="text" :value="variable.Foto" minlength="15"
                                        maxlength="255" id="Foto" name="Foto" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="Actualizar(); return false"
                            class="btn btn-success">Actualizar</button>
                    </form>
                    </template>
                    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h5>Conectar con Mercadolibre</h5>
                                    <br>
                                    <form role="form" id="form">
                                        <div class="mb-3">
                                            <label for="">Secret Key</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Secret Key"
                                                aria-label="user" id="Usuario" name="Usuario" minlength="3"
                                                maxlength="15" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="">User Id</label>
                                            <input type="text" class="form-control form-control-lg"
                                                placeholder="User Id" aria-label="Password" id="password"
                                                name="password" minlength="5" maxlength="20" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-profile">
            <template v-for="variable in datos">
                <img src="../public/img/bg-profile.jpg" alt="Image placeholder" class="card-img-top">
                <div class="row justify-content-center">
                    <div class="col-4 col-lg-4 order-lg-2">
                        <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                            <a href="javascript:;">
                                <img :src="variable.Foto" class="rounded-circle img-fluid border border-2 border-white">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-0 pt-lg-2 pb-4 pb-lg-3">
                    <div class="d-flex justify-content-between">
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-none d-lg-block">Connect</a>
                        <a href="javascript:;" class="btn btn-sm btn-info mb-0 d-block d-lg-none"><i
                                class="ni ni-collection"></i></a>
                        <a href="javascript:;"
                            class="btn btn-sm btn-dark float-right mb-0 d-none d-lg-block">Message</a>
                        <a href="javascript:;" class="btn btn-sm btn-dark float-right mb-0 d-block d-lg-none"><i
                                class="ni ni-email-83"></i></a>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">22</span>
                                    <span class="text-sm opacity-8">Friends</span>
                                </div>
                                <div class="d-grid text-center mx-4">
                                    <span class="text-lg font-weight-bolder">10</span>
                                    <span class="text-sm opacity-8">Photos</span>
                                </div>
                                <div class="d-grid text-center">
                                    <span class="text-lg font-weight-bolder">89</span>
                                    <span class="text-sm opacity-8">Comments</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <h5>
                            {{variable.Nombre}} {{variable.Apellido}}<span class="font-weight-light">, 35</span>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{variable.Ciudad}}, {{variable.Pais}}
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>{{variable.SobreMi}}
                        </div>
                        <div>
                            <i class="ni education_hat mr-2"></i>University of Computer Science
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>
</div>

<?= $this->endSection() ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scripts")?>
<?= $this->endSection() ?>