<?php
function mytheme_register_menus() {
    register_nav_menus(array(
        'top-menu' => __('Top Menu', 'mytheme'),
        'social-menu' => __('Social Menu', 'mytheme'),
        'footer-menu' => __('Footer Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'mytheme_register_menus');