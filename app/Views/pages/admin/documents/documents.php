<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Administrar Documentos</h5>
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <div id="folderTree"></div>
        </div>
        <div class="col">
          <div class="d-flex align-items-center justify-content-between align-items-center mb-3">
            <h5 class="card-title fw-semibold m-0" id="title__documents"></h5>
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createDocument">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="" height="18" width="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
              </svg>
              Cargar
            </button>
            <?php include('document-create-modal.php'); ?>
          </div>  
          <div id="documents__container" class="mt-2">
            <ul id="document__list__container">              
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var csrfName      = '<?= $csrfName ?>';
  var csrfHash      = '<?= $csrfHash ?>';
</script>
