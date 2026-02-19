<?php 
/* 
Plugin Name: Random Content Ads 
Plugin URI: http://proqoder.com/wordpress-plugins/random-content-ads 
Description: Randomly display ads in your content after the content 
Version: 1.0
Author: GNSL Round 68
Author URI: http://proqoder.com 
Text Domain: random-content-ads
License: GPLv2 
*/ 

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RCAD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RCAD_PLUGIN_PATH', dirname( __FILE__ ) . '/' );
add_filter('the_content', 'display_ads');

function display_ads($content) {
    // Use file system path for glob() to find files
    $ads_directory = RCAD_PLUGIN_PATH . 'ads/';
    
    // Get all image file names in array
    $ads_files = glob($ads_directory . "*.{jpg,png,gif,jpeg,webp}", GLOB_BRACE);
    
    // If no ads found, return content unchanged
    if (empty($ads_files)) {
        error_log('Content Ads: No ad images found in ' . $ads_directory);
        return $content;
    }
    
    shuffle($ads_files);
    
    // Convert file path to URL for display
    $ad_file = basename($ads_files[0]);
    $ad_url = RCAD_PLUGIN_URL . 'ads/' . $ad_file;
    
    // Debug output (remove in production)
    // var_dump($ads_files);
    // error_log('Selected ad: ' . $ad_url);
    
    // Display the image
    return $content . '<div class="ads"><img style="display: block; margin: 0 auto;" width="100%" height="auto" src="' . $ad_url . '" alt="Advertisement" /></div>';
}
