<?php while (have_posts()) : the_post(); ?>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<p><?php the_excerpt(); ?></p>
<div class="read-more"><a href="<?php the_permalink(); ?>">Read More</a></div>
<?php endwhile; ?>
