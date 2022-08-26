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
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Tabla clientes referenciados</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <div data-app="true" class="v-application v-application--is-ltr theme--light">
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
                                <div class="container">
                                    <v-data-table :headers="columnas" :items="articulos" class="elevation-19"
                                        :search="search" hide-default-footer>

                                        <template v-slot:item.grafica="{ item }">
                                            <v-progress-circular :value="item.Health" :color="item.Color" :size="40"
                                                :width="7">
                                                {{item.Health}}
                                            </v-progress-circular>
                                        </template>

                                    </v-data-table>
                                    <br>
                                    <template v-if="Estado === true">
                                    <template v-if="count > 1">
                                    <v-btn class="ma-2" @click="Paginar('menos')" id="pag" outlined color="teal">
                                        <v-icon>mdi-chevron-left</v-icon>
                                    </v-btn>
                                    </template>
                                    <v-btn class="ma-2" outlined fab color="teal">
                                        {{ count }}
                                    </v-btn>
                                    <v-btn class="ma-2" @click="Paginar('mas')" outlined color="teal">
                                        <v-icon>mdi-chevron-right</v-icon>
                                    </v-btn>
                                    </template>
                                    <template v-else>
                                    <template v-if="count > 1">
                                    <v-btn class="ma-2" @click="Paginar('menos')" id="pag" disabled outlined color="teal">
                                        <v-icon>mdi-chevron-left</v-icon>
                                    </v-btn>
                                    </template>
                                    <v-btn class="ma-2" outlined fab color="teal" disabled>
                                        {{ count }}
                                    </v-btn>
                                    <v-btn class="ma-2" @click="Paginar('mas')" disabled outlined color="teal">
                                        <v-icon>mdi-chevron-right</v-icon>
                                    </v-btn>
                                    </template>

                                </div>
                            </v-main>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection("contenido") ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scriptsDatosProducto") ?>
<?= $this->endSection() ?>