<div class="container-fluid">
  <div class="tinf__container">
    <?php include('trantor-informa-feed-filters.php'); ?>
    <div class="tif__container_cards">
      <!-- Crear publicación -->
      <?php if (session('user')->rol == 'admin'): ?>
        <?php include('trantor-informa-crear-pub.php'); ?>
        <?php include('trantor-informa-modal.php'); ?>
      <?php endif; ?>
      <!-- Comentarios -->
      <?php include('trantor-informa-comment-list.php'); ?>
      <!-- Image Full -->
      <?php include('trantor-informa-image-full.php'); ?>
      <!-- Feed -->
      <?php foreach($feed as $f): ?>
        <?php 
          $currentFeed  = $f;
          $comments     = $currentFeed->id;
          include('trantor-informa-card.php'); 
        ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<script>
  var csrfName = '<?= $csrfName ?>';
  var csrfHash = '<?= $csrfHash ?>';
</script>