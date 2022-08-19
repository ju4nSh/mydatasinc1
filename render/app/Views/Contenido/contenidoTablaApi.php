<?= $this->extend("Dis/dashboard"); ?>


<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral");?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba");?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tabla clientes referenciados</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <div id="app">
                            <v-app>
                                <v-main>
                                    <v-spacer></v-spacer>
                                    <div class="row">
                                        <div class="container">
                                            <div class="col-4" class="mover">
                                                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search"
                                                    single-line hide-details></v-text-field>
                                            </div>
                                        </div>

                                    </div>
                                    <br>
                                    <v-data-table :headers="columnas" :items="articulos" class="elevation-19"
                                        :search="search">
                                        <template v-slot:item.actions="{ item }">
                                            <v-icon small @click="deleteItem(item)">
                                                mdi-delete
                                            </v-icon>
                                        </template>
                                        </template>
                                    </v-data-table>
                                </v-main>
                            </v-app>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection("contenido") ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scriptsTablaApi")?>
<?= $this->endSection() ?>