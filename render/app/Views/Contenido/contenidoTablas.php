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
                                                    <input class="form-control" type="text" id="Usuario" name="Usuario"
                                                        minlength="3" maxlength="20" required style="border: 0px;">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Example select</label>
                                                    <select class="form-control" id="Rol" name="Rol">
                                                        <option></option>
                                                        <option value="0">Administrador</option>
                                                        <option value="1">Cliente</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group" id="borde">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Contraseña</label>
                                                    <input class="form-control" type="text" id="Pass" name="Pass"
                                                        minlength="3" maxlength="20" required style="border: 0px;">
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