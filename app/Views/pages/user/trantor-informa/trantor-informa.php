<div class="container-fluid">
  <div class="tinf__container">
    <div class="tif__container_cards">

      <!-- Crear publicación -->
      <?php include('trantor-informa-crear-pub.php'); ?>

      <!--Modal -->
      <?php include('trantor-informa-modal.php'); ?>

      <!-- Feed -->
      <?php foreach($feed as $f): ?>
        <?php 
          $currentFeed = $f;
          include('trantor-informa-card.php'); 
        ?>
      <?php endforeach; ?>
    </div>
  </div>
</div>