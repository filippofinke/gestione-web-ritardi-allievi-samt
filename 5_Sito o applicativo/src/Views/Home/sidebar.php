<?php

use FilippoFinke\Libs\Permission;

?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-gavel"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RITARDI WEB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item <?php echo ($_SERVER["REQUEST_URI"] == '/') ? 'active' : ''; ?>">
        <a class="nav-link" href="">
            <i class="fas fa-gavel"></i>
            <span>Ritardi</span>
        </a>
    </li>

    <li class="nav-item <?php echo ($_SERVER["REQUEST_URI"] == '/recoveries') ? 'active' : ''; ?>">
        <a class="nav-link" href="recoveries">
            <i class="fas fa-clock"></i>
            <span>Recuperi</span>
        </a>
    </li>

    <?php if (Permission::isAdmin()) : ?>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Amministrazione
        </div>

        <!-- Nav Item - Users -->
        <li class="nav-item <?php echo ($_SERVER["REQUEST_URI"] ==  '/users') ? 'active' : ''; ?>">
            <a class="nav-link" href="users">
                <i class="fas fa-user"></i>
                <span>Gestione utenti</span>
            </a>
        </li>

        <!-- Nav Item - Administration -->
        <li class="nav-item <?php echo ($_SERVER["REQUEST_URI"] ==  '/settings') ? 'active' : ''; ?>">
            <a class="nav-link" href="settings">
                <i class="fas fa-cogs"></i>
                <span>Impostazioni</span>
            </a>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>