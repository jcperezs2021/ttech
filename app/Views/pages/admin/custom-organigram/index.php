<div class="container-fluid mw-1600">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Organigramas</h5>
            <?php if(session()->get('user')->rol === 'admin'): ?>
            <div class="d-flex gap-2">
              <a href="<?= base_url('custom-organigram/create') ?>" class="btn btn-outline-primary d-block">
                <i class="ti ti-plus"></i> Crear Organigrama
              </a>
            </div>
            <?php endif; ?>
          </div>
          <div class="mt-5 table-responsive">
            <table class="table text-nowrap table-hover mb-0 align-middle" id="dt_organigramas">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Nombre</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Descripción</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Fecha creación</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Acciones</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php if(empty($organigramas)): ?>
                  <tr>
                    <td colspan="5" class="text-center py-4">
                      <p class="text-muted">No hay organigramas creados aún</p>
                    </td>
                  </tr>
                <?php else: ?>
                  <?php foreach($organigramas as $organigrama): ?>
                    <tr>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-semibold">
                          <?= $organigrama->name ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $organigrama->description ?? '-' ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= date('d/m/Y', strtotime($organigrama->created_at)) ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <div class="d-flex gap-2">
                          <a href="<?= base_url('custom-organigram/view/'.$organigrama->id) ?>" 
                             class="btn btn-sm btn-outline-primary" 
                             title="Ver organigrama">
                            <i class="ti ti-eye"></i>
                          </a>
                          <?php // Solo mostrar editar y eliminar si el rol es admin 
                            if(session()->get('user')->rol === 'admin'):
                          ?>

                          <a href="<?= base_url('custom-organigram/edit/'.$organigrama->id) ?>" 
                             class="btn btn-sm btn-outline-secondary" 
                             title="Editar">
                            <i class="ti ti-pencil"></i>
                          </a>
                          <button class="btn btn-sm btn-outline-danger btn-delete" 
                                  data-id="<?= $organigrama->id ?>"
                                  data-name="<?= $organigrama->name ?>"
                                  title="Eliminar">
                            <i class="ti ti-trash"></i>
                          </button>
                            <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  // Eliminar organigrama
  $('.btn-delete').on('click', function() {
    const id = $(this).data('id');
    const name = $(this).data('name');

    if (!confirm(`¿Estás seguro de que deseas eliminar el organigrama "${name}"? Esta acción no se puede deshacer.`)) {
      return;
    }

    showLoader();
    $.ajax({
      url: '<?= base_url('custom-organigram/delete') ?>',
      type: 'POST',
      data: {
        id: id,
        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
      },
      success: function(response) {
        hideLoader();
        if (response.status === 'success') {
          showMessage('alert-success', response.message);
          setTimeout(() => {
            location.reload();
          }, 1500);
        } else {
          showMessage('alert-danger', response.message);
        }
      },
      error: function() {
        hideLoader();
        showMessage('alert-danger', 'Ocurrió un error al eliminar');
      }
    });
  });
});
</script>
