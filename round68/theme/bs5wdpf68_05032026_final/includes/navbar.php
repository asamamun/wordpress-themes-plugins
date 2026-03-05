<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="<?php echo home_url(); ?>">
      <?php if (has_custom_logo()) : ?>
        <div class="site-logo">
          <?php the_custom_logo(); ?>
        </div>
      <?php else : ?>
        <?php bloginfo('name'); ?>
      <?php endif; ?>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

      <?php
      wp_nav_menu(array(
          'theme_location' => 'top-menu',
          'container'      => false,
          'menu_class'     => 'navbar-nav ms-auto',
          'depth'          => 2,
          'fallback_cb'    => false,
          // We will add custom walker here later
          'walker'         => new Bootstrap_5_Navwalker(),
      ));
      ?>

    </div>
  </div>
</nav>