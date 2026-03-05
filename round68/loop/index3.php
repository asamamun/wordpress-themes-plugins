<?php 
$myPosts = new WP_Query( 'posts_per_page=5' );
while ( $myPosts->have_posts() ) : $myPosts->the_post();
?> 
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php the_excerpt(); ?> 
<?php endwhile; ?> 