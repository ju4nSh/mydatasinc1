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

<div class="container-fluid py-4">
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
                                <div data-app="true" class="v-application v-application--is-ltr theme--light">
                                    <v-main>
                                        <v-spacer></v-spacer>
                                        <div class="container">
                                            <div class="row justify-content-between">
                                                <div class="col-4">
                                                    <v-text-field v-model="search" append-icon="mdi-magnify"
                                                        label="Search" single-line hide-details></v-text-field> <br>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="container">
                                            <v-data-table :headers="columnas" :items="articulos" class="elevation-19"
                                                :search="search" :loading="loading">
                                                <template v-slot:item.fulname="{ item }">
                                                    {{item.Nombre}} {{item.Apellido}}
                                                </template>
                                                <template v-slot:item.actions="{ item }">
                                                    <v-icon small @click="ActualizarItem(item,item.Identificacion)">
                                                        mdi-pencil
                                                    </v-icon>
                                                    <v-icon small
                                                        @click="ActualizarContraseña(item,item.Identificacion)">
                                                        mdi-key
                                                    </v-icon>
                                                    <v-icon small @click="deleteItem(item,item.Identificacion)">
                                                        mdi-delete
                                                    </v-icon>
                                                </template>
                                            </v-data-table>
                                        </div>
                                    </v-main>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col align-self-start">
                                <a href="#seccion" type="button" data-toggle="collapse">
                                    <h6>Agregar Cliente <i class="fas fa-plus"></i></h6>
                                </a>
                                <div class="collapse" id="seccion">
                                    <br>
                                    <div class="well">
                                        <form id="form" v-on:submit.prevent="send">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input"
                                                            class="form-control-label">Identificacion</label>
                                                        <input class="form-control" type="number" id="Id" name="Id"
                                                            min="10000000" style="border: 0px;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input" class="form-control-label">First
                                                            name</label>
                                                        <input class="form-control" type="text" id="Nombre"
                                                            name="Nombre" minlength="3" maxlength="15"
                                                            style="border: 0px;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input" class="form-control-label">Last
                                                            name</label>
                                                        <input class="form-control" type="text" id="Apellido"
                                                            name="Apellido" minlength="3" maxlength="20"
                                                            style="border: 0px;" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-uppercase text-sm">Contact Information</p>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input" class="form-control-label">Email
                                                            address</label>
                                                        <input class="form-control" type="email" id="Correo"
                                                            name="Correo" minlength="11" maxlength="30" required
                                                            style="border: 0px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input"
                                                            class="form-control-label">City</label>
                                                        <input class="form-control" type="text" id="Ciudad"
                                                            name="Ciudad" minlength="3" maxlength="20"
                                                            style="border: 0px;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input"
                                                            class="form-control-label">Country</label>
                                                        <input class="form-control" type="text" id="Pais" name="Pais"
                                                            minlength="3" maxlength="20" required style="border: 0px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group" id="borde">
                                                        <label for="example-text-input"
                                                            class="form-control-label">Usuario</label>
                                                        <input class="form-control" type="text" id="Usuario"
                                                            name="Usuario" minlength="3" maxlength="20" required
                                                            style="border: 0px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1">Rol</label>
                                                        <select class="form-control" id="Rol" name="Rol">
                                                            <option v-for="docente in roles"
                                                                :value="docente.Identificacion">{{docente.Nombre}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="horizontal dark">
                                            <button class="btn btn-primary" type="submit" value="hgsd">Agregar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h5>Modificar Rol</h5>
                                        <form id="formularioModificarRolUsuario"
                                            v-on:submit.prevent="modificarRolUsuario">
                                            <div class="mb-3">
                                                <label for="">Identificacion</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    placeholder="Secret Key" :value="Id" readonly id="Identificacion"
                                                    name="Identificacion">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlSelect1">Rol</label>
                                                <select class="form-control" id="Rol1" name="Rol1">
                                                    <option v-for="docente in roles" :value="docente.Identificacion">
                                                        {{docente.Nombre}}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign
                                                    in</button>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h5>Modificar Contraseña</h5>
                                        <form id="formPassw"
                                            v-on:submit.prevent="modificarPassClient">
                                            <div class="mb-3">
                                                <label for="">Identificacion</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    placeholder="Secret Key" :value="Id" readonly id="id"
                                                    name="id">
                                            </div>
                                            <div class="mb-3">
                                                <label for="">Contraseña</label>
                                                <input type="password" class="form-control form-control-lg"
                                                    placeholder="Secret Key" :value="Password" id="Password"
                                                    name="Password">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit"
                                                    class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Modificar</button>
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
    </div>
</div>

<?= $this->endSection("contenido") ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scriptsClienteRef")?>
<?= $this->endSection() ?>