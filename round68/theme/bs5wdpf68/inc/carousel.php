<?php
// Customizer fields for theme options
// Features: Carousel images, Social links, Google Analytics, Background settings

function wdpf68_customize_register($wp_customize) {
    
    
    
    
    
    // ========================================
    // 1. CAROUSEL SECTION
    // ========================================
    $wp_customize->add_section('wdpf68_carousel_section', array(
        'title'    => __('Carousel Settings', 'wdpf68'),
        'priority' => 30,
    ));
    //show carousel checkbox setting and control pls
    $wp_customize->add_setting('show_carousel', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('show_carousel', array(
        'label'    => __('Show Image Carousel', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'type'     => 'checkbox',
    ));

    //show post carousel checkbox setting and control pls
    $wp_customize->add_setting('show_post_carousel', array(
        'default'   => false,
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('show_post_carousel', array(
        'label'    => __('Show Post Carousel', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'type'     => 'checkbox',
    ));
    
    // Carousel Image 1
    $wp_customize->add_setting('carousel_image_1', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'carousel_image_1', array(
        'label'    => __('Carousel Image 1 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_1',
    )));
    
    // Carousel Image 2
    $wp_customize->add_setting('carousel_image_2', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'carousel_image_2', array(
        'label'    => __('Carousel Image 2 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_2',
    )));
    
    // Carousel Image 3
    $wp_customize->add_setting('carousel_image_3', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'carousel_image_3', array(
        'label'    => __('Carousel Image 3 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_3',
    )));
    
    // Carousel Image 4
    $wp_customize->add_setting('carousel_image_4', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'carousel_image_4', array(
        'label'    => __('Carousel Image 4 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_4',
    )));
    
    // Carousel Image 5
    $wp_customize->add_setting('carousel_image_5', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'carousel_image_5', array(
        'label'    => __('Carousel Image 5 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_5',
    )));
    
    
    // ========================================
    // 2. SOCIAL MEDIA SECTION
    // ========================================
    $wp_customize->add_section('wdpf68_social_section', array(
        'title'    => __('Social Media Links', 'wdpf68'),
        'priority' => 31,
    ));
    
    // Facebook
    $wp_customize->add_setting('social_facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_facebook', array(
        'label'    => __('Facebook URL', 'wdpf68'),
        'section'  => 'wdpf68_social_section',
        'type'     => 'url',
    ));
    
    // Twitter
    $wp_customize->add_setting('social_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_twitter', array(
        'label'    => __('Twitter URL', 'wdpf68'),
        'section'  => 'wdpf68_social_section',
        'type'     => 'url',
    ));
    
    // Instagram
    $wp_customize->add_setting('social_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_instagram', array(
        'label'    => __('Instagram URL', 'wdpf68'),
        'section'  => 'wdpf68_social_section',
        'type'     => 'url',
    ));
    
    // YouTube
    $wp_customize->add_setting('social_youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_youtube', array(
        'label'    => __('YouTube URL', 'wdpf68'),
        'section'  => 'wdpf68_social_section',
        'type'     => 'url',
    ));
    //add control dropdown type
    $wp_customize->add_setting('social_youtube_type', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('social_youtube_type', array(
        'label'    => __('YouTube Type', 'wdpf68'),
        'section'  => 'wdpf68_social_section',
        'type'     => 'select',
        'choices'  => array(
            'playlist' => 'Playlist',
            'video'    => 'Video',
        ),
    ));
    
    
    // ========================================
    // 3. GOOGLE ANALYTICS SECTION
    // ========================================
    $wp_customize->add_section('wdpf68_analytics_section', array(
        'title'    => __('Google Analytics', 'wdpf68'),
        'priority' => 32,
    ));
    
    $wp_customize->add_setting('google_analytics_code', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('google_analytics_code', array(
        'label'       => __('Google Analytics Code', 'wdpf68'),
        'description' => __('Paste your Google Analytics tracking code here', 'wdpf68'),
        'section'     => 'wdpf68_analytics_section',
        'type'        => 'textarea',
    ));
    
    
    // ========================================
    // 4. THEME STYLING SECTION
    // ========================================
    $wp_customize->add_section('wdpf68_styling_section', array(
        'title'    => __('Theme Styling', 'wdpf68'),
        'priority' => 33,
    ));
    
    // Background Image
    $wp_customize->add_setting('theme_background_image', array(
        'default'   => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'theme_background_image', array(
        'label'    => __('Background Image', 'wdpf68'),
        'section'  => 'wdpf68_styling_section',
        'settings' => 'theme_background_image',
    )));
    
    // Background Color
    $wp_customize->add_setting('theme_background_color', array(
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_background_color', array(
        'label'    => __('Background Color', 'wdpf68'),
        'section'  => 'wdpf68_styling_section',
        'settings' => 'theme_background_color',
    )));
    
    // Text Color
    $wp_customize->add_setting('theme_text_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'theme_text_color', array(
        'label'    => __('Text Color', 'wdpf68'),
        'section'  => 'wdpf68_styling_section',
        'settings' => 'theme_text_color',
    )));
}

add_action('customize_register', 'wdpf68_customize_register');


// ========================================
// OUTPUT CUSTOM STYLES
// ========================================
function wdpf68_customizer_css() {
    $bg_image = get_theme_mod('theme_background_image');
    $bg_color = get_theme_mod('theme_background_color', '#ffffff');
    $text_color = get_theme_mod('theme_text_color', '#333333');
    ?>
    <style type="text/css">
        body {
            <?php if ($bg_image) : ?>
            background-image: url(<?php echo esc_url($bg_image); ?>);
            background-size: cover;
            background-attachment: fixed;
            <?php endif; ?>
            background-color: <?php echo esc_attr($bg_color); ?>;
            color: <?php echo esc_attr($text_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'wdpf68_customizer_css');


// ========================================
// OUTPUT GOOGLE ANALYTICS
// ========================================
function wdpf68_google_analytics() {
    $analytics_code = get_theme_mod('google_analytics_code');
    if ($analytics_code) {
        echo $analytics_code;
    }
}
add_action('wp_head', 'wdpf68_google_analytics');


// ========================================
// HELPER FUNCTIONS TO GET VALUES
// ========================================

// Get carousel images
function wdpf68_get_carousel_images() {
    $images = array();
    for ($i = 1; $i <= 5; $i++) {
        $image = get_theme_mod('carousel_image_' . $i);
        if ($image) {
            $images[] = $image;
        }
    }
    return $images;
}

// Get social links
function wdpf68_get_social_links() {
    return array(
        'facebook'  => get_theme_mod('social_facebook'),
        'twitter'   => get_theme_mod('social_twitter'),
        'instagram' => get_theme_mod('social_instagram'),
        'youtube'   => get_theme_mod('social_youtube'),
    );
}

?>
