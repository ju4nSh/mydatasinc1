<?= $this->extend("Dis/dashboard"); ?>


<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral"); ?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba"); ?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<div class="container-fluid py-4" id="app">
  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex align-items-center">
            <p class="mb-0">Edit Profile</p>
            <button class="btn btn-primary btn-sm ms-auto">Settings</button>
          </div>
        </div>
        <div class="card-body">
          <p class="text-uppercase text-sm">User Information</p>
          <div class="row">
          <form method="post" action="<?= base_url('')?>/ModificarPerfil">
            <template v-for="variable in datos">
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Email address</label>
                <input class="form-control" type="email" :value="variable.Correo" id="Correo" name="Correo">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">First name</label>
                <input class="form-control" type="text" :value="variable.Nombre" id="Nombre" name="Nombre">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Last name</label>
                <input class="form-control" type="text" :value="variable.Apellido" id="Apellido" name="Apellido">
              </div>
            </div>
          </div>
          <hr class="horizontal dark">
          <p class="text-uppercase text-sm">Contact Information</p>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Address</label>
                <input class="form-control" type="text" :value="variable.Direccion" id="Direccion" name="Direccion">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">City</label>
                <input class="form-control" type="text" :value="variable.Ciudad" id="Ciudad" name="Ciudad">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">Country</label>
                <input class="form-control" type="text" :value="variable.Pais" id="Pais" name="Pais">
              </div>
            </div>
          </div>
          <hr class="horizontal dark">
          <p class="text-uppercase text-sm">About me</p>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="example-text-input" class="form-control-label">About me</label>
                <input class="form-control" type="text" :value="variable.SobreMi" id="SobreMi" name="SobreMi">
              </div>
            </div>
          </div>
           <button type="submit" class="btn btn-success">Actualizar</button>
          </form>
          </template>
        </div>
      </div>
    </div>

</div>
</div>

<?= $this->endSection() ?>

<?= $this->section("funciones"); ?>
<?= $this->include("Archexternos/scripts")?>
<?= $this->endSection() ?>
