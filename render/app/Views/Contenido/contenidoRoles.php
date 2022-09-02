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
                                                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field> <br>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="container">
                                            <v-data-table :headers="columnas" :items="articulos" class="elevation-19" :search="search" :loading="loading">
                                                <template v-slot:item.fulname="{ item }">
                                                    {{item.Nombre}} {{item.Apellido}}
                                                </template>
                                                <template v-slot:item.actions="{ item }">
                                                <v-icon small @click="ModalActualizar(item,item.Identificacion,item.Contenido,item.Nombre)">
                                                        mdi-pencil
                                                    </v-icon>
                                                    &nbsp;&nbsp;&nbsp;
                                                    <v-icon small @click="deleteItem(item,item.Identificacion,item.Nombre)">
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
                                                    <label for="example-text-input" class="form-control-label">Nombre</label>
                                                    <input class="form-control" type="text" id="nombre" name="nombre" minlength="3" maxlength="15" required>
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
                                                        <option value="SinRol">SinRol</option>
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
                        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h5>Modificar Rol</h5>
                                        <form id="formularioContenidoRol"
                                            v-on:submit.prevent="modificarContenidoRol">
                                            <div class="mb-3">
                                                <label for="">Identificacion</label>
                                                <input type="text" class="form-control form-control-lg"
                                                    placeholder="Secret Key" v-model="nombreRol" readonly id="IdRol"
                                                    name="IdRol">
                                            </div>
                                            <div class="row">
                                            <div class="col-6">
                                                <label for="">Contenido</label><br>
                                                <textarea name="textarea" rows="5" cols="40" readonly v-model="contenidoRol"></textarea>
                                            </div>
                                            <div class="col-6">
                                                <label for="">Contenido Nuevo</label><br>
                                                <textarea name="textarea" id="contenidoNuevoRol" name="contenidoNuevoRol" rows="5" cols="40" v-model="contenidoModificadoRol"></textarea>
                                            </div>
                                            </div>
                                            <div class="mb-3">
                                            <label for="exampleFormControlSelect2" >Vistas a las que tendra
                                                        acceso</label>
                                                    <select  class="form-control" id="ContenidoRolMod"  @change='onChange'>
                                                        <option value="Clientes">Clientes</option>
                                                        <option value="Productos">Productos</option>
                                                        <option value="DatosProducto">Datos Producto</option>
                                                        <option value="Perfil">Perfil</option>
                                                        <option value="Usuario">Usuario</option>
                                                        <option value="Prueba">Prueba</option>
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
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3>Modificar Roles Usuarios</h3>
                                        <form id="formroles" v-on:submit.prevent="UsuarioRoles">
                                            
                                                <div class="row">
                                                <template v-for="(item, p) in arrayUsuario">
                                                    <div class="col-6">
                                                            <label for="">Identificacion</label>
                                                            <input type="text" class="form-control inputIdentificacion" placeholder="Secret Key" v-model="item.Identificacion" readonly  >
                                                            <label for="">Nombre</label>
                                                            <input type="text" class="form-control inputNombre"  placeholder="Secret Key" v-model="item.Nombre" readonly >
                                                            <div class="form-group">
                                                            <label for="exampleFormControlSelect1">Rol</label>
                                                        <select class="form-control inputRol" id="Rol" name="Rol">
                                                            <option v-for="docente in arrayRoles"
                                                                :value="docente.Identificacion">{{docente.Nombre}}
                                                            </option>
                                                        </select>
                                                            </div>
                                                    
                                                    </div>
                                                </div>
                                            </template>
                                            <div class="text-center">
                                                <button type="submit"  class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Modificar</button>
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
<?= $this->include("Archexternos/scriptsRoles") ?>
<?= $this->endSection() ?>