<?php 
// Example 1: Display posts from a specific category, ordered by title
$args = array(
    'posts_per_page' => 3, // Display 3 posts
    'category_name'  => 'news', // Assuming a category named 'news' exists
    'orderby'        => 'title',
    'order'          => 'ASC'
);

$my_query = new WP_Query( $args );

if ( $my_query->have_posts() ) :
    while ( $my_query->have_posts() ) : $my_query->the_post();
?>
        <article>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div>
            <small>Category: <?php the_category(', '); ?></small>
        </article>
<?php
    endwhile;
    // Reset Post Data to restore the original $post global
    wp_reset_postdata();
endif;
?> 