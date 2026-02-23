# WordPress Hooks - Complete Guide for Students

## Table of Contents
1. [What are Hooks?](#what-are-hooks)
2. [Action Hooks](#action-hooks)
3. [Filter Hooks](#filter-hooks)
4. [Common Hooks](#common-hooks)
5. [Best Practices](#best-practices)

---

## What are Hooks?

Hooks are WordPress's way of allowing you to "hook into" the core functionality and modify or add features without changing core files. Think of hooks as events that happen at specific points during WordPress execution.

### Two Types of Hooks

1. **Action Hooks** - Do something at a specific point (add functionality)
2. **Filter Hooks** - Modify data before it's used or displayed

---

## Action Hooks

### What are Action Hooks?

Action hooks allow you to execute custom code at specific points during WordPress execution. They don't return anything; they just perform actions.

### Core Action Functions

#### add_action()

**Definition:** Hooks a function to a specific action.

**Syntax:**
```php
add_action( $hook_name, $callback, $priority, $accepted_args )
```

**Parameters:**
- `$hook_name` (string) - Name of the action hook
- `$callback` (callable) - Function to execute
- `$priority` (int) - Execution order (default: 10, lower = earlier)
- `$accepted_args` (int) - Number of arguments the function accepts (default: 1)

**Return:** (true) Always returns true

---

#### do_action()

**Definition:** Executes all functions hooked to a specific action.

**Syntax:**
```php
do_action( $hook_name, ...$args )
```

**Parameters:**
- `$hook_name` (string) - Name of the action
- `$args` (mixed) - Additional arguments passed to hooked functions

**Return:** void

---

#### remove_action()

**Definition:** Removes a function from a specified action hook.

**Syntax:**
```php
remove_action( $hook_name, $callback, $priority )
```

**Parameters:**
- `$hook_name` (string) - Action hook name
- `$callback` (callable) - Function to remove
- `$priority` (int) - Priority of the function (must match add_action)

**Return:** (bool) True on success, false on failure

---

#### has_action()

**Definition:** Checks if any action has been registered for a hook.

**Syntax:**
```php
has_action( $hook_name, $callback )
```

**Parameters:**
- `$hook_name` (string) - Action hook name
- `$callback` (callable|false) - Optional. Specific function to check

**Return:** (bool|int) False if no actions, priority number if found

---

### Action Hook Examples

#### Example 1: Basic Action Hook

```php
// Hook into WordPress initialization
function my_plugin_init() {
    // Code runs when WordPress initializes
    error_log( 'My plugin initialized!' );
}
add_action( 'init', 'my_plugin_init' );
```

#### Example 2: Action with Priority

```php
// Run early (priority 5)
function my_early_function() {
    echo 'I run first!';
}
add_action( 'wp_head', 'my_early_function', 5 );

// Run late (priority 20)
function my_late_function() {
    echo 'I run last!';
}
add_action( 'wp_head', 'my_late_function', 20 );
```

#### Example 3: Action with Arguments

```php
// Hook that receives arguments
function log_post_save( $post_id, $post, $update ) {
    if ( $update ) {
        error_log( "Post {$post_id} was updated" );
    } else {
        error_log( "New post {$post_id} was created" );
    }
}
// Accept 3 arguments
add_action( 'save_post', 'log_post_save', 10, 3 );
```

#### Example 4: Enqueue Scripts and Styles

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

#### Example 5: Add Admin Menu

```php
function my_plugin_add_menu() {
    add_menu_page(
        'My Plugin Settings',           // Page title
        'My Plugin',                    // Menu title
        'manage_options',               // Capability
        'my-plugin',                    // Menu slug
        'my_plugin_settings_page',      // Callback function
        'dashicons-admin-generic',      // Icon
        30                              // Position
    );
}
add_action( 'admin_menu', 'my_plugin_add_menu' );

function my_plugin_settings_page() {
    echo '<h1>My Plugin Settings</h1>';
}
```

#### Example 6: Custom Action Hook

```php
// Create your own action hook
function my_plugin_process_data() {
    // Do some processing
    $data = array( 'status' => 'success' );
    
    // Allow other plugins to hook in
    do_action( 'my_plugin_after_process', $data );
}

// Other developers can hook into your action
function log_my_plugin_process( $data ) {
    error_log( 'Process completed: ' . print_r( $data, true ) );
}
add_action( 'my_plugin_after_process', 'log_my_plugin_process' );
```

#### Example 7: Remove Action

```php
// Remove WordPress version from head
function remove_wp_version() {
    remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'remove_wp_version' );
```

#### Example 8: AJAX Handler

```php
// AJAX handler for logged-in users
function my_plugin_ajax_handler() {
    // Verify nonce
    check_ajax_referer( 'my_plugin_nonce', 'nonce' );
    
    // Process request
    $result = array(
        'success' => true,
        'message' => 'Data processed successfully'
    );
    
    wp_send_json_success( $result );
}
add_action( 'wp_ajax_my_plugin_action', 'my_plugin_ajax_handler' );

// AJAX handler for non-logged-in users
add_action( 'wp_ajax_nopriv_my_plugin_action', 'my_plugin_ajax_handler' );
```

---

## Filter Hooks

### What are Filter Hooks?

Filter hooks allow you to modify data before it's used or displayed. They always return a value.

### Core Filter Functions

#### add_filter()

**Definition:** Hooks a function to a specific filter.

**Syntax:**
```php
add_filter( $hook_name, $callback, $priority, $accepted_args )
```

**Parameters:**
- `$hook_name` (string) - Name of the filter hook
- `$callback` (callable) - Function to execute
- `$priority` (int) - Execution order (default: 10)
- `$accepted_args` (int) - Number of arguments (default: 1)

**Return:** (true) Always returns true

---

#### apply_filters()

**Definition:** Calls all functions hooked to a filter and returns the modified value.

**Syntax:**
```php
apply_filters( $hook_name, $value, ...$args )
```

**Parameters:**
- `$hook_name` (string) - Name of the filter
- `$value` (mixed) - Value to filter
- `$args` (mixed) - Additional arguments

**Return:** (mixed) Filtered value

---

#### remove_filter()

**Definition:** Removes a function from a specified filter hook.

**Syntax:**
```php
remove_filter( $hook_name, $callback, $priority )
```

**Parameters:**
- `$hook_name` (string) - Filter hook name
- `$callback` (callable) - Function to remove
- `$priority` (int) - Priority (must match add_filter)

**Return:** (bool) True on success, false on failure

---

#### has_filter()

**Definition:** Checks if any filter has been registered for a hook.

**Syntax:**
```php
has_filter( $hook_name, $callback )
```

**Parameters:**
- `$hook_name` (string) - Filter hook name
- `$callback` (callable|false) - Optional. Specific function to check

**Return:** (bool|int) False if no filters, priority number if found

---

### Filter Hook Examples

#### Example 1: Basic Filter Hook

```php
// Modify post content
function add_signature_to_content( $content ) {
    $signature = '<p><em>Thanks for reading!</em></p>';
    return $content . $signature;
}
add_filter( 'the_content', 'add_signature_to_content' );
```

#### Example 2: Filter with Multiple Arguments

```php
// Modify post title based on post type
function modify_post_title( $title, $post_id ) {
    $post_type = get_post_type( $post_id );
    
    if ( $post_type === 'product' ) {
        return '[Product] ' . $title;
    }
    
    return $title;
}
add_filter( 'the_title', 'modify_post_title', 10, 2 );
```

#### Example 3: Modify Excerpt Length

```php
// Change excerpt length to 50 words
function custom_excerpt_length( $length ) {
    return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length' );

// Change excerpt "more" text
function custom_excerpt_more( $more ) {
    return '... <a href="' . get_permalink() . '">Read More</a>';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );
```

#### Example 4: Add Custom Body Class

```php
// Add custom class to body tag
function add_custom_body_class( $classes ) {
    if ( is_page( 'about' ) ) {
        $classes[] = 'about-page';
    }
    
    if ( is_user_logged_in() ) {
        $classes[] = 'logged-in-user';
    }
    
    return $classes;
}
add_filter( 'body_class', 'add_custom_body_class' );
```

#### Example 5: Modify Query

```php
// Modify main query to show 20 posts per page
function modify_posts_per_page( $query ) {
    if ( ! is_admin() && $query->is_main_query() && is_home() ) {
        $query->set( 'posts_per_page', 20 );
    }
}
add_action( 'pre_get_posts', 'modify_posts_per_page' );
```

#### Example 6: Custom Filter Hook

```php
// Create your own filter
function my_plugin_get_price( $product_id ) {
    $price = 100; // Get price from database
    
    // Allow other plugins to modify the price
    $price = apply_filters( 'my_plugin_product_price', $price, $product_id );
    
    return $price;
}

// Other developers can modify the price
function apply_discount_to_price( $price, $product_id ) {
    // Apply 10% discount
    return $price * 0.9;
}
add_filter( 'my_plugin_product_price', 'apply_discount_to_price', 10, 2 );
```

#### Example 7: Sanitize Custom Field

```php
// Add custom sanitization
function sanitize_phone_number( $value ) {
    // Remove all non-numeric characters
    return preg_replace( '/[^0-9]/', '', $value );
}
add_filter( 'sanitize_phone_field', 'sanitize_phone_number' );

// Usage
$phone = apply_filters( 'sanitize_phone_field', $_POST['phone'] );
```

#### Example 8: Modify Admin Columns

```php
// Add custom column to posts list
function add_custom_post_column( $columns ) {
    $columns['views'] = 'Views';
    return $columns;
}
add_filter( 'manage_posts_columns', 'add_custom_post_column' );

// Populate custom column
function populate_custom_post_column( $column, $post_id ) {
    if ( $column === 'views' ) {
        $views = get_post_meta( $post_id, 'post_views', true );
        echo $views ? $views : '0';
    }
}
add_action( 'manage_posts_custom_column', 'populate_custom_post_column', 10, 2 );
```


---

## Common WordPress Hooks

### Initialization Hooks

#### init
**When:** After WordPress has finished loading but before headers are sent
**Use for:** Register post types, taxonomies, shortcodes

```php
function my_plugin_init() {
    register_post_type( 'book', array(
        'public' => true,
        'label'  => 'Books'
    ));
}
add_action( 'init', 'my_plugin_init' );
```

#### plugins_loaded
**When:** After all plugins have been loaded
**Use for:** Initialize plugin features, load text domains

```php
function my_plugin_load_textdomain() {
    load_plugin_textdomain( 'my-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'my_plugin_load_textdomain' );
```

#### admin_init
**When:** Before any admin page is rendered
**Use for:** Register settings, handle form submissions

```php
function my_plugin_register_settings() {
    register_setting( 'my_plugin_options', 'my_plugin_setting' );
}
add_action( 'admin_init', 'my_plugin_register_settings' );
```

---

### Frontend Hooks

#### wp_enqueue_scripts
**When:** Proper time to enqueue scripts and styles for frontend
**Use for:** Loading CSS and JavaScript files

```php
function my_plugin_enqueue_frontend() {
    wp_enqueue_style( 'my-style', plugins_url( 'css/style.css', __FILE__ ) );
    wp_enqueue_script( 'my-script', plugins_url( 'js/script.js', __FILE__ ), array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'my_plugin_enqueue_frontend' );
```

#### wp_head
**When:** In the `<head>` section of the page
**Use for:** Adding meta tags, custom CSS, analytics code

```php
function add_custom_meta_tags() {
    echo '<meta name="author" content="Your Name">';
}
add_action( 'wp_head', 'add_custom_meta_tags' );
```

#### wp_footer
**When:** Before closing `</body>` tag
**Use for:** Adding tracking scripts, custom JavaScript

```php
function add_footer_script() {
    ?>
    <script>
        console.log('Page loaded!');
    </script>
    <?php
}
add_action( 'wp_footer', 'add_footer_script' );
```

#### template_redirect
**When:** Before template file is loaded
**Use for:** Redirects, custom template logic

```php
function custom_redirect() {
    if ( is_page( 'old-page' ) ) {
        wp_redirect( home_url( '/new-page/' ) );
        exit;
    }
}
add_action( 'template_redirect', 'custom_redirect' );
```

---

### Admin Hooks

#### admin_menu
**When:** Admin menu is being built
**Use for:** Adding admin pages and menu items

```php
function my_plugin_admin_menu() {
    add_menu_page(
        'My Plugin',
        'My Plugin',
        'manage_options',
        'my-plugin',
        'my_plugin_page_callback'
    );
}
add_action( 'admin_menu', 'my_plugin_admin_menu' );
```

#### admin_enqueue_scripts
**When:** Loading admin scripts and styles
**Use for:** Enqueuing admin-specific assets

```php
function my_plugin_admin_scripts( $hook ) {
    // Only load on our plugin page
    if ( $hook !== 'toplevel_page_my-plugin' ) {
        return;
    }
    
    wp_enqueue_style( 'my-admin-style', plugins_url( 'css/admin.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'my_plugin_admin_scripts' );
```

#### admin_notices
**When:** Displaying admin notices
**Use for:** Showing messages to admin users

```php
function my_plugin_admin_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p><?php _e( 'Settings saved successfully!', 'my-plugin' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'my_plugin_admin_notice' );
```

---

### Post/Page Hooks

#### save_post
**When:** Post is created or updated
**Use for:** Saving custom meta data, triggering actions

```php
function save_custom_meta( $post_id ) {
    // Check if autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save custom field
    if ( isset( $_POST['custom_field'] ) ) {
        update_post_meta( $post_id, 'custom_field', sanitize_text_field( $_POST['custom_field'] ) );
    }
}
add_action( 'save_post', 'save_custom_meta' );
```

#### publish_post
**When:** Post status changes to 'publish'
**Use for:** Notifications, social media sharing

```php
function notify_on_publish( $post_id, $post ) {
    $author_email = get_the_author_meta( 'user_email', $post->post_author );
    
    wp_mail(
        $author_email,
        'Your post is published!',
        'Your post "' . $post->post_title . '" is now live.'
    );
}
add_action( 'publish_post', 'notify_on_publish', 10, 2 );
```

#### trash_post
**When:** Post is moved to trash
**Use for:** Cleanup, logging

```php
function log_trashed_post( $post_id ) {
    error_log( "Post {$post_id} was trashed" );
}
add_action( 'trash_post', 'log_trashed_post' );
```

---

### User Hooks

#### user_register
**When:** New user is registered
**Use for:** Welcome emails, default settings

```php
function send_welcome_email( $user_id ) {
    $user = get_userdata( $user_id );
    
    wp_mail(
        $user->user_email,
        'Welcome!',
        'Thanks for registering on our site!'
    );
}
add_action( 'user_register', 'send_welcome_email' );
```

#### profile_update
**When:** User profile is updated
**Use for:** Logging changes, syncing data

```php
function log_profile_update( $user_id ) {
    error_log( "User {$user_id} updated their profile" );
}
add_action( 'profile_update', 'log_profile_update' );
```

#### wp_login
**When:** User logs in
**Use for:** Tracking, redirects

```php
function redirect_after_login( $user_login, $user ) {
    if ( in_array( 'subscriber', $user->roles ) ) {
        wp_redirect( home_url( '/dashboard/' ) );
        exit;
    }
}
add_action( 'wp_login', 'redirect_after_login', 10, 2 );
```

---

### Common Filter Hooks

#### the_content
**Filters:** Post content before display

```php
function add_reading_time( $content ) {
    $word_count = str_word_count( strip_tags( $content ) );
    $reading_time = ceil( $word_count / 200 );
    
    $message = '<p><em>Reading time: ' . $reading_time . ' minutes</em></p>';
    
    return $message . $content;
}
add_filter( 'the_content', 'add_reading_time' );
```

#### the_title
**Filters:** Post title before display

```php
function modify_archive_title( $title, $post_id ) {
    if ( is_archive() ) {
        return strtoupper( $title );
    }
    return $title;
}
add_filter( 'the_title', 'modify_archive_title', 10, 2 );
```

#### login_redirect
**Filters:** Redirect URL after login

```php
function custom_login_redirect( $redirect_to, $request, $user ) {
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        if ( in_array( 'administrator', $user->roles ) ) {
            return admin_url();
        } else {
            return home_url( '/my-account/' );
        }
    }
    return $redirect_to;
}
add_filter( 'login_redirect', 'custom_login_redirect', 10, 3 );
```

#### upload_mimes
**Filters:** Allowed file types for upload

```php
function add_custom_mime_types( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter( 'upload_mimes', 'add_custom_mime_types' );
```

---

## Best Practices

### 1. Use Unique Function Names

```php
// BAD - Generic name
function init() {
    // Code
}

// GOOD - Prefixed with plugin name
function my_plugin_init() {
    // Code
}
```

### 2. Always Return Values in Filters

```php
// BAD - No return
function modify_content( $content ) {
    $content . ' Extra text';
}

// GOOD - Returns modified value
function modify_content( $content ) {
    return $content . ' Extra text';
}
add_filter( 'the_content', 'modify_content' );
```

### 3. Check Conditions Before Processing

```php
function my_plugin_save_meta( $post_id ) {
    // Check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Check nonce
    if ( ! isset( $_POST['my_nonce'] ) || ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
        return;
    }
    
    // Now safe to process
}
add_action( 'save_post', 'my_plugin_save_meta' );
```

### 4. Use Appropriate Priority

```php
// Run early (before default priority 10)
add_action( 'init', 'my_early_function', 5 );

// Run at default priority
add_action( 'init', 'my_normal_function' );

// Run late (after default priority 10)
add_action( 'init', 'my_late_function', 20 );
```

### 5. Remove Hooks Properly

```php
// Add action
add_action( 'init', 'my_function', 15 );

// Remove action (priority must match)
remove_action( 'init', 'my_function', 15 );

// For class methods
class MyClass {
    public function __construct() {
        add_action( 'init', array( $this, 'my_method' ) );
    }
    
    public function my_method() {
        // Code
    }
}

// Remove class method
$instance = new MyClass();
remove_action( 'init', array( $instance, 'my_method' ) );
```

### 6. Use Correct Number of Arguments

```php
// Hook passes 3 arguments
function my_function( $post_id, $post, $update ) {
    // Use all 3 arguments
}
// Tell WordPress to pass 3 arguments
add_action( 'save_post', 'my_function', 10, 3 );
```

### 7. Sanitize and Validate Data

```php
function save_custom_data( $post_id ) {
    if ( isset( $_POST['email'] ) ) {
        $email = sanitize_email( $_POST['email'] );
        
        if ( is_email( $email ) ) {
            update_post_meta( $post_id, 'contact_email', $email );
        }
    }
}
add_action( 'save_post', 'save_custom_data' );
```

### 8. Use Conditional Loading

```php
function my_plugin_admin_scripts() {
    // Only load on specific admin page
    $screen = get_current_screen();
    
    if ( $screen->id === 'toplevel_page_my-plugin' ) {
        wp_enqueue_script( 'my-admin-script', plugins_url( 'js/admin.js', __FILE__ ) );
    }
}
add_action( 'admin_enqueue_scripts', 'my_plugin_admin_scripts' );
```

---

## Quick Reference Table

| Hook Type | Function | Purpose |
|-----------|----------|---------|
| Action | `add_action()` | Hook function to action |
| Action | `do_action()` | Execute action hooks |
| Action | `remove_action()` | Remove action hook |
| Action | `has_action()` | Check if action exists |
| Filter | `add_filter()` | Hook function to filter |
| Filter | `apply_filters()` | Execute filter hooks |
| Filter | `remove_filter()` | Remove filter hook |
| Filter | `has_filter()` | Check if filter exists |

---

## Action vs Filter - Quick Comparison

| Aspect | Action | Filter |
|--------|--------|--------|
| Purpose | Execute code | Modify data |
| Return value | Not required | Required |
| Example use | Send email, save data | Modify content, change title |
| Function | `do_action()` | `apply_filters()` |
| Hook function | `add_action()` | `add_filter()` |

---

## Learning Exercise

Try creating a simple plugin that:

1. Adds a custom message to the end of every post
2. Logs when a post is saved
3. Adds a custom admin menu page
4. Enqueues a custom stylesheet

```php
<?php
/*
Plugin Name: My Learning Plugin
Description: Practice using hooks
Version: 1.0
*/

// 1. Add message to post content (FILTER)
function my_add_post_message( $content ) {
    if ( is_single() ) {
        $content .= '<p><strong>Thanks for reading!</strong></p>';
    }
    return $content;
}
add_filter( 'the_content', 'my_add_post_message' );

// 2. Log when post is saved (ACTION)
function my_log_post_save( $post_id ) {
    error_log( "Post {$post_id} was saved at " . current_time( 'mysql' ) );
}
add_action( 'save_post', 'my_log_post_save' );

// 3. Add admin menu (ACTION)
function my_add_admin_menu() {
    add_menu_page(
        'My Plugin',
        'My Plugin',
        'manage_options',
        'my-plugin',
        'my_admin_page_content'
    );
}
add_action( 'admin_menu', 'my_add_admin_menu' );

function my_admin_page_content() {
    echo '<div class="wrap">';
    echo '<h1>My Plugin Settings</h1>';
    echo '<p>This is my first plugin page!</p>';
    echo '</div>';
}

// 4. Enqueue stylesheet (ACTION)
function my_enqueue_styles() {
    wp_enqueue_style(
        'my-plugin-style',
        plugins_url( 'style.css', __FILE__ )
    );
}
add_action( 'wp_enqueue_scripts', 'my_enqueue_styles' );
```

This guide covers the fundamentals of WordPress hooks. Practice with these examples and experiment with different hooks to build your understanding!
