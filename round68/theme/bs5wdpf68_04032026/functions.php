<?php
//add all add_theme_support functions here
add_theme_support('title-tag');
add_theme_support('post-thumbnails');
add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
// add_theme_support('custom-logo');
add_theme_support( 'custom-logo', [
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
] );
// add_theme_support('custom-header');
add_theme_support( 'custom-header', [
    'width'       => 1200,
    'height'      => 280,
    'flex-height' => true,
] );
// add_theme_support('custom-background');
add_theme_support( 'custom-background', [
    'default-color' => 'ffffff',
    'default-image' => '',
] );
add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));
add_theme_support('automatic-feed-links');
add_theme_support('post-types', array('post', 'page', 'attachment'));
//add excerpt support
add_theme_support('post-excerpts');
add_image_size('carousel-1600x500', 1600, 500, true); // true = hard crop
require_once get_template_directory() .  '/inc/carousel.php';
require_once get_template_directory() .  '/inc/widget.php';
require_once get_template_directory() .  '/inc/bs5.php'; //add bootstrap 5.3
require_once get_template_directory() .  '/inc/menu.php'; //create menu locations
require_once get_template_directory() . '/inc/class-bootstrap-5-navwalker.php';

//we need to add theme dir's javascript and css to the footer
add_action('wp_enqueue_scripts', 'bs5wdpf68_add_scripts');
function bs5wdpf68_add_scripts() {
    // wp_enqueue_script('bs5wdpf68_js', get_template_directory_uri() . '/assets/jquery-4.0.0.min.js', array(), '1.0', true);
    //add https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js
    wp_enqueue_script('bs5wdpf68_js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '1.0', true);
    wp_enqueue_script('bs5wdpf682_js', get_template_directory_uri() . '/assets/owl.carousel.min.js', array(), '1.0', true);
    wp_enqueue_style('bs5wdpf68_css', get_template_directory_uri() . '/assets/assets/owl.carousel.min.css', array(), '1.0', 'all');
    wp_enqueue_style('bs5wdpf682_css', get_template_directory_uri() . '/assets/assets/owl.theme.default.min.css', array(), '1.0', 'all');
    wp_enqueue_script('bs5wdpf683_js', get_template_directory_uri() . '/assets/script.js', array(), '1.0', true);

}

