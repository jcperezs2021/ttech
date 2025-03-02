<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Nuevo empleado</h5>
            <a href="<?= base_url('user') ?>" class="btn btn-outline-primary d-block">Volver</a>
          </div>
          <form method="post" class="py-4" action="<?= base_url('auth/register') ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nombre(s)</label>
                  <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Apellidos</label>
                  <input 
                    type="text" 
                    id="lastname" 
                    name="lastname" 
                    class="form-control" 
                    required=""
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
                    class="form-control" 
                    required=""
                    maxlength="10"
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Foto</label>
                  <input 
                    type="file" 
                    id="photo" 
                    name="photo" 
                    class="form-control" 
                    required=""
                    accept=".png, .jpg, .jpeg"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Confirma Password</label>
                  <input 
                    type="password" 
                    id="password-confirm" 
                    name="password-confirm" 
                    class="form-control" 
                    required=""
                  >
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label">Selecciona puesto</label>
                  <select class="form-select select2" name="ocupation" required>
                    <option value="">Selecciona un puesto</option>
                    <?php foreach($ocupations as $ocupation): ?>
                      <option value="<?= $ocupation->id ?>"><?= $ocupation->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <div class="row">
                  <div class="col-8">
                    <div>
                      <label class="form-label">Jefe directo</label>
                      <select class="form-select select2" name="parent" id="parent" required>
                        <option value="">Selecciona jefe directo</option>
                        <?php foreach($users as $user): ?>
                          <option value="<?= $user->id ?>"><?= $user->complete_name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col d-flex align-items-center">
                      <div class="form-check d-flex">
                        <input class="form-check" type="checkbox" value="1" id="no_aplica" name="no_aplica">
                        <label class="form-check" for="no_aplica">
                          No aplica
                        </label>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label">Selecciona rol</label>
                  <select class="form-select select2" name="rol" required>
                    <option value="">Selecciona un rol</option>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                  </select>
                </div>
              </div>
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
            <button type="submit" class="btn btn-outline-primary d-block">Crear usuario</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: 'Selecciona',
      allowClear: true
    });
  });

   // Función para habilitar/deshabilitar el select y agregar/quitar el atributo required
   $('#no_aplica').on('change', function() {
      if ($(this).is(':checked')) {
        $('#parent').val(null).trigger('change');
        $('#parent').prop('disabled', true).removeAttr('required');
      } else {
        $('#parent').prop('disabled', false).attr('required', 'required');
      }
    });
</script>

