<?php
  $area = $data['area'];
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar area</h5>
            <a href="<?= base_url('area') ?>" class="btn btn-outline-primary d-block">Volver</a>
          </div>
          <form method="post" class="py-4" action="<?= base_url('area/edit') ?>">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Puesto</label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $area->id ?>"
                  >
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Nombre area"
                      type="text" 
                      id="name" 
                      name="name"
                      value="<?= $area->name ?>"
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
            </div>
            <div id="message__response" class="alert alert-success" style="display:none">
            </div>
            <?php if (session('message') !== null) : ?>
              <div class="alert alert-danger">
                <?= session('message'); ?>
              </div>
            <?php endif; ?>
            <?php if (session('success') !== null) : ?>
              <div class="alert alert-success">
                <?= session('success'); ?>
              </div>
            <?php endif; ?>
            <div class="d-flex">
              <button type="submit" class="btn btn-outline-primary d-block">Actualizar area</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
