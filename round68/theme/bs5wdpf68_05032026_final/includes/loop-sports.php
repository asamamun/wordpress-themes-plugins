<h3 class="section-title">🏆 Sports Highlights</h3>
<div class="owl-carousel owl-theme">
<?php
//we want to show 10 latest sports posts in owl carousel
$latest_sports_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
    'tax_query'      => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => ['sports','cricket','football'],
        ),
    ),
));

if ($latest_sports_posts->have_posts()) :
    while ($latest_sports_posts->have_posts()) : $latest_sports_posts->the_post();
        ?>
        <div class="item">
            <?php the_post_thumbnail('medium', array('class' => 'card-img-top img-fluid')); ?>
            <div class="card-body">
                <a href="<?php the_permalink() ?>"><h5 class="card-title"><?php the_title(); ?></h5></a>
                <!-- <p class="card-text"><?php the_excerpt(); ?></p> -->
                <!-- <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p> -->
            </div>
        </div>
        <?php
    endwhile;
endif; 
wp_reset_postdata();
?>
</div>

