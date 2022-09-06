<?= $this->extend("Dis/admin/dashboard"); ?>


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
                                                    </template>
                                            </v-data-table>
                                        </div>
                                    </v-main>
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
    <?= $this->include("Archexternos/scriptsClientesSinRol")?>
<?= $this->endSection() ?>