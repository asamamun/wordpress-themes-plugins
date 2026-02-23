<?php
/*
Plugin Name: GNSL Custom CSS Plugin
Plugin URI: http://proqoder.com/gnsl-custom-css-plugin
Description: Add custom CSS to your site
Version: 1.0
Author: Round 68 WDPF
Author URI: http://proqoder.com
Text Domain: custom-css
Domain Path: /languages
Text Domain: gnsl-custom-css-plugin
*/
add_action('wp_head', 'add_custom_css');
function add_custom_css() {
   ?>
    <style type="text/css"> 
    article.post h2.entry-title a {
        font-size: 20px;
        color: #FF8890;
        text-decoration: none;
        box-shadow: 0px 0px 5px #FF8890; 
        padding: 5px;
        border-radius: 5px; 
        transition: all 0.5s ease;
    } 
    article.post h2.entry-title a:hover { 
        font-size: 20px;
        color: #88ff00;
        text-decoration: none; 
        box-shadow: 0px 0px 5px #88ff00; 
        padding: 5px;
        border-radius: 5px; 
    } 
    
    </style>
   <?php
}
