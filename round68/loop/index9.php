<?php 
// Example 1: Using global $authordata (inside the Loop)
if ( have_posts() ) :
   while ( have_posts() ) : 
      the_post(); 
      
      global $authordata;
      if ( isset( $authordata ) ) {
?>
          <article>
              <h2>Post Title: <?php the_title(); ?></h2>
              <p>Author (via $authordata): <?php echo $authordata->display_name; ?></p>
              <p>Author Email (via $authordata): <?php echo $authordata->user_email; ?></p>
              <?php the_content(); ?>
          </article>
<?php 
      } else {
          // Fallback if $authordata is not set (e.g., outside a proper loop context)
          echo '<p>Author data not available via global $authordata for this post. Using template tag instead:</p>';
?>
          <article>
              <h2>Post Title: <?php the_title(); ?></h2>
              <p>Author (via get_the_author_meta()): <?php echo get_the_author_meta( 'display_name' ); ?></p>
              <?php the_content(); ?>
          </article>
<?php
      }
   endwhile;
endif; 

echo '<hr>';

// Example 2: Using global $current_user (outside the Loop, checking if logged in)
global $current_user;
get_currentuserinfo(); // Deprecated in modern WP, but often used for quick access in older examples

if ( $current_user->ID != 0 ) { // Check if a user is logged in
    echo '<h2>Current Logged-in User:</h2>';
    echo '<p>Welcome, ' . $current_user->display_name . '!</p>';
    echo '<p>User Email: ' . $current_user->user_email . '</p>';
    echo '<p>User ID: ' . $current_user->ID . '</p>';
} else {
    echo '<h2>No User Logged In</h2>';
    echo '<p>Please log in to see current user information.</p>';
}
?> 