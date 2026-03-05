<?php 
if ( have_posts() ) :
   while ( have_posts() ) : 
      the_post(); 
      //loop content (template tags, html, etc)
      the_content();
   endwhile;
endif; 
?> 