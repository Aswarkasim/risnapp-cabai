<?php $uri =  $this->uri->segment(1); ?>

<header class="p-3 border-bottom">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
      <a href="<?= base_url(); ?>" class="d-flex align-items-center mb-2 mb-lg-0 pr-5">
        <img src="<?= base_url('assets/img/logo.png'); ?>" width="100px" alt="">
      </a>


      <ul class="nav col-12 col-lg-auto me-lg-auto float-right mb-2 justify-content-center mb-md-0">
        <li><a href="<?= base_url() ?>" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="<?= base_url() ?>home/diagnosa/ask" class="nav-link px-2 link-dark">Diagnosa</a></li>
        <li><a href="<?= base_url() ?>home/panduan" class=" nav-link px-2 link-dark">Panduan</a></li>
      </ul>

      <form class="form-inline my-2 my-lg-0">
        <a href="<?= base_url('admin/auth'); ?>" class="btn btn-warning">
          <i class="fa fa-sign-in"></i> Login admin
        </a>
      </form>

    </div>
  </div>
</header>