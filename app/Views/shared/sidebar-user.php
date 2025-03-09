<!-- Sidebar Start -->
<aside class="left-sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url('trantor-informa') ?>" class="text-nowrap logo-img">
        <img src="<?= base_url('assets/images/logos/logo-1.png') ?>" height="40" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Intranet</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('trantor-informa') ?>" aria-expanded="false">
            <span>
                <i class="ti ti-flag"></i>
            </span>
            <span class="hide-menu">Trantor Informa</span>
          </a>
        </li>
        <!-- <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('trantor-technologies') ?>" aria-expanded="false">
            <span>
                <i class="ti ti-world"></i>
            </span>
            <span class="hide-menu">Trantor Technologies</span>
          </a>
        </li> -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('documentos') ?>" aria-expanded="false">
            <span>
                <i class="ti ti-files"></i>
            </span>
            <span class="hide-menu">Documentos</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?= base_url('quejas-sugerencias') ?>" aria-expanded="false">
            <span>
                <i class="ti ti-mail"></i>
            </span>
            <span class="hide-menu">Quejas y sugerencias</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="<?=base_url('/auth/logout')?>" aria-expanded="false">
            <span>
                <i class="ti ti-login"></i>
            </span>
            <span class="hide-menu">Salir</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">HELP DESK</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="https://www.nstrantor.com.mx/intranet/hd_glpi/" aria-expanded="false" target="_blank">
            <span>
                <i class="ti ti-ticket"></i>
            </span>
            <span class="hide-menu">GLPI</span>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<div class="body-wrapper">