<?= $this->extend("Dis/dashboard"); ?>


<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral");?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba");?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<div class="row mt-3">
        <div class="col-lg-6 mb-lg-0 mb-4">
<div class="container">
<div class="card ">
            <div class="card-header pb-0 p-4">
              <div class="d-flex justify-content-between">
                <h4 class="mb-2">Datos</h4>
              </div>
            </div>
            <div class="container">
            <form method="post" action="<?= site_url('/agregar') ?>">
                            <div class="form-group">
                                <div class="row prueba">
                                    <div class="col-4">
                                        <label for="exampleInputEmail1">Id</label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp" id="txtId"
                                            name="txtId">
                                        <template v-if="condicionNombreCat===true">
                                            <label for="exampleInputEmail1">Titulo ---- Categoria: {{NombreCat}}
                                            </label>
                                        </template>
                                        <template v-else>
                                            <label for="exampleInputEmail1">Titulo </label>
                                        </template>
                                      
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            id="NameCategoria" name="NameCategoria" :value="idCategoria" hidden>
                                        <label for="exampleInputEmail1">Precio</label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            id="txtPrecio" name="txtPrecio">
                                        <label for="exampleInputEmail1">Cantidad</label>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            id="txtCantidad" name="txtCantidad">
                                        <br>
                                        <label for="exampleInputEmail1">imagen</label>
                                        <input type="button" @click="count=count+1" value="+">
                                        <template v-for="(val, i) in count">
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                :id="'txtImagen'+i" :name="'txtImagen'+i">
                                            <br>
                                        </template>
                                    </div>
                                    <div class="col-6">
                                        <template v-for="(data, p) in atributos">
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                :id="'txtNombreAtributo'+p" :name="'txtNombreAtributo'+p"
                                                :value="data.id" hidden>
                                            <label for="exampleInputEmail1">{{data.id}}</label>
                                            <template v-if="data.values===null">
                                                <input type="text" class="form-control" aria-describedby="emailHelp"
                                                    :id="'txtAtributo'+p" :name="'txtAtributo'+p">
                                            </template>
                                            <template v-else>
                                                <select class="form-control" :name="'txtAtributo'+p"
                                                    :id="'txtAtributo'+p">
                                                    <template v-for="datavalue in data.values">
                                                        <option :value="datavalue.name">{{datavalue.name}}</option>
                                                    </template>
                                                </select>
                                                <br>
                                            </template>
                                        </template>
                                        <input type="text" class="form-control" aria-describedby="emailHelp"
                                            id="numAtributo" name="numAtributo" :value="atributos.length" hidden>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" name="numerfotos"
                                :value="count">Submit</button>
                        </form>
            </div>
            </div>
          </div>
</div>
</div>
          </div>
<?= $this->endSection() ?>