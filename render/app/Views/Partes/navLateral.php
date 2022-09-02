<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-5 "
    id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="<?= base_url("/index")?>">
            <img src="../public/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Mydata</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "index" ? "active" : "" ?>"
                    href="<?= base_url("/index") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <?php if ($rol == 0): ?>
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "Roles" ? "active" : "" ?>"
                    href="<?= base_url("/Roles") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "SinRol" ? "active" : "" ?>"
                    href="<?= base_url("/SinRol") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">SinRol</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "Clientes" ? "active" : "" ?>"
                    href="<?= base_url("/Clientes") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Clientes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?= current_url(true)->getSegment(5) == "Productos" ? "active" : "" ?>"
                    href="<?= base_url("/Productos") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Productos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link  <?= current_url(true)->getSegment(5) == "DatosProducto" ? "active" : "" ?>"
                    href="<?= base_url("/DatosProducto") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">DatosProducto</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "Perfil" ? "active" : "" ?>"
                    href="<?= base_url("/Perfil") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Perfil</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= current_url(true)->getSegment(5) == "Usuario" ? "active" : "" ?>"
                    href="<?= base_url("/Usuario") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Usuarios</span>

                    <a class="nav-link <?= current_url(true)->getSegment(5) == "Prueba" ? "active" : "" ?>"
                        href="<?= base_url("/Prueba") ?>">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Prueba</span>
                    </a>
            </li>

            <?php else:?>
            <?php $array= explode(',',trim($contenido,'"'));
            
              for($counter=0; $counter<sizeof($array); $counter++) :?>
              <li class="nav-item">
                <a class="nav-link  <?= current_url(true)->getSegment(5) == $array[$counter] ? "active" : "" ?>"
                    href="<?= base_url("/$array[$counter]") ?>">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1"><?php echo $array[$counter]?></span>
                </a>
            </li>
            <?php endfor;?>
          
            <?php endif; ?>

        </ul>
    </div>

    </div>
</aside>