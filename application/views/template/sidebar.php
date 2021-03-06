  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/dist/img/logo_dt.png" alt="Logo DT" width="80%" style="opacity: .8">
      <!-- <span class="brand-text font-weight-light">OPOP</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="<?= base_url(); ?>" class="nav-link <?= $this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-house-user"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= base_url('produk'); ?>" class="nav-link <?= $this->uri->segment(1) == 'produk' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Data Produk
              </p>
            </a>
          </li>
          <?php if ($role == 'Admin') { ?>
            <li class="nav-item">
              <a href="<?= base_url('users'); ?>" class="nav-link <?= $this->uri->segment(1) == 'users' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Data User
                </p>
              </a>
            </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?= base_url('file'); ?>" class="nav-link <?= $this->uri->segment(1) == 'file' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-file-image"></i>
              <p>
                File Pesantren
              </p>
            </a>
          </li>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>