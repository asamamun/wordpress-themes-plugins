<?php 
// Example of functions that work outside the main WordPress Loop.
// These are often used in sidebars, footers, or headers.

echo '<h1>Examples of Functions Outside The Loop</h1>';

// 1. wp_list_pages() - Displays a list of pages as links
echo '<h2>Page Navigation (wp_list_pages)</h2>';
echo '<ul>';
wp_list_pages( 'title_li=' );
echo '</ul>';
echo '<hr>';

// 2. wp_list_categories() - Displays a list of categories as links
echo '<h2>Categories (wp_list_categories)</h2>';
echo '<ul>';
wp_list_categories( 'title_li=&depth=4&orderby=name' );
echo '</ul>';
echo '<hr>';

// 3. wp_tag_cloud() - Displays a tag cloud
echo '<h2>Tag Cloud (wp_tag_cloud)</h2>';
echo '<div class="tagcloud">';
wp_tag_cloud();
echo '</div>';
echo '<hr>';

// 4. get_permalink() - Returns the permalink of a post (needs an ID)
echo '<h2>Get a Specific Permalink (get_permalink)</h2>';
$my_post_id = 1; // Change this to an existing post ID on your site
echo '<p>The permalink for post ID ' . $my_post_id . ' is: ' . get_permalink( $my_post_id ) . '</p>';
echo '<hr>';


// 5 & 6. next_posts_link() and previous_posts_link()
// These are typically placed after the main loop on an archive page.
echo '<h2>Post Navigation (previous_posts_link / next_posts_link)</h2>';

// Simulate a main loop
echo '<h3>Main Post Content Area (simulated)</h3>';
if ( have_posts() ) :
   while ( have_posts() ) : 
      the_post(); 
      ?>
      <article>
          <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <?php the_excerpt(); ?>
      </article>
      <?php
   endwhile;

   // Display navigation links AFTER the loop has finished
   echo '<div class="navigation">';
   echo '<div class="alignleft">' . previous_posts_link( '&laquo; Newer Posts' ) . '</div>';
   echo '<div class="alignright">' . next_posts_link( 'Older Posts &raquo;' ) . '</div>';
   echo '</div>';

endif; 

?> 