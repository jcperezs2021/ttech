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
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Nombre(s) <small style="color:red;">*</small></label>
                  <input 
                    type="hidden" 
                    id="id" 
                    name="id"
                    value="<?= $user->id ?>"
                  >
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Nombre(s)"
                      type="text" 
                      id="name" 
                      name="name"
                      value="<?= $user->name ?>"
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-4">
                  <label class="form-label">Apellidos <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-user"></i></span>
                    <input 
                      placeholder="Apellidos"
                      type="text" 
                      id="lastname" 
                      value="<?= $user->lastname ?>"
                      name="lastname" 
                      class="form-control" 
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">E-mail <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                    <input 
                      placeholder="E-mail"
                      type="email" 
                      id="email" 
                      name="email" 
                      value="<?= $user->email ?>"
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">E-mail secundario</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                    <input 
                      placeholder="E-mail secundario"
                      type="email" 
                      id="email_secondary" 
                      name="email_secondary"" 
                      value="<?= $user->email_secondary ?>"
                      class="form-control" 
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Telefono</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-phone"></i></span>
                    <input 
                      placeholder="Telefono"
                      type="text" 
                      id="telephone" 
                      name="telephone" 
                      value="<?= $user->telephone ?>"
                      class="form-control" 
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Celular <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-phone"></i></span>
                    <input 
                      placeholder="Celular"
                      type="text" 
                      id="cellphone" 
                      name="cellphone" 
                      value="<?= $user->cellphone ?>"
                      class="form-control" 
                      required=""
                      maxlength="10"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-lg-4">
                <div class="mb-3">
                  <label class="form-label">Extensión</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-phone"></i></span>
                    <input 
                      placeholder="Extensión"
                      type="text" 
                      id="ext" 
                      name="ext" 
                      value="<?= $user->ext ?>"
                      class="form-control" 
                      maxlength="5"
                    >
                  </div>
                </div>
              </div>
              <div class="col">
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
              <hr>
              <div class="row">
                <div class="col-md-6 col-lg-4">
                  <div class="mb-4">
                    <label class="form-label">Selecciona puesto <small style="color:red;">*</small></label>
                    <select class="form-select select2" name="ocupation" required>
                      <option value="<?= $user->ocupation ?>"><?= $user->ocupation_name ?></option>
                      <?php foreach($ocupations as $ocupation): ?>
                        <option value="<?= $ocupation->id ?>"><?= $ocupation->name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-lg-4">
                  <div class="row">
                    <div class="col-8">
                      <div class="">
                        <label class="form-label">Selecciona jefe directo <small style="color:red;">*</small></label>
                        <select class="form-select select2" name="parent" id="parent" required <?= is_null($user->parent) ? 'disabled' : '' ?>>
                          <option value="<?= $user->parent ?>"><?= $user->parent_name ?></option>
                          <?php foreach($users as $user_local): ?>
                          <?php if ($user_local->id != $user->id): ?>
                            <option value="<?= $user_local->id ?>"><?= $user_local->complete_name ?></option>
                          <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col d-flex align-items-end">
                      <div class="form-check" style="margin: 0;padding: 0;display: flex;">
                        <input class="form-check" type="checkbox" value="1" id="no_aplica" name="no_aplica" <?= is_null($user->parent) ? 'checked' : '' ?>>
                        <label class="form-check" for="no_aplica" style="margin: 0;padding: 0;padding-left: 5px;">
                          N/A
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6 col-lg-4">
                  <div class="mb-4">
                    <label class="form-label">Rol <small style="color:red;">*</small></label>
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
                <div class="col-md-6 col-lg-4">
                  <div class="mb-4">
                    <label class="form-label">Restablecer password</label>
                    <div class="input-group">
                      <span class="input-group-text"><i class="ti ti-lock"></i></span>
                      <input 
                        placeholder="Escribe nueva contraseña"
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control" 
                      >
                    </div>
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

    // Función para habilitar/deshabilitar el select y agregar/quitar el atributo required
    $('#no_aplica').on('change', function() {
      if ($(this).is(':checked')) {
        $('#parent').val(null).trigger('change'); // Limpiar el select2
        $('#parent').prop('disabled', true).removeAttr('required');
      } else {
        $('#parent').prop('disabled', false).attr('required', 'required');
      }
    });

    // Verificar el estado inicial del checkbox y ajustar el select
    if ($('#no_aplica').is(':checked')) {
      $('#parent').val(null).trigger('change'); // Limpiar el select2
      $('#parent').prop('disabled', true).removeAttr('required');
    }
  });
</script>