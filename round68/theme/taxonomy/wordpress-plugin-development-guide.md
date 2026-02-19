# WordPress Plugin Development Guide

A comprehensive guide to creating professional WordPress plugins following WordPress coding standards and best practices.

## Table of Contents
1. [Plugin Basics](#plugin-basics)
2. [Plugin Structure](#plugin-structure)
3. [Plugin Header](#plugin-header)
4. [Hooks and Actions](#hooks-and-actions)
5. [Database Operations](#database-operations)
6. [Admin Interface](#admin-interface)
7. [Security Best Practices](#security-best-practices)
8. [Internationalization](#internationalization)
9. [Plugin Testing](#plugin-testing)
10. [Deployment and Distribution](#deployment-and-distribution)

## Plugin Basics

### What is a WordPress Plugin?
A WordPress plugin is a collection of PHP files that add functionality to WordPress without modifying core files. Plugins can:
- Add new features
- Modify existing functionality
- Create custom post types and taxonomies
- Add shortcodes
- Integrate with third-party services

### Plugin File Structure
```
my-plugin/
├── my-plugin.php          # Main plugin file
├── includes/              # Additional PHP files
│   ├── class-core.php
│   ├── class-admin.php
│   └── class-frontend.php
├── admin/                 # Admin-specific files
│   ├── css/
│   ├── js/
│   └── views/
├── public/                # Frontend files
│   ├── css/
│   ├── js/
│   └── views/
├── languages/             # Translation files
├── assets/                # Images, icons
├── uninstall.php          # Cleanup on uninstall
├── readme.txt             # Plugin information
└── index.php              # Security file
```

## Plugin Structure

### Basic Plugin Example
```php
<?php
/**
 * Plugin Name: My Custom Plugin
 * Plugin URI: https://example.com/my-plugin
 * Description: A brief description of the plugin.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL-2.0-or-later
 * Text Domain: my-plugin
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('MY_PLUGIN_VERSION', '1.0.0');
define('MY_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('MY_PLUGIN_URL', plugin_dir_url(__FILE__));

// Main plugin class
class My_Plugin {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }
    
    private function load_dependencies() {
        require_once MY_PLUGIN_PATH . 'includes/class-core.php';
        require_once MY_PLUGIN_PATH . 'includes/class-admin.php';
        require_once MY_PLUGIN_PATH . 'includes/class-frontend.php';
    }
    
    private function define_admin_hooks() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    private function define_public_hooks() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_public_styles'));
        add_shortcode('my_shortcode', array($this, 'my_shortcode_handler'));
    }
    
    public function enqueue_admin_styles() {
        wp_enqueue_style('my-plugin-admin', MY_PLUGIN_URL . 'admin/css/admin.css', array(), MY_PLUGIN_VERSION);
        wp_enqueue_script('my-plugin-admin', MY_PLUGIN_URL . 'admin/js/admin.js', array('jquery'), MY_PLUGIN_VERSION, true);
    }
    
    public function enqueue_public_styles() {
        wp_enqueue_style('my-plugin-public', MY_PLUGIN_URL . 'public/css/public.css', array(), MY_PLUGIN_VERSION);
        wp_enqueue_script('my-plugin-public', MY_PLUGIN_URL . 'public/js/public.js', array('jquery'), MY_PLUGIN_VERSION, true);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            __('My Plugin', 'my-plugin'),
            __('My Plugin', 'my-plugin'),
            'manage_options',
            'my-plugin',
            array($this, 'admin_page_callback'),
            'dashicons-admin-generic',
            30
        );
    }
    
    public function admin_page_callback() {
        include MY_PLUGIN_PATH . 'admin/views/admin-page.php';
    }
    
    public function my_shortcode_handler($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Default Title'
        ), $atts, 'my_shortcode');
        
        ob_start();
        include MY_PLUGIN_PATH . 'public/views/shortcode-template.php';
        return ob_get_clean();
    }
}

// Initialize the plugin
function run_my_plugin() {
    return My_Plugin::get_instance();
}
run_my_plugin();
```

## Plugin Header

### Required Header Fields
```php
<?php
/**
 * Plugin Name: Your Plugin Name
 * Plugin URI: https://yourwebsite.com/plugin-name
 * Description: Brief description of what your plugin does.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * License: GPL-2.0-or-later
 * Text Domain: your-plugin-slug
 * Domain Path: /languages
 */
```

### Optional Header Fields
```php
 * Requires at least: 5.0
 * Requires PHP: 7.0
 * Tested up to: 6.0
 * Stable tag: 1.0.0
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
```

## Hooks and Actions

### Common WordPress Hooks

#### Action Hooks
```php
// Initialization
add_action('init', 'my_init_function');
add_action('admin_init', 'my_admin_init_function');

// Enqueuing scripts and styles
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
add_action('admin_enqueue_scripts', 'my_admin_enqueue_scripts');

// Admin menu
add_action('admin_menu', 'my_add_admin_menu');

// User actions
add_action('wp_login', 'my_user_login_function');
add_action('user_register', 'my_user_register_function');

// Content hooks
add_action('the_content', 'my_content_filter');
add_action('wp_head', 'my_wp_head_function');
add_action('wp_footer', 'my_wp_footer_function');
```

#### Filter Hooks
```php
// Content modification
add_filter('the_content', 'my_content_filter');
add_filter('the_title', 'my_title_filter');

// Excerpt customization
add_filter('excerpt_length', 'my_excerpt_length');
add_filter('excerpt_more', 'my_excerpt_more');

// URL rewriting
add_filter('post_link', 'my_custom_post_link');
add_filter('term_link', 'my_custom_term_link');
```

### Custom Hooks
```php
// Create custom action
do_action('my_plugin_before_processing', $data);

// Hook into custom action
add_action('my_plugin_before_processing', 'my_custom_function');

// Create custom filter
$value = apply_filters('my_plugin_modify_value', $original_value);

// Hook into custom filter
add_filter('my_plugin_modify_value', 'my_value_modifier');
```

## Database Operations

### Creating Custom Tables
```php
function my_plugin_create_tables() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'my_plugin_table';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        data text NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        KEY user_id (user_id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'my_plugin_create_tables');
```

### Database Queries
```php
global $wpdb;

// Insert data
$wpdb->insert(
    $wpdb->prefix . 'my_plugin_table',
    array(
        'user_id' => get_current_user_id(),
        'data' => serialize($data_array)
    ),
    array('%d', '%s')
);

// Update data
$wpdb->update(
    $wpdb->prefix . 'my_plugin_table',
    array('data' => serialize($updated_data)),
    array('id' => $record_id),
    array('%s'),
    array('%d')
);

// Select data
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}my_plugin_table WHERE user_id = %d",
        get_current_user_id()
    )
);

// Delete data
$wpdb->delete(
    $wpdb->prefix . 'my_plugin_table',
    array('id' => $record_id),
    array('%d')
);
```

### Using WordPress Options API
```php
// Add option
add_option('my_plugin_setting', 'default_value');

// Update option
update_option('my_plugin_setting', 'new_value');

// Get option
$value = get_option('my_plugin_setting', 'default_value');

// Delete option
delete_option('my_plugin_setting');
```

## Admin Interface

### Admin Menu Creation
```php
function my_plugin_admin_menu() {
    // Main menu page
    add_menu_page(
        __('My Plugin Dashboard', 'my-plugin'),  // Page title
        __('My Plugin', 'my-plugin'),            // Menu title
        'manage_options',                        // Capability
        'my-plugin',                             // Menu slug
        'my_plugin_admin_page',                  // Callback function
        'dashicons-admin-generic',               // Icon
        30                                       // Position
    );
    
    // Submenu pages
    add_submenu_page(
        'my-plugin',                             // Parent slug
        __('Settings', 'my-plugin'),             // Page title
        __('Settings', 'my-plugin'),             // Menu title
        'manage_options',                        // Capability
        'my-plugin-settings',                    // Menu slug
        'my_plugin_settings_page'                // Callback function
    );
}
add_action('admin_menu', 'my_plugin_admin_menu');
```

### Settings API Implementation
```php
function my_plugin_settings_init() {
    // Register settings
    register_setting('my_plugin_settings', 'my_plugin_options');
    
    // Add settings section
    add_settings_section(
        'my_plugin_section',
        __('Plugin Settings', 'my-plugin'),
        'my_plugin_section_callback',
        'my-plugin-settings'
    );
    
    // Add settings field
    add_settings_field(
        'my_plugin_field',
        __('Custom Field', 'my-plugin'),
        'my_plugin_field_callback',
        'my-plugin-settings',
        'my_plugin_section'
    );
}
add_action('admin_init', 'my_plugin_settings_init');

function my_plugin_section_callback() {
    echo '<p>' . __('Configure your plugin settings here.', 'my-plugin') . '</p>';
}

function my_plugin_field_callback() {
    $options = get_option('my_plugin_options');
    $value = isset($options['my_plugin_field']) ? $options['my_plugin_field'] : '';
    echo '<input type="text" name="my_plugin_options[my_plugin_field]" value="' . esc_attr($value) . '">';
}
```

### Admin Notices
```php
function my_plugin_admin_notices() {
    if (isset($_GET['my-plugin-message'])) {
        $message = sanitize_text_field($_GET['my-plugin-message']);
        $class = 'notice notice-success is-dismissible';
        
        printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
    }
}
add_action('admin_notices', 'my_plugin_admin_notices');
```

## Security Best Practices

### Input Sanitization
```php
// Sanitize text input
$sanitized_text = sanitize_text_field($_POST['text_field']);

// Sanitize textarea
$sanitized_textarea = sanitize_textarea_field($_POST['textarea_field']);

// Sanitize email
$sanitized_email = sanitize_email($_POST['email_field']);

// Sanitize URL
$sanitized_url = esc_url_raw($_POST['url_field']);

// Sanitize integer
$sanitized_int = absint($_POST['number_field']);

// Sanitize key (for array keys)
$sanitized_key = sanitize_key($_POST['key_field']);
```

### Output Escaping
```php
// Escape HTML content
echo esc_html($user_content);

// Escape HTML attributes
echo esc_attr($attribute_value);

// Escape URLs
echo esc_url($url);

// Escape JavaScript
echo esc_js($javascript);

// Escape textarea content
echo esc_textarea($content);
```

### Nonce Verification
```php
// Add nonce field to form
wp_nonce_field('my_plugin_action', 'my_plugin_nonce');

// Verify nonce
if (!isset($_POST['my_plugin_nonce']) || !wp_verify_nonce($_POST['my_plugin_nonce'], 'my_plugin_action')) {
    wp_die(__('Security check failed', 'my-plugin'));
}

// Check user capabilities
if (!current_user_can('manage_options')) {
    wp_die(__('Insufficient permissions', 'my-plugin'));
}
```

### SQL Injection Prevention
```php
global $wpdb;

// Use prepare() for dynamic queries
$user_id = absint($_GET['user_id']);
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}my_table WHERE user_id = %d",
        $user_id
    )
);

// Use direct queries for static queries
$wpdb->query("DELETE FROM {$wpdb->prefix}my_table WHERE id = 5");
```

## Internationalization

### Text Domain Setup
```php
// Load plugin textdomain
function my_plugin_load_textdomain() {
    load_plugin_textdomain(
        'my-plugin',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages/'
    );
}
add_action('plugins_loaded', 'my_plugin_load_textdomain');
```

### String Translation
```php
// Simple translation
__('Hello World', 'my-plugin');

// Translation with context
_x('Post', 'noun', 'my-plugin');
_x('Post', 'verb', 'my-plugin');

// Translation with placeholder
sprintf(__('Hello %s', 'my-plugin'), $name);

// Plural translation
_n('1 item', '%s items', $count, 'my-plugin');

// Plural translation with context
_nx('1 post', '%s posts', $count, 'noun', 'my-plugin');
```

### Creating Language Files
1. Use `wp i18n make-pot` command to generate .pot file
2. Create .po files for each language
3. Compile .po files to .mo files
4. Place files in `/languages/` directory

## Plugin Testing

### Unit Testing with WP-CLI
```bash
# Install WP-CLI testing framework
wp scaffold plugin-tests my-plugin

# Run tests
phpunit
```

### Basic Test Example
```php
<?php
class My_Plugin_Test extends WP_UnitTestCase {
    
    public function test_plugin_activation() {
        $this->assertTrue(is_plugin_active('my-plugin/my-plugin.php'));
    }
    
    public function test_shortcode_exists() {
        $this->assertTrue(shortcode_exists('my_shortcode'));
    }
    
    public function test_database_table_exists() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'my_plugin_table';
        $this->assertTrue($wpdb->get_var("SHOW TABLES LIKE '$table_name'") === $table_name);
    }
}
```

### Manual Testing Checklist
- [ ] Plugin activates without errors
- [ ] All admin pages load correctly
- [ ] Shortcodes work as expected
- [ ] Database operations function properly
- [ ] User permissions are handled correctly
- [ ] Plugin works with different themes
- [ ] Plugin is compatible with major plugins
- [ ] Uninstall process removes all data

## Deployment and Distribution

### Plugin Readme.txt
```txt
=== Plugin Name ===
Contributors: yourusername
Tags: tag1, tag2, tag3
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Brief description of your plugin.

== Description ==

Detailed description of your plugin's features and functionality.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure the plugin settings through the 'My Plugin' menu

== Frequently Asked Questions ==

= How do I use this plugin? =
Instructions for using the plugin.

== Screenshots ==

1. Description of screenshot 1
2. Description of screenshot 2

== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release of the plugin.
```

### Version Control Best Practices
```bash
# .gitignore for WordPress plugins
.DS_Store
Thumbs.db
*.log
/node_modules/
/vendor/
*.pot
*.mo
*.zip
```

### Deployment Process
1. Update version number in main plugin file
2. Update changelog in readme.txt
3. Test thoroughly in staging environment
4. Create Git tag for release
5. Package plugin files
6. Submit to WordPress.org (if applicable)
7. Update documentation

## Performance Optimization

### Efficient Code Practices
```php
// Cache expensive operations
function my_plugin_get_expensive_data() {
    $cache_key = 'my_plugin_expensive_data';
    $data = wp_cache_get($cache_key);
    
    if (false === $data) {
        $data = perform_expensive_operation();
        wp_cache_set($cache_key, $data, '', 3600); // Cache for 1 hour
    }
    
    return $data;
}

// Defer non-critical operations
add_action('shutdown', 'my_plugin_background_process');

// Minimize database queries
function my_plugin_optimized_query() {
    // Use transients for frequently accessed data
    $transient_key = 'my_plugin_data';
    $data = get_transient($transient_key);
    
    if (false === $data) {
        $data = get_data_from_database();
        set_transient($transient_key, $data, 12 * HOUR_IN_SECONDS);
    }
    
    return $data;
}
```

## Common Plugin Patterns

### Singleton Pattern
```php
class My_Plugin_Singleton {
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        // Private constructor
    }
}
```

### Factory Pattern
```php
class My_Plugin_Factory {
    public static function create($type) {
        switch ($type) {
            case 'admin':
                return new My_Plugin_Admin();
            case 'frontend':
                return new My_Plugin_Frontend();
            default:
                return new My_Plugin_Core();
        }
    }
}
```

### Observer Pattern
```php
class My_Plugin_Observer {
    private $observers = array();
    
    public function attach($observer) {
        $this->observers[] = $observer;
    }
    
    public function notify($event, $data) {
        foreach ($this->observers as $observer) {
            $observer->handle($event, $data);
        }
    }
}
```

## Troubleshooting

### Debugging Techniques
```php
// Enable WordPress debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Custom error logging
function my_plugin_log($message, $data = null) {
    if (WP_DEBUG) {
        error_log('My Plugin: ' . $message . ' - ' . print_r($data, true));
    }
}

// Debug hooks
function my_plugin_debug_hooks() {
    global $wp_filter;
    my_plugin_log('Active hooks', array_keys($wp_filter));
}
```

### Common Issues and Solutions

1. **Plugin not activating**
   - Check for PHP syntax errors
   - Verify all required files exist
   - Check file permissions

2. **White screen of death**
   - Enable WP_DEBUG
   - Check PHP error logs
   - Disable other plugins temporarily

3. **Database errors**
   - Verify table structure
   - Check SQL syntax
   - Ensure proper escaping

4. **Security vulnerabilities**
   - Sanitize all inputs
   - Escape all outputs
   - Verify nonces and capabilities

## Resources

### Official Documentation
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [Plugin Review Guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/)

### Development Tools
- [WP-CLI](https://wp-cli.org/)
- [WordPress Coding Standards for PHP_CodeSniffer](https://github.com/WordPress/WordPress-Coding-Standards)
- [Plugin Check (PCP)](https://wordpress.org/plugins/plugin-check/)

### Testing Frameworks
- [WordPress PHPUnit](https://github.com/WordPress/wordpress-develop/tree/master/tests/phpunit)
- [Codeception](https://codeception.com/for/wordpress)

---

*This guide provides a comprehensive foundation for WordPress plugin development. Always refer to the official WordPress documentation for the most current information and best practices.*