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
                                    <div class="row">
                                        <div class="container">
                                            <div class="col-4" class="mover">
                                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <div class="container">
                                        <v-data-table :headers="columnas" :items="articulos" class="elevation-19" :search="search">
                                            <template v-slot:item.actions="{ item }">
                                                <v-icon small @click="editItem(item)">
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon  small @click="deleteItem(item)">
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </v-data-table>
                                    </div>
                                </v-main>
                            </div>
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