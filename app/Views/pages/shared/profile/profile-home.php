<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="mb-2 d-flex align-items-center">
        <form enctype="multipart/form-data" id="updatePhoto" style="display:none;">
          <div class="mb-3">
            <label for="photo" class="form-label">Foto de perfil</label>
            <input type="file" class="form-control" id="photo" name="photo" accept=".jpg, .jpeg, .png" required>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar foto de perfil</button>
        </form>
        <img 
          id="actualImage"
          alt="<?= base_url($user->name) ?>"
          src="<?= base_url($user->photo) ?>"
          class="rounded-circle update__image"
          width="100"
          height="100"
        />
        <div class="ms-3">
          <h5 class="card-title fw-semibold mb-0"><?= $user->name ?> <?= $user->lastname ?></h5>
          <small class="text-muted">(<?= $user->email ?>)</small>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-4">
          <h6 class="fw-semibold mb-4">Actualizar contraseña</h6>
          <form id="updatePassword">
            <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="ti ti-lock"></i></span>
                  <input type="password" class="form-control" id="oldPassword" name="oldPassword" required placeholder="Contraseña actual">
                </div>
            </div>
            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-lock"></i></span>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Nueva contraseña">
              </div>
            </div>
            <div class="mb-3">
              <div class="input-group">
                <span class="input-group-text"><i class="ti ti-lock"></i></span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirmar contraseña">
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Actualizar contraseña</button>
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