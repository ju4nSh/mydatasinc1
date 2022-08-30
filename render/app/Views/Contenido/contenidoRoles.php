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
                            <h4 class="mb-2">Roles</h4>
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
                                    <h6>Agregar Nuevo Rol <i class="fas fa-plus"></i></h6>
                                </a>
                                <div class="collapse" id="seccion">
                                    <br>
                                    <div class="well">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="example-text-input"
                                                        class="form-control-label">Nombre</label>
                                                    <input class="form-control" type="text" id="nombre" name="nombre"
                                                        minlength="3" maxlength="15" required>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">Vistas a las que tendra
                                                        acceso</label>
                                                    <select multiple class="form-control" id="prueba">
                                                        <option value="Clientes">Clientes</option>
                                                        <option value="Productos">Productos</option>
                                                        <option value="DatosProducto">Datos Producto</option>
                                                        <option value="Perfil">Perfil</option>
                                                        <option value="Usuario">Usuario</option>
                                                        <option value="Prueba">Prueba</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button v-on:click="select">Agregar</button>
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
<?= $this->include("Archexternos/scriptsRoles")?>
<?= $this->endSection() ?>