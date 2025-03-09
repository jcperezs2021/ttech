<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">!Queremos escucharte!</h5>
      <p>Desde aqui puedes hacer llegar cualquier comentario, consulta o sugerencia, por favor, rellena el siguiente formulario y responderemos lo antes posible.</p>
      <div class="row">
        <div class="col">
          <div class="row mt-3">
            <div class="col-12">
              <form action="<?= base_url('suggestion/create') ?>" method="POST">
                <?php if (session('success') === null) : ?>
                  <?php echo csrf_field(); ?>
                  <input type="hidden" name="author" value="<?= session('user')->id ?>">
                  <h5>Datos de contacto.</h5>
                  <div class="row mt-3">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">Nombre(s)</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-user"></i></span>
                          <input 
                            placeholder="Nombre(s)"
                            value="<?= session('user')->name ?> <?= session('user')->lastname ?>"
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-control" 
                            required=""
                            lok
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label class="form-label">E-mail</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-mail"></i></span>
                          <input 
                            value="<?= session('user')->email ?>"
                            placeholder="E-mail"
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            required=""
                          >
                        </div>
                      </div>
                    </div> 
                    <div class="col-md-6">
                      <div class="mb-3 form-check">
                        <input 
                          type="checkbox" 
                          class="form-check-input" 
                          id="publishCheck" 
                          name="publish" 
                        >
                        <label class="form-check-label" for="publishCheck">Enviar como Anonimo</label>
                      </div>
                    </div>
                  </div>
                  <h5 class="mt-2">Tu mensaje.</h5>
                  <div class="row mt-3">
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label">Asunto</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-mail"></i></span>
                          <input 
                            placeholder="Asunto"
                            type="text" 
                            id="title" 
                            name="title" 
                            class="form-control" 
                            required=""
                          >
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="mb-3">
                        <label class="form-label
                        ">Mensaje</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="ti ti-mail"></i></span>
                          <textarea 
                            style="resize: none;"
                            placeholder="Mensaje"
                            id="message" 
                            name="message" 
                            class="form-control" 
                            required=""
                            rows="5"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
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
                <?php if (session('success') === null) : ?>
                <div class="row mt-3">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Enviar</button>
                  </div>
                </div>
                <?php endif; ?>
                <?php if (session('success') !== null) : ?>
                <div class="row mt-3">
                  <div class="col-12">
                    <button type="submit" class="btn btn-primary w-100">Enviar otra sugerencia</button>
                  </div>
                </div>
                <?php endif; ?>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-center p-4">
          <img src="<?= base_url('assets/images/logos/logo-2.png') ?>"  alt="Quejas y Sugerencias" height="120">
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const publishCheck = document.getElementById('publishCheck');
  const name = document.getElementById('name');
  const email = document.getElementById('email');

  publishCheck.addEventListener('change', () => {
    if(publishCheck.checked){
      name.value = 'Anonimo';
      email.value = 'anonimo@anonimo.com';
    }else{
      name.value = '<?= session('user')->name ?> <?= session('user')->lastname ?>';
      email.value = '<?= session('user')->email ?>';
    }
  });
</script>