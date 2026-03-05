<div class="row">
<?php

if(have_posts()):
    while(have_posts()): the_post();
        
        
            ?>
            <div class="card mb-3 col-md-4">

  <?php the_post_thumbnail("card-img-top img-fluid"); ?>

  <div class="card-body">
    <a href="<?php the_permalink() ?>"><h5 class="card-title"><?php the_title(); ?></h5></a>
    <p class="card-text"><?php the_excerpt(); ?></p>
    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
  </div>
</div>

            <?php
      
    endwhile;
else:
    echo "No Post Found";
endif;
?>
</div>
