<?php 
if ( have_posts() ) :
    while ( have_posts() ) : 
        the_post();
?>
        <article>
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <?php the_content(); ?>

            <?php
            // Inner Query for Related Posts based on Tags
            $tags = wp_get_post_terms( get_the_ID() ); // Assuming get_the_ID() is available (inside main loop)

            if ( $tags ) {
                echo '<h3>Related Posts:</h3>';
                $tagIDs = array();
                foreach( $tags as $tag ) {
                    $tagIDs[] = $tag->term_id;
                }

                $args = array(
                    'tag__in' => $tagIDs,
                    'post__not_in' => array( get_the_ID() ), // Exclude current post
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1
                );

                $relatedPosts = new WP_Query( $args );

                if( $relatedPosts->have_posts() ) {
                    echo '<ul>';
                    while ( $relatedPosts->have_posts() ) : $relatedPosts->the_post();
                        ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                        <?php
                    endwhile;
                    echo '</ul>';
                    // Restore original Post Data
                    wp_reset_postdata();
                } else {
                    echo '<p>No related posts found.</p>';
                }
            }
            ?>
        </article>
<?php 
    endwhile;
    // Reset Post Data for the main query if it was modified
    wp_reset_postdata();
endif; 
?> 