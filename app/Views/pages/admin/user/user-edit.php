<?php
  $user       = $data['user'];
  $users      = $data['users'];
  $ocupations = $data['ocupations'];
?>
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Editar empleado</h5>
            <a href="<?= base_url('user') ?>" class="btn btn-outline-primary d-block">Volver</a>
          </div>
          <form method="post" class="py-4" action="<?= base_url('auth/user/update') ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nombre(s)</label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $user->id ?>"
                  >
                  <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="<?= $user->name ?>"
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label">Apellidos</label>
                  <input 
                    type="text" 
                    id="lastname" 
                    value="<?= $user->lastname ?>"
                    name="lastname" 
                    class="form-control" 
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">E-mail</label>
                  <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?= $user->email ?>"
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Telefono</label>
                  <input 
                    type="text" 
                    id="telephone" 
                    name="telephone" 
                    value="<?= $user->telephone ?>"
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <label class="form-label">Foto</label>
                <div class="mb-4 d-flex align-items-center">
                  <img
                    class="rounded-circle" width="50" height="50"
                    alt="<?= $user->name ?>"
                    src="<?= base_url( $user->photo) ?>"
                    id="actualImage"
                  />
                  <div class="ms-2 w-100">
                    <input 
                      type="file" 
                      id="photo" 
                      name="photo" 
                      class="form-control" 
                      accept=".png, .jpg, .jpeg"
                    >
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Selecciona puesto</label>
                    <select class="form-select select2" name="ocupation" required>
                      <option value="<?= $user->ocupation ?>"><?= $user->ocupation_name ?></option>
                      <?php foreach($ocupations as $ocupation): ?>
                        <option value="<?= $ocupation->id ?>"><?= $ocupation->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Selecciona jefe directo</label>
                    <select class="form-select select2" name="parent" required>
                      <option value="<?= $user->parent ?>"><?= $user->parent_name ?></option>
                      <?php foreach($users as $user): ?>
                        <option value="<?= $user->id ?>"><?= $user->complete_name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Rol</label>
                    <select class="form-select select2" name="rol" required>
                      <option value="<?= $user->rol ?>">
                        <?php
                          if ($user->rol == 'admin') {
                            echo 'Administrador';
                          } else {
                            echo 'Usuario';
                          }
                        ?>
                      </option>
                      <option value="user">Usuario</option>
                      <option value="admin">Administrador</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <label class="form-label">Restablecer password</label>
                    <input 
                      type="password" 
                      id="password" 
                      name="password" 
                      class="form-control" 
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
              <button type="submit" class="btn btn-outline-primary d-block">Actualizar usuario</button>
              <a class="btn btn-outline-warning ms-2" id="inactive_user" style=" <?= $user->active == 1 ? '' : 'display:none' ?>">Desactivar usuario</a>
              <a class="btn btn-outline-danger ms-2" id="active_user" style=" <?= $user->active == 1 ? 'display:none' : '' ?>">Activar usuario</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var userId      = "<?= $user->id; ?>"
  var baseUrl     = "<?= base_url('auth/user'); ?>"
  var csrfName    = '<?= $data['csrfName']; ?>';
  var csrfHash    = '<?= $data['csrfHash']; ?>';
</script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: 'Selecciona',
      allowClear: true
    });
  });
</script>