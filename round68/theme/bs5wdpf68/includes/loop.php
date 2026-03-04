<div class="row">
<?php

if(have_posts()):
    while(have_posts()): the_post();
        
        if(is_front_page()):
            ?>
            <div <?php post_class("card mb-3 col-md-4"); ?>>

  <?php the_post_thumbnail('medium', array('class' => 'card-img-top img-fluid')); ?>

  <div class="card-body">
    <a href="<?php the_permalink() ?>"><h5 class="card-title"><?php the_title(); ?></h5></a>
    <p class="card-text"><?php the_excerpt(); ?></p>
    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
  </div>
</div>
            <?php
        elseif(is_single()):
            // single page design
            ?>
            <div class="card mb-3 col-md-12">
              <?php the_post_thumbnail('large', array('class' => 'card-img-top img-fluid')); ?>
              <div class="card-body">
                <h5 class="card-title"><?php the_title(); ?></h5>
                <p class="card-text"><?php the_content(); ?></p>
                <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
              </div>
            </div>
            <!-- load comments template -->
            <?php comments_template(); ?>
            <?php
            else:
                // archive page design
                ?>
                <div class="card mb-3 col-md-4">
                  <?php the_post_thumbnail('medium', array('class' => 'card-img-top img-fluid')); ?>
                  <div class="card-body">
                    <a href="<?php the_permalink() ?>"><h5 class="card-title"><?php the_title(); ?></h5></a>
                    <p class="card-text"><?php the_excerpt(); ?></p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                  </div>
                </div>
                <?php            
        endif;        
    endwhile;
    ?>
    <div class="d-flex justify-content-start bg-light">
    <div><?php previous_posts_link('« Newer Posts'); ?></div>
    <div><?php echo paginate_links(); ?></div>
    <div><?php next_posts_link('Older Posts »'); ?></div>
    </div>
    <?php
else:
    echo "No Post Found";
endif;
?>
</div>
