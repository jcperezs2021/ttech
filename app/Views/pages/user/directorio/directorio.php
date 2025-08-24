<div class="container-fluid mw-1600">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Directorio</h5>
          </div>
          <div class="mt-5 table-responsive directory responsive">
            <table class="table text-nowrap table-hover mb-0 align-middle" id="dt_table_directory">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Nombre</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">E-mail</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">No. Empleado</h6>
                  </th>
                  <?php if( session('user')->rol == 'admin' ): ?>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">E-mail alternativo</h6>
                  </th>
                  <?php endif ?>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Teléfono</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Extensión</h6>
                  </th>
                  <?php if( session('user')->rol == 'admin' ): ?>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Celular</h6>
                  </th>
                  <?php endif ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach($users as $user): ?>
                  <?php if( !$user->ghost ): ?>
                    <tr>
                      <td class="border-bottom-0">
                        <div class="d-flex align-items-center">
                          <img
                            class="rounded-circle" width="50" height="50"
                            alt="<?= $user->name ?>"
                            src="<?= base_url( $user->photo) ?>"
                          />
                          <div class="ms-2">
                            <h6 class="fw-semibold mb-1">
                              <?= $user->name ?> <?= $user->lastname ?>
                            </h6>
                            <span class="fw-normal">
                              <?= $user->ocupation_name ?>
                            </span>                          
                          </div>
                        </div>
                      </td>
                      <td class="border-bottom-0">
                        <?php if( $user->hide_emails != 1 ): ?>
                        <p class="mb-0 fw-normal">
                          <?= $user->email ?>
                        </p>
                        <?php endif ?>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->employee_number ?>
                        </p>
                      </td>
                      <?php if( session('user')->rol == 'admin' ): ?>
                      <td class="border-bottom-0">
                        <?php if( $user->hide_emails != 1 ): ?>
                        <p class="mb-0 fw-normal">
                          <?= $user->email_secondary ?>
                        </p>
                        <?php endif ?>
                      </td>
                      <?php endif ?>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?php
                              $formattedTelephone = substr($user->telephone, 0, 2) . '-' . substr($user->telephone, 2, 4) . '-' . substr($user->telephone, 6);
                          ?>
                          <?= $formattedTelephone ?>
                        </p>
                      </td>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?= $user->ext ?>
                        </p>
                      </td>
                      <?php if( session('user')->rol == 'admin' ): ?>
                      <td class="border-bottom-0">
                        <p class="mb-0 fw-normal">
                          <?php
                              $formattedCellphone = substr($user->cellphone, 0, 2) . '-' . substr($user->cellphone, 2, 4) . '-' . substr($user->cellphone, 6);
                          ?>
                          <?= $formattedCellphone ?>
                        </p>
                      </td>
                      <?php endif ?>
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