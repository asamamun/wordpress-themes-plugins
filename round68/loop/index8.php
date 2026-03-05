<?php 
if ( have_posts() ) :
   while ( have_posts() ) : 
      the_post(); 
      
      // Accessing post data via global $post variable
      global $post; 
?>
      <article>
          <h2>Global Post Example: <?php echo $post->post_title; ?></h2>
          <p>Post ID: <?php echo $post->ID; ?></p>
          <p>Post Date: <?php echo $post->post_date; ?></p>
          <h3>Unfiltered Content (from $post->post_content):</h3>
          <div><?php echo $post->post_content; ?></div>
          
          <h3>Filtered Content (from the_content() template tag):</h3>
          <div><?php the_content(); ?></div>
          
          <p>Notice the difference: `global $post->post_content` gives raw content, while `the_content()` applies filters (like shortcodes, paragraph formatting).</p>
      </article>
<?php 
   endwhile;
endif; 
?> 