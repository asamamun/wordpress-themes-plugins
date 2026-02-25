<?php
// Get carousel images from theme customizer
$carousel_images = wdpf68_get_carousel_images();

// Only display carousel if there are images
if (!empty($carousel_images)) :
?>
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php foreach ($carousel_images as $index => $image) : ?>
      <button type="button" 
              data-bs-target="#carouselExampleIndicators" 
              data-bs-slide-to="<?php echo $index; ?>" 
              <?php echo ($index === 0) ? 'class="active" aria-current="true"' : ''; ?> 
              aria-label="Slide <?php echo $index + 1; ?>"></button>
    <?php endforeach; ?>
  </div>
  
  <div class="carousel-inner">
    <?php foreach ($carousel_images as $index => $image) : ?>
      <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
        <img src="<?php echo esc_url($image); ?>" class="d-block w-100" alt="Slide <?php echo $index + 1; ?>">
      </div>
    <?php endforeach; ?>
  </div>
  
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<?php endif; ?>
