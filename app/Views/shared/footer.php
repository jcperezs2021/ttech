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

  <?php if (strpos(uri_string(), 'user') !== false): ?>
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <?php endif; ?>  

  <?php if (session('user')): ?>
    <!-- Alertas -->
    <script src="<?= base_url('assets/js/alerts.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'user/edit') !== false): ?>
    <!-- Usuario -->
    <script src="<?= base_url('assets/js/user-edit.js') ?>"></script>
  <?php endif; ?>
  
  <?php if (strpos(uri_string(), 'profile') !== false): ?>
    <!-- Profile -->
    <script src="<?= base_url('assets/js/profile.js') ?>"></script>
  <?php endif; ?>

  </body> 
</html>