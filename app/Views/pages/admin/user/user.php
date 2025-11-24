<div class="container-fluid mw-1600">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Empleados</h5>
            <div class="d-flex gap-2">
              <button class="btn btn-outline-secondary" id="btnBuscar">Buscar</button>
              <a href="<?= base_url('user/new') ?>" class="btn btn-outline-primary d-block">Nuevo</a>
            </div>
          </div>
          <div class="mt-5 table-responsive directory">
            <table class="table text-nowrap table-hover mb-0 align-middle" id="dt_table_users">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Nombre</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Jefe directo</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">E-mail</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">No. Empleado</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Estatus</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Conexión</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Rol</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($users as $user): ?>
                  <?php if( !$user->ghost ): ?>
                    <tr>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center">
                          <img
                            class="rounded-circle" width="35" height="35"
                            alt="<?= $user->name ?>"
                            src="<?= base_url( $user->photo) ?>"
                          />
                          <div class="ms-2">
                            <a class="btn p-1 px-2" style="color:var(--primary);" href="<?= base_url('user/edit/'.$user->id) ?>">
                              <?= $user->name ?> <?= $user->lastname ?>
                            </a>
                          </div>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->parent_name ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->email ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->employee_number ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center gap-2">
                          <span class="<?= $user->active == 1 ? 'bg-success' : 'bg-danger' ?> badge rounded-3 fw-semibold">
                            <?= $user->active == 1 ? 'Activo' : 'Inactivo' ?>
                          </span>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->last_login == NULL ? 'Sin actividad' : $user->last_login ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?php
                            if ($user->rol == 'admin') {
                              echo 'Administrador';
                            } elseif ($user->rol == 'operator') {
                              echo 'Operador';
                            } else {
                              echo 'Usuario';
                            }
                          ?>
                        </p>
                      </td>
                    </tr>     
                  <?php endif ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="searchUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="searchUser" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="searchUserText">Buscar empleado</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body feed">
        <p>Selecciona empleado</p>
        <div class="mb-3">
          <select name="userSearch" id="userSearch" class="form-select select2">
            <option></option>
            <?php foreach($users as $user): ?>
              <?php if( !$user->ghost ): ?>
                <option value="<?= $user->id ?>">
                  <?= $user->name ?> <?= $user->lastname ?> - <?= $user->employee_number ?>
                </option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-outline-primary d-block ms-2" id="irUsuario">Ver empleado</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $('#dt_table_users').DataTable().destroy();
  $('#dt_table_users').DataTable({
      order: [[0, 'asc']],
      language: {url: 'https://cdn.datatables.net/plug-ins/1.10.10/i18n/Spanish.json'},
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'colvis',
          text: 'Columna personalizada',
        },
        'csv', 'excel'
      ]
  });
  $('#btnBuscar').on('click', function() {
    $('#searchUser').modal('show');
  });
  $('.select2').select2({
    placeholder: 'Empleado',
    allowClear: true,
    dropdownParent: $('#searchUser')
  });
  $('#irUsuario').on('click', function() {
    var userId = $('#userSearch').val();
    if(userId){
      window.location.href = base_url + 'user/edit/' + userId;
    }
  });
</script>