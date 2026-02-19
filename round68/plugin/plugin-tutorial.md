# WordPress Plugin Functions Documentation

## register_activation_hook()

### Description
Registers a function to be called when a plugin is activated. This hook is triggered only when the plugin is activated, not on every page load.

### Syntax
```php
register_activation_hook( $file, $function )
```

### Parameters
- **$file** (string) - Path to the main plugin file inside the plugin directory. Should be the same as the value of `__FILE__` in the main plugin file.
- **$function** (callable) - The function to be run when the plugin is activated. Can be a function name, array for class methods, or closure.

### Return Value
None

### Usage Examples

#### Basic Usage
```php
// In your main plugin file
register_activation_hook( __FILE__, 'my_plugin_activate' );

function my_plugin_activate() {
    // Create database tables
    // Set default options
    // Flush rewrite rules
    error_log('Plugin activated successfully');
}
```

#### Using Class Method
```php
class MyPlugin {
    public static function activate() {
        // Activation code here
        self::create_tables();
        self::set_default_options();
    }
    
    private static function create_tables() {
        global $wpdb;
        // Database table creation code
    }
    
    private static function set_default_options() {
        add_option('my_plugin_version', '1.0.0');
        add_option('my_plugin_settings', array());
    }
}

register_activation_hook( __FILE__, array('MyPlugin', 'activate') );
```

#### Common Activation Tasks
```php
function my_plugin_activate() {
    // 1. Create custom database tables
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'my_plugin_data';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        name tinytext NOT NULL,
        text text NOT NULL,
        url varchar(55) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    // 2. Set default options
    add_option( 'my_plugin_db_version', '1.0' );
    add_option( 'my_plugin_settings', array(
        'option1' => 'default_value1',
        'option2' => 'default_value2'
    ));
    
    // 3. Create custom post types and flush rewrite rules
    my_plugin_create_post_types();
    flush_rewrite_rules();
    
    // 4. Schedule cron events
    if ( ! wp_next_scheduled( 'my_plugin_daily_event' ) ) {
        wp_schedule_event( time(), 'daily', 'my_plugin_daily_event' );
    }
}

register_activation_hook( __FILE__, 'my_plugin_activate' );
```

### Important Notes
- The activation hook is only called when the plugin is activated, not on every page load
- Use this for one-time setup tasks like creating database tables, setting default options, etc.
- Always check if data already exists before creating it to avoid conflicts
- The function should be defined before calling `register_activation_hook()`
- If your plugin creates custom post types or taxonomies, call `flush_rewrite_rules()` to update permalinks
- For database operations, use WordPress database functions and `dbDelta()` for table creation

### Related Functions
- `register_deactivation_hook()` - Runs when plugin is deactivated
- `register_uninstall_hook()` - Runs when plugin is uninstalled
- `add_action('init', 'function_name')` - Runs on every page load


---

## plugin_dir_path()

### Description
Gets the filesystem directory path (with trailing slash) for the plugin file passed in. Useful for including files or accessing plugin directories on the server.

### Syntax
```php
plugin_dir_path( $file )
```

### Parameters
- **$file** (string) - The full path and filename of the plugin file. Typically use `__FILE__` constant.

### Return Value
(string) - The filesystem directory path to the plugin with trailing slash.

### Usage Examples

#### Basic Usage
```php
// In your main plugin file
$plugin_path = plugin_dir_path( __FILE__ );
// Returns: /var/www/html/wp-content/plugins/my-plugin/

// Include a file from your plugin directory
require_once plugin_dir_path( __FILE__ ) . 'includes/class-helper.php';

// Load a template file
include plugin_dir_path( __FILE__ ) . 'templates/admin-page.php';
```

#### Organizing Plugin Files
```php
// Define constants for easy access
define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_INCLUDES', MY_PLUGIN_PATH . 'includes/' );
define( 'MY_PLUGIN_TEMPLATES', MY_PLUGIN_PATH . 'templates/' );

// Use throughout your plugin
require_once MY_PLUGIN_INCLUDES . 'functions.php';
require_once MY_PLUGIN_INCLUDES . 'class-admin.php';
```

#### Loading Multiple Files
```php
function my_plugin_load_dependencies() {
    $plugin_path = plugin_dir_path( __FILE__ );
    
    $files = array(
        'includes/functions.php',
        'includes/class-settings.php',
        'includes/class-frontend.php',
        'admin/class-admin.php'
    );
    
    foreach ( $files as $file ) {
        require_once $plugin_path . $file;
    }
}
```

### Important Notes
- Returns a filesystem path (e.g., `/var/www/html/wp-content/plugins/my-plugin/`)
- Always includes a trailing slash
- Use for server-side file operations (include, require, file_get_contents, etc.)
- Do NOT use for URLs in HTML (use `plugin_dir_url()` instead)

---

## plugins_url()

### Description
Retrieves the URL to the plugins directory or to a specific file within a plugin. Used for enqueueing scripts, styles, images, and other assets.

### Syntax
```php
plugins_url( $path, $plugin )
```

### Parameters
- **$path** (string) - Optional. Path relative to the plugins directory. Default empty string.
- **$plugin** (string) - Optional. The plugin file that you want to be relative to. Typically use `__FILE__`. Default empty string.

### Return Value
(string) - Plugins URL with optional path appended.

### Usage Examples

#### Basic Usage
```php
// Get the plugins directory URL
$plugins_url = plugins_url();
// Returns: http://example.com/wp-content/plugins

// Get URL to a specific file in your plugin
$css_url = plugins_url( 'css/style.css', __FILE__ );
// Returns: http://example.com/wp-content/plugins/my-plugin/css/style.css

// Get URL to an image
$image_url = plugins_url( 'images/logo.png', __FILE__ );
```

#### Enqueuing Scripts and Styles
```php
function my_plugin_enqueue_assets() {
    // Enqueue CSS
    wp_enqueue_style(
        'my-plugin-style',
        plugins_url( 'css/style.css', __FILE__ ),
        array(),
        '1.0.0'
    );
    
    // Enqueue JavaScript
    wp_enqueue_script(
        'my-plugin-script',
        plugins_url( 'js/script.js', __FILE__ ),
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_assets' );
```

#### Using in HTML Output
```php
function my_plugin_display_image() {
    $image_url = plugins_url( 'images/banner.jpg', __FILE__ );
    echo '<img src="' . esc_url( $image_url ) . '" alt="Banner">';
}
```

#### With Constants
```php
// Define in main plugin file
define( 'MY_PLUGIN_URL', plugins_url( '', __FILE__ ) );

// Use throughout your plugin
$script_url = MY_PLUGIN_URL . '/js/admin.js';
$style_url = MY_PLUGIN_URL . '/css/admin.css';
```

### Important Notes
- Returns a URL (e.g., `http://example.com/wp-content/plugins/my-plugin/`)
- Use for browser-accessible resources (CSS, JS, images, etc.)
- Always escape URLs with `esc_url()` when outputting in HTML
- The second parameter should be `__FILE__` to make paths relative to your plugin
- Works with SSL (returns https:// when appropriate)

---

## plugin_dir_url()

### Description
Gets the URL (with trailing slash) for the directory of a plugin file. Similar to `plugins_url()` but specifically for getting the plugin's directory URL.

### Syntax
```php
plugin_dir_url( $file )
```

### Parameters
- **$file** (string) - The full path and filename of the plugin file. Typically use `__FILE__` constant.

### Return Value
(string) - The URL to the directory of the plugin with trailing slash.

### Usage Examples

#### Basic Usage
```php
// In your main plugin file
$plugin_url = plugin_dir_url( __FILE__ );
// Returns: http://example.com/wp-content/plugins/my-plugin/

// Build URLs to assets
$css_url = plugin_dir_url( __FILE__ ) . 'css/style.css';
$js_url = plugin_dir_url( __FILE__ ) . 'js/script.js';
$image_url = plugin_dir_url( __FILE__ ) . 'images/icon.png';
```

#### Define Constants
```php
// In main plugin file
define( 'MY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MY_PLUGIN_ASSETS_URL', MY_PLUGIN_URL . 'assets/' );
define( 'MY_PLUGIN_CSS_URL', MY_PLUGIN_URL . 'css/' );
define( 'MY_PLUGIN_JS_URL', MY_PLUGIN_URL . 'js/' );

// Use in other files
wp_enqueue_style( 'my-style', MY_PLUGIN_CSS_URL . 'style.css' );
wp_enqueue_script( 'my-script', MY_PLUGIN_JS_URL . 'script.js' );
```

#### Enqueuing Assets
```php
function my_plugin_register_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );
    
    // Register styles
    wp_register_style(
        'my-plugin-admin',
        $plugin_url . 'admin/css/admin.css',
        array(),
        '1.0.0'
    );
    
    // Register scripts
    wp_register_script(
        'my-plugin-admin',
        $plugin_url . 'admin/js/admin.js',
        array( 'jquery' ),
        '1.0.0',
        true
    );
}
add_action( 'admin_init', 'my_plugin_register_assets' );
```

#### AJAX URL
```php
function my_plugin_localize_script() {
    wp_localize_script( 'my-plugin-script', 'myPluginData', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'pluginUrl' => plugin_dir_url( __FILE__ ),
        'nonce' => wp_create_nonce( 'my-plugin-nonce' )
    ));
}
```

### Important Notes
- Returns a URL (e.g., `http://example.com/wp-content/plugins/my-plugin/`)
- Always includes a trailing slash
- Use for browser-accessible resources (CSS, JS, images, fonts, etc.)
- More specific than `plugins_url()` - directly gets the plugin directory URL
- Works with SSL (returns https:// when appropriate)
- Always escape with `esc_url()` when outputting in HTML

---

## Comparison: Path vs URL Functions

### When to Use Each

| Function | Returns | Use For | Example |
|----------|---------|---------|---------|
| `plugin_dir_path()` | Filesystem path | Server-side file operations (include, require) | `/var/www/html/wp-content/plugins/my-plugin/` |
| `plugin_dir_url()` | URL with trailing slash | Building URLs to plugin assets | `http://example.com/wp-content/plugins/my-plugin/` |
| `plugins_url()` | URL with optional path | Direct URL to specific file | `http://example.com/wp-content/plugins/my-plugin/css/style.css` |

### Quick Reference Example
```php
// In your main plugin file

// For including PHP files (server-side)
require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';

// For asset URLs (browser-side) - Method 1
wp_enqueue_style( 'my-style', plugin_dir_url( __FILE__ ) . 'css/style.css' );

// For asset URLs (browser-side) - Method 2
wp_enqueue_script( 'my-script', plugins_url( 'js/script.js', __FILE__ ) );

// Both methods work for URLs, choose based on preference
// plugin_dir_url() gives you the directory, you append the file
// plugins_url() takes the file path as first parameter
```
