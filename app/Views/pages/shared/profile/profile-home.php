<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="mb-2 d-flex align-items-center">
        <img 
          id="actualImage"
          alt="<?= base_url($user->name) ?>"
          src="<?= base_url($user->photo) ?>"
          class="rounded-circle"
          width="100"
          height="100"
        />
        <div class="ms-3">
          <h5 class="card-title fw-semibold mb-0"><?= $user->name ?> <?= $user->lastname ?><small class="text-muted">(<?= $user->email ?>)</small></h5>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-6">
          <h6 class="fw-semibold mb-4">Actualizar contraseña</h6>
          <form id="updatePassword">
            <div class="mb-3">
              <label for="oldPassword" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Nueva Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
          </form>
        </div>
        <div class="col-md-6">
          <h6 class="fw-semibold mb-4">Actualizar foto de perfil</h6>
          <form enctype="multipart/form-data" id="updatePhoto">
            <div class="mb-3">
              <label for="photo" class="form-label">Foto de perfil</label>
              <input type="file" class="form-control" id="photo" name="photo" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar foto de perfil</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var baseUrl       = "<?= base_url('profile/update'); ?>"
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>