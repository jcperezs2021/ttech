<div class="container-fluid">
  <div class="tinf__container">
    <div class="tif__container_cards">
      <!-- Crear publicación -->
      <?php include('trantor-informa-crear-pub.php'); ?>
      <!--Modal -->
      <?php include('trantor-informa-modal.php'); ?>
      <!-- Comentarios -->
      <?php include('trantor-informa-comment-list.php'); ?>
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