<?php

//show owl carousel only if show_post_carousel setting value is true
$show_post_carousel = get_theme_mod('show_post_carousel', true);
if (!$show_post_carousel) {
    return;
}
?>


<h3 class="section-title">📰 Latest Updates</h3>
<div class="owl-carousel owl-latest-carousel owl-theme">
<?php

//we want to show 10 latest sports posts in owl carousel
$latest_topic_posts = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 10,
));

if ($latest_topic_posts->have_posts()) :
    while ($latest_topic_posts->have_posts()) : $latest_topic_posts->the_post();
        ?>
        <div class="item">
            <?php the_post_thumbnail('medium', array('class' => 'card-img-top img-fluid')); ?>
            <div class="card-body">
                <a href="<?php the_permalink() ?>"><h5 class="card-title"><?php the_title(); ?></h5></a>                
            </div>
        </div>
        <?php
    endwhile;
endif; 
// Reset post data after custom query
wp_reset_postdata();
?>
</div>

