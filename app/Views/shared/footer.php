</div>
    </div>
    <script> var base_url = '<?= base_url() ?>'; </script>

    <!-- Globales -->
    <script src="<?= base_url('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="//cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
    <script src="<?= base_url('assets/js/sidebarmenu.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/utils.js') ?>"></script>

  <?php if (strpos(uri_string(), 'documents') !== false || strpos(uri_string(), 'trantor-informa') !== false): ?>
    <!-- Files Config Translate -->
    <script src="<?= base_url('assets/js/files.js') ?>"></script>
  <?php endif; ?>  

  <?php if (strpos(uri_string(), 'user') !== false): ?>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <?php endif; ?>  

  <?php if (session('user')): ?>
    <!-- Alertas -->
    <script src="<?= base_url('assets/js/alerts.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'user/new') !== false): ?>
    <!-- Usuario -->
    <script src="<?= base_url('assets/js/user.js') ?>"></script>
  <?php endif; ?>

  <?php if (strpos(uri_string(), 'user/edit') !== false): ?>
    <!-- Usuario -->
    <script src="<?= base_url('assets/js/user-edit.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'profile') !== false): ?>
    <!-- Profile -->
    <script src="<?= base_url('assets/js/profile.js') ?>"></script>
  <?php endif; ?>

  <?php if (strpos(uri_string(), 'trantor-informa') !== false): ?>
    <!-- Trantor Informa -->
    <script src="<?= base_url('assets/js/trantor-informa.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'documents') !== false): ?>
    <!-- Documents -->
    <script src="<?= base_url('assets/js/documents.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'documentos') !== false): ?>
    <!-- Documentos -->
    <script src="<?= base_url('assets/js/documents-user.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'suggestions') !== false): ?>
    <!-- Suggestiongs -->
    <script src="<?= base_url('assets/js/suggestions.js') ?>"></script>
  <?php endif; ?>

  </body> 
</html>