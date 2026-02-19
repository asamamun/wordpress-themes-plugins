<?php
/**
 * Plugin Name: Gradient Animated Titles
 * Description: Adds gradient animation to post/page titles using the_title filter.
 * Version: 1.0
 * Author: ASA Al-Mamun
 * Author URI: https://github.com/asamamun
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Wrap title with a span
 */
add_filter( 'the_title', 'gat_gradient_title', 10, 2 );
add_filter('the_content', 'gat_gradient_content', 10, 2);
function gat_gradient_title( $title, $post_id ) {

    if ( is_admin() ) {
        return $title;
    }

    // Only affect main titles (not menus, widgets, etc.)
    if ( ! in_the_loop() || ! is_main_query() ) {
        return $title;
    }

    return '<span class="gat-gradient-title">' . esc_html( $title ) . '</span>';
}

function gat_gradient_content( $content ) {


    //return '<p class="gat-gradient-content">This article contains ' . str_word_count( strip_tags( $content ) ) . ' words. ' . ' </p><hr>' . $content;
    return '<p class="gat-gradient-content">This article contains ' . utf8_word_count( strip_tags( $content ) ) . ' words. ' . ' </p><hr>' . $content;
}

function utf8_word_count(string $text): int {
    preg_match_all('/\p{L}+/u', $text, $matches);
    return count($matches[0]);
}

/**
 * Enqueue styles
 */
add_action( 'wp_enqueue_scripts', 'gat_enqueue_styles' );
function gat_enqueue_styles() {
    wp_add_inline_style(
        'wp-block-library',
        '
        .gat-gradient-title {
            background: linear-gradient(90deg, #ff0080, #7928ca, #2afadf, #ff00cc, #ffff00);
            background-size: 600% 600%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gatGradient 6s ease infinite;
        }

        @keyframes gatGradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
            .gat-gradient-content {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            color: #333;
            text-align: center;
            margin-top: 10px;
        }
        '
    );
}
