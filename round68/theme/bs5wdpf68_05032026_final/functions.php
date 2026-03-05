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


// ========================================
// NEWSLETTER SUBSCRIPTION FUNCTIONALITY
// ========================================

// Create custom database table for newsletter subscribers
function bs5wdpf68_create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        subscribed_date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(20) DEFAULT 'active' NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'bs5wdpf68_create_newsletter_table');

// Handle AJAX newsletter subscription
function bs5wdpf68_handle_newsletter_subscription() {
    // Verify nonce for security
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'newsletter_nonce')) {
        wp_send_json_error(['message' => 'Security check failed']);
        return;
    }

    // Get and sanitize email
    $email = sanitize_email($_POST['email']);

    // Validate email
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Please enter a valid email address']);
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    // Check if email already exists
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT email FROM $table_name WHERE email = %s",
        $email
    ));

    if ($existing) {
        wp_send_json_error(['message' => 'This email is already subscribed']);
        return;
    }

    // Insert new subscriber
    $result = $wpdb->insert(
        $table_name,
        [
            'email' => $email,
            'status' => 'active'
        ],
        ['%s', '%s']
    );

    if ($result) {
        // Send confirmation email (optional)
        $subject = 'Newsletter Subscription Confirmed';
        $message = "Thank you for subscribing to our newsletter!\n\nYou'll receive updates from " . get_bloginfo('name');
        wp_mail($email, $subject, $message);

        wp_send_json_success(['message' => 'Thank you for subscribing!']);
    } else {
        wp_send_json_error(['message' => 'Subscription failed. Please try again.']);
    }
}
add_action('wp_ajax_newsletter_subscribe', 'bs5wdpf68_handle_newsletter_subscription');
add_action('wp_ajax_nopriv_newsletter_subscribe', 'bs5wdpf68_handle_newsletter_subscription');

// Enqueue newsletter script
function bs5wdpf68_enqueue_newsletter_script() {
    wp_localize_script('bs5wdpf683_js', 'newsletterAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('newsletter_nonce')
    ]);
}
add_action('wp_enqueue_scripts', 'bs5wdpf68_enqueue_newsletter_script');

// Add admin menu for viewing subscribers
function bs5wdpf68_newsletter_admin_menu() {
    add_menu_page(
        'Newsletter Subscribers',
        'Newsletter',
        'manage_options',
        'newsletter-subscribers',
        'bs5wdpf68_newsletter_admin_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'bs5wdpf68_newsletter_admin_menu');

// Admin page to view subscribers
function bs5wdpf68_newsletter_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    // Handle delete action
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $wpdb->delete($table_name, ['id' => $id], ['%d']);
        echo '<div class="notice notice-success"><p>Subscriber deleted successfully.</p></div>';
    }
    
    // Handle export action
    if (isset($_GET['action']) && $_GET['action'] === 'export') {
        $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY subscribed_date DESC");
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="newsletter-subscribers-' . date('Y-m-d') . '.csv"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Email', 'Subscribed Date', 'Status']);
        
        foreach ($subscribers as $subscriber) {
            fputcsv($output, [
                $subscriber->id,
                $subscriber->email,
                $subscriber->subscribed_date,
                $subscriber->status
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY subscribed_date DESC");
    $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
    ?>
    <div class="wrap">
        <h1>Newsletter Subscribers</h1>
        <p>Total Active Subscribers: <strong><?php echo $total; ?></strong></p>
        
        <a href="?page=newsletter-subscribers&action=export" class="button button-primary" style="margin-bottom: 20px;">
            Export to CSV
        </a>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Subscribed Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($subscribers): ?>
                    <?php foreach ($subscribers as $subscriber): ?>
                        <tr>
                            <td><?php echo $subscriber->id; ?></td>
                            <td><?php echo esc_html($subscriber->email); ?></td>
                            <td><?php echo date('F j, Y g:i a', strtotime($subscriber->subscribed_date)); ?></td>
                            <td>
                                <span class="<?php echo $subscriber->status === 'active' ? 'status-active' : 'status-inactive'; ?>">
                                    <?php echo ucfirst($subscriber->status); ?>
                                </span>
                            </td>
                            <td>
                                <a href="?page=newsletter-subscribers&action=delete&id=<?php echo $subscriber->id; ?>" 
                                   class="button button-small"
                                   onclick="return confirm('Are you sure you want to delete this subscriber?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No subscribers yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <style>
        .status-active { color: #46b450; font-weight: bold; }
        .status-inactive { color: #dc3232; }
    </style>
    <?php
}
