<?php
    $currentUrl = $_SERVER['REQUEST_URI'];
    
?>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?= ($currentUrl == '/dashboard') ? 'active' : '' ?>">
    <a class="nav-link" href="<?= base_url('/dashboard')?>" >
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>
<li class="nav-item <?= ($currentUrl == '/dashboard/employee') ? 'active' : '' ?>">
    <a class="nav-link <?= (strpos($currentUrl, '/dashboard/employee') === 0) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseEmployee"
        aria-expanded="true" aria-controls="collapseEmployee">
        <i class="fa-solid fa-user"></i>
        <span>Employee</span>
    </a>
    <div id="collapseEmployee" class="collapse <?= (strpos($currentUrl, '/dashboard/employee') === 0) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header"></h6>
            <a class="collapse-item" <?= ($currentUrl === '/dashboard/employee') ? 'style="color:blue;"' : '' ?> href="<?= base_url('/dashboard/employee')?>">list</a>
        </div>
    </div>
</li>
<li class="nav-item <?= ($currentUrl == '/dashboard/salary') ? 'active' : '' ?>">
        <a class="nav-link <?= (strpos($currentUrl, '/dashboard/salary') === 0) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseSalary"
            aria-expanded="true" aria-controls="collapseSalary">
            <i class="fa-solid fa-wallet"></i>
            <span>Salary</span>
        </a>
        <div id="collapseSalary" class="collapse <?= (strpos($currentUrl, '/dashboard/salary') === 0) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <?php if ($_SESSION['role'] == 1) : ?>
                <a class="collapse-item " <?= ($currentUrl === '/dashboard/salary/create')  ? 'style="color:blue;"' : '' ?> href="<?= base_url('/dashboard/salary/create')?>">Create</a>
                <?php endif ?>
                <a class="collapse-item " <?= ($currentUrl === '/dashboard/salary')  ? 'style="color:blue;"' : '' ?> href="<?= base_url('/dashboard/salary')?>">list</a>
            </div>
        </div>
    </li>
<?php if ($_SESSION['role'] == 1) : ?>
    <li class="nav-item  <?= ($currentUrl == '/dashboard/position') ? 'active' : '' ?>">
        <a class="nav-link <?= (strpos($currentUrl, '/dashboard/position') === 0) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePosition"
            aria-expanded="true" aria-controls="collapsePosition">
            <i class="fa-solid fa-map-pin"></i>
            <span>Position</span>
        </a>
        <div id="collapsePosition" class="collapse <?= (strpos($currentUrl, '/dashboard/position') === 0) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" <?= ($currentUrl === '/dashboard/position')   ? 'style="color:blue;"' : '' ?>  href="<?= base_url('/dashboard/position')?>">list</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>

    <li class="nav-item <?= (strpos($currentUrl, '/dashboard/userManagement') === 0) ? 'active' : '' ?>">
        <a class="nav-link <?= (strpos($currentUrl, '/dashboard/userManagement') === 0) ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseUsersManagement"
            aria-expanded="true" aria-controls="collapseUsersManagement">
            <i class="fa-solid fa-wallet"></i>
            <span>UserManagement</span>
        </a>
        <div id="collapseUsersManagement" class="collapse <?= (strpos($currentUrl, '/dashboard/userManagement') === 0) ? 'show' : '' ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" <?= ($currentUrl ==='/dashboard/userManagement')  ? 'style="color:blue;"' : '' ?> href="<?= base_url('/dashboard/userManagement')?>">list</a>
                <a class="collapse-item" <?= ($currentUrl === '/dashboard/userManagement/create') ? 'style="color:blue;"' : '' ?>  href="<?= base_url('/dashboard/userManagement/create')?>">create</a>
            </div>
        </div>
    </li>
<?php endif ?>