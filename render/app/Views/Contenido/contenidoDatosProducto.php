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
                                        :search="search" hide-default-footer :loading="loading">
                                        <template v-slot:item.foto="{ item }">
                                            <img :src="item.Imagen" alt="" width="50" height="50" srcset="">
                                        </template>
                                        <template v-slot:item.grafica="{ item }">
                                            <v-progress-circular :value="item.Health" :color="item.Color" :size="40"
                                                :width="7">
                                                {{item.Health}}
                                            </v-progress-circular>
                                        </template>
                                        <template v-slot:item.form="{ item }">
                                            <a data-toggle="modal" data-target="#exampleModalLong">Guia</a>
                                        </template>

                                    </v-data-table>
                                    <br>
                                    <div class="row">
                                        <div class="text-center">
                                            <template v-if="Estado === true">

                                                <v-pagination v-model="page" :length="tamaño" :total-visible="7"
                                                    prev-icon="mdi-menu-left" next-icon="mdi-menu-right" @input="next2"
                                                    circle></v-pagination>
                                            </template>
                                            <template v-else>
                                                <v-pagination v-model="page" :length="tamaño" :total-visible="7"
                                                    prev-icon="mdi-menu-left" next-icon="mdi-menu-right" @input="next2"
                                                    disabled circle></v-pagination>
                                            </template>
                                        </div>

                                    </div>
                            </v-main>
                        </div>
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Acciones para mejorar</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>technical_specification: verifica la calidad de los atributos y completa la
                                            ficha técnica.</p>
                                            <p>buybox: publica en catálogo.</p>
                                            <p>variations: utiliza variaciones para la publicación.</p>
                                            <p>product_identifiers: informar código universal del producto.</p>
                                            <p>picture: verifica la calidad de las imágenes.</p>
                                            <p>price: publica con precio más competitivo, y en caso de que aplique, te
                                            vamos a indicar el rango de precio que puedes utilizar.</p>
                                            <p>me2: utiliza Mercado Envíos en las publicaciones.</p>
                                            <p>free_shipping: ofrece envíos gratis.</p>
                                            <p>flex: utiliza Mercado Envíos Flex.</p>
                                            <p>immediate_payment: utiliza Mercado Pago (tag immediate_payment).</p>
                                            <p>classic: realiza una publicación con exposición al menos clásica.</p>
                                            <p>premium (installments_free): Realiza una publicación como premium.</p>
                                            <p>size_chart: informa una guía de talles.</p>
                                            <p>publish: es el objetivo relacionado a la publicación del ítem, realizado
                                            automáticamente al publicar.</p>
                                            <p>picture_fashion: verifica la calidad de las imágenes en tus publicaciones de
                                            moda.</p>
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
<?= $this->include("Archexternos/scriptsDatosProducto") ?>
<?= $this->endSection() ?>