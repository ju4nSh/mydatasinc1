<?= $this->extend("Dis/dashboard"); ?>


<?= $this->section("navLateral"); ?>
<?= $this->include("Partes/navLateral"); ?>
<?= $this->endSection() ?>

<?= $this->section("navArriba"); ?>
<?= $this->include("Partes/navArriba"); ?>
<?= $this->endSection() ?>

<?= $this->section("contenido"); ?>
<?= $this->include("Partes/productos")?>
<?= $this->endSection() ?>

<?= $this->section("funciones"); ?>
<?= $this->include("scripts/productos")?>
<?= $this->endSection() ?>