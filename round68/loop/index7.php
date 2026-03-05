<?php 
// Display a random post in the header area (simulated)
echo '<h2>Header Random Post:</h2>';
$myPosts = new WP_Query( 'posts_per_page=1&orderby=rand' );
if ( $myPosts->have_posts() ) :
    while ( $myPosts->have_posts() ) : $myPosts->the_post();
        ?>
        <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
        <?php 
    endwhile;
    // VERY IMPORTANT: Reset Post Data after a custom WP_Query loop
    wp_reset_postdata(); 
endif;

echo '<hr>';

// Main Loop - should display as normal, unaffected by the custom query above
echo '<h2>Main Content Loop:</h2>';
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        ?>
        <article>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php the_excerpt(); ?>
        </article>
        <?php
    endwhile;
else :
    echo '<p>No main posts found.</p>';
endif;
?> 