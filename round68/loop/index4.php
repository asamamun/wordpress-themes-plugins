<?php 
if ( have_posts() ) :
   while ( have_posts() ) : 
      the_post(); 
?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
              <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
              <div class="entry-meta">
                  Posted on <?php the_time('F jS, Y'); ?> by <?php the_author(); ?>
              </div>
          </header>

          <div class="entry-content">
              <?php the_excerpt(); ?>
          </div>

          <footer class="entry-footer">
              <?php the_category(', '); ?>
              <?php the_tags('<span class="tag-links">Tags: ', ', ', '</span>'); ?>
          </footer>
      </article>
<?php 
   endwhile;
endif; 
?> 