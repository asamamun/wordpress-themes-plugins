# WordPress Plugin Functions Reference

This document provides detailed documentation for commonly used WordPress plugin functions.

## Translation Functions

### __()

**Description:** Retrieves the translation of a text string.

**Syntax:**
```php
__( $text, $domain )
```

**Parameters:**
- `$text` (string) - Text to translate
- `$domain` (string) - Text domain for the translation

**Return:** (string) Translated text

**Example:**
```php
$greeting = __( 'Hello World', 'my-plugin' );
echo $greeting;
```

---

### _e()

**Description:** Displays the translation of a text string (echo version of `__()`).

**Syntax:**
```php
_e( $text, $domain )
```

**Parameters:**
- `$text` (string) - Text to translate
- `$domain` (string) - Text domain

**Return:** void (echoes directly)

**Example:**
```php
_e( 'Welcome to my plugin', 'my-plugin' );
```

---

### _n()

**Description:** Translates and retrieves singular or plural form based on supplied number.

**Syntax:**
```php
_n( $single, $plural, $number, $domain )
```

**Parameters:**
- `$single` (string) - Singular form
- `$plural` (string) - Plural form
- `$number` (int) - Number to determine singular/plural
- `$domain` (string) - Text domain

**Return:** (string) Translated text

**Example:**
```php
$count = 5;
$message = sprintf(
    _n( 'You have %d item', 'You have %d items', $count, 'my-plugin' ),
    $count
);
echo $message; // Output: You have 5 items
```

---

### _x()

**Description:** Retrieves translated string with context.

**Syntax:**
```php
_x( $text, $context, $domain )
```

**Parameters:**
- `$text` (string) - Text to translate
- `$context` (string) - Context information for translators
- `$domain` (string) - Text domain

**Return:** (string) Translated text

**Example:**
```php
// "Post" can mean different things
$noun = _x( 'Post', 'noun', 'my-plugin' );
$verb = _x( 'Post', 'verb', 'my-plugin' );
```

---

## Path and URL Functions

### plugin_dir_path()

**Description:** Gets filesystem directory path for plugin file.

**Syntax:**
```php
plugin_dir_path( $file )
```

**Parameters:**
- `$file` (string) - Full path to plugin file (use `__FILE__`)

**Return:** (string) Directory path with trailing slash

**Example:**
```php
$path = plugin_dir_path( __FILE__ );
require_once $path . 'includes/functions.php';
```

---

### plugins_url()

**Description:** Retrieves URL to plugins directory or specific file.

**Syntax:**
```php
plugins_url( $path, $plugin )
```

**Parameters:**
- `$path` (string) - Path relative to plugins directory
- `$plugin` (string) - Plugin file (use `__FILE__`)

**Return:** (string) URL

**Example:**
```php
$icon_url = plugins_url( 'images/icon.png', __FILE__ );
echo '<img src="' . esc_url( $icon_url ) . '">';
```

---

### admin_url()

**Description:** Retrieves URL to admin area.

**Syntax:**
```php
admin_url( $path, $scheme )
```

**Parameters:**
- `$path` (string) - Path relative to admin URL
- `$scheme` (string) - URL scheme (http, https, admin)

**Return:** (string) Admin URL

**Example:**
```php
$settings_url = admin_url( 'options-general.php?page=my-plugin' );
$ajax_url = admin_url( 'admin-ajax.php' );
```

---

### site_url()

**Description:** Retrieves site URL for current site.

**Syntax:**
```php
site_url( $path, $scheme )
```

**Parameters:**
- `$path` (string) - Path relative to site URL
- `$scheme` (string) - URL scheme

**Return:** (string) Site URL

**Example:**
```php
$url = site_url( '/my-page/' );
// Returns: http://example.com/my-page/
```

---

### home_url()

**Description:** Retrieves home URL for current site.

**Syntax:**
```php
home_url( $path, $scheme )
```

**Parameters:**
- `$path` (string) - Path relative to home URL
- `$scheme` (string) - URL scheme

**Return:** (string) Home URL

**Example:**
```php
$home = home_url( '/' );
$page = home_url( '/about/' );
```

---

### includes_url()

**Description:** Retrieves URL to wp-includes directory.

**Syntax:**
```php
includes_url( $path, $scheme )
```

**Parameters:**
- `$path` (string) - Path relative to includes URL
- `$scheme` (string) - URL scheme

**Return:** (string) Includes URL

**Example:**
```php
$js_url = includes_url( 'js/jquery/jquery.js' );
```

---

### content_url()

**Description:** Retrieves URL to wp-content directory.

**Syntax:**
```php
content_url( $path )
```

**Parameters:**
- `$path` (string) - Path relative to content URL

**Return:** (string) Content URL

**Example:**
```php
$uploads = content_url( '/uploads/' );
$themes = content_url( '/themes/' );
```

---

### wp_upload_dir()

**Description:** Returns array of upload directory paths and URLs.

**Syntax:**
```php
wp_upload_dir( $time, $create_dir, $refresh_cache )
```

**Parameters:**
- `$time` (string) - Time formatted in 'yyyy/mm'
- `$create_dir` (bool) - Whether to create directory
- `$refresh_cache` (bool) - Whether to refresh cache

**Return:** (array) Upload directory information

**Example:**
```php
$upload_dir = wp_upload_dir();
echo $upload_dir['path'];    // /var/www/html/wp-content/uploads/2026/02
echo $upload_dir['url'];     // http://example.com/wp-content/uploads/2026/02
echo $upload_dir['basedir']; // /var/www/html/wp-content/uploads
echo $upload_dir['baseurl']; // http://example.com/wp-content/uploads
```


---

## Security Functions - Nonces

### What are Nonces?

Nonces (Number Used Once) are security tokens used to protect URLs and forms from malicious attacks. They verify that requests come from legitimate sources.

### wp_nonce_field()

**Description:** Generates hidden nonce fields for forms.

**Syntax:**
```php
wp_nonce_field( $action, $name, $referer, $echo )
```

**Parameters:**
- `$action` (string) - Action name for nonce verification
- `$name` (string) - Nonce field name (default: '_wpnonce')
- `$referer` (bool) - Whether to add referer field (default: true)
- `$echo` (bool) - Whether to echo or return (default: true)

**Return:** (string) Nonce field HTML

**Example:**
```php
<form method="post">
    <?php wp_nonce_field( 'prowp_settings_form_save', 'prowp_nonce_field' ); ?>
    <input type="text" name="setting_value">
    <input type="submit" value="Save">
</form>
```

---

### wp_verify_nonce()

**Description:** Verifies that nonce is valid.

**Syntax:**
```php
wp_verify_nonce( $nonce, $action )
```

**Parameters:**
- `$nonce` (string) - Nonce value to verify
- `$action` (string) - Action name used when creating nonce

**Return:** (int|false) 1 or 2 if valid, false if invalid

**Example:**
```php
if ( isset( $_POST['prowp_nonce_field'] ) ) {
    if ( ! wp_verify_nonce( $_POST['prowp_nonce_field'], 'prowp_settings_form_save' ) ) {
        wp_die( 'Security check failed!' );
    }
    
    // Process form data
    $value = sanitize_text_field( $_POST['setting_value'] );
    update_option( 'my_setting', $value );
}
```

---

### wp_nonce_url()

**Description:** Adds nonce to URL.

**Syntax:**
```php
wp_nonce_url( $actionurl, $action, $name )
```

**Parameters:**
- `$actionurl` (string) - URL to add nonce to
- `$action` (string) - Action name
- `$name` (string) - Nonce parameter name (default: '_wpnonce')

**Return:** (string) URL with nonce added

**Example:**
```php
$delete_url = wp_nonce_url(
    admin_url( 'admin.php?action=delete&id=123' ),
    'delete_item_123'
);

echo '<a href="' . esc_url( $delete_url ) . '">Delete</a>';

// Verify in handler
if ( isset( $_GET['_wpnonce'] ) ) {
    if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'delete_item_123' ) ) {
        wp_die( 'Invalid nonce!' );
    }
    // Delete item
}
```

---

## Data Sanitization Functions

### sanitize_text_field()

**Description:** Sanitizes string from user input or database.

**Syntax:**
```php
sanitize_text_field( $str )
```

**Parameters:**
- `$str` (string) - String to sanitize

**Return:** (string) Sanitized string

**Example:**
```php
$username = sanitize_text_field( $_POST['username'] );
$title = sanitize_text_field( $_POST['post_title'] );

update_option( 'my_plugin_username', $username );
```

**What it does:**
- Removes tags
- Removes line breaks, tabs, extra whitespace
- Strips octets

---

### sanitize_email()

**Description:** Strips invalid characters from email address.

**Syntax:**
```php
sanitize_email( $email )
```

**Parameters:**
- `$email` (string) - Email address to sanitize

**Return:** (string) Sanitized email

**Example:**
```php
$email = sanitize_email( $_POST['user_email'] );

if ( is_email( $email ) ) {
    update_user_meta( $user_id, 'contact_email', $email );
}
```

---

### wp_kses()

**Description:** Filters text content and strips disallowed HTML.

**Syntax:**
```php
wp_kses( $string, $allowed_html, $allowed_protocols )
```

**Parameters:**
- `$string` (string) - Content to filter
- `$allowed_html` (array) - Allowed HTML tags and attributes
- `$allowed_protocols` (array) - Allowed protocols

**Return:** (string) Filtered content

**Example:**
```php
// Allow only specific tags
$allowed_tags = array(
    'a' => array(
        'href' => array(),
        'title' => array()
    ),
    'br' => array(),
    'em' => array(),
    'strong' => array()
);

$content = wp_kses( $_POST['content'], $allowed_tags );

// Use wp_kses_post() for post content (allows more tags)
$post_content = wp_kses_post( $_POST['post_content'] );
```

---

## Data Escaping Functions

### esc_url()

**Description:** Escapes URL for safe output in HTML.

**Syntax:**
```php
esc_url( $url, $protocols, $_context )
```

**Parameters:**
- `$url` (string) - URL to escape
- `$protocols` (array) - Allowed protocols
- `$_context` (string) - Context (display or database)

**Return:** (string) Escaped URL

**Example:**
```php
$url = 'http://example.com/page?param=value';
echo '<a href="' . esc_url( $url ) . '">Link</a>';

$image_url = plugins_url( 'images/logo.png', __FILE__ );
echo '<img src="' . esc_url( $image_url ) . '">';
```

---

### esc_js()

**Description:** Escapes string for safe use in JavaScript.

**Syntax:**
```php
esc_js( $text )
```

**Parameters:**
- `$text` (string) - Text to escape

**Return:** (string) Escaped text

**Example:**
```php
$message = "Hello 'World'";
?>
<script>
    var message = '<?php echo esc_js( $message ); ?>';
    alert( message );
</script>
```

---

### esc_sql()

**Description:** Escapes data for use in SQL query (use $wpdb->prepare() instead when possible).

**Syntax:**
```php
esc_sql( $data )
```

**Parameters:**
- `$data` (string|array) - Data to escape

**Return:** (string|array) Escaped data

**Example:**
```php
global $wpdb;

// BETTER: Use $wpdb->prepare()
$results = $wpdb->get_results(
    $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}my_table WHERE name = %s",
        $name
    )
);

// If you must use esc_sql()
$name = esc_sql( $name );
$results = $wpdb->get_results(
    "SELECT * FROM {$wpdb->prefix}my_table WHERE name = '$name'"
);
```

**Important:** Always prefer `$wpdb->prepare()` over `esc_sql()` for database queries.

---

## Security Best Practices

### Complete Form Example

```php
// Display form
function my_plugin_settings_form() {
    ?>
    <form method="post" action="">
        <?php wp_nonce_field( 'prowp_settings_form_save', 'prowp_nonce_field' ); ?>
        
        <input type="text" name="username" value="<?php echo esc_attr( get_option( 'my_username' ) ); ?>">
        <input type="email" name="email" value="<?php echo esc_attr( get_option( 'my_email' ) ); ?>">
        <textarea name="bio"><?php echo esc_textarea( get_option( 'my_bio' ) ); ?></textarea>
        
        <input type="submit" value="<?php esc_attr_e( 'Save Settings', 'my-plugin' ); ?>">
    </form>
    <?php
}

// Process form
function my_plugin_process_form() {
    if ( ! isset( $_POST['prowp_nonce_field'] ) ) {
        return;
    }
    
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['prowp_nonce_field'], 'prowp_settings_form_save' ) ) {
        wp_die( __( 'Security check failed!', 'my-plugin' ) );
    }
    
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( __( 'You do not have permission to perform this action.', 'my-plugin' ) );
    }
    
    // Sanitize and save
    $username = sanitize_text_field( $_POST['username'] );
    $email = sanitize_email( $_POST['email'] );
    $bio = wp_kses_post( $_POST['bio'] );
    
    update_option( 'my_username', $username );
    update_option( 'my_email', $email );
    update_option( 'my_bio', $bio );
    
    // Redirect to prevent resubmission
    wp_redirect( add_query_arg( 'updated', 'true', admin_url( 'admin.php?page=my-plugin' ) ) );
    exit;
}
add_action( 'admin_init', 'my_plugin_process_form' );
```

---

## Quick Reference

| Function | Purpose | Use Case |
|----------|---------|----------|
| `__()` | Translate and return | Store translated text in variable |
| `_e()` | Translate and echo | Direct output |
| `_n()` | Singular/plural translation | Dynamic text based on count |
| `_x()` | Translation with context | Ambiguous words |
| `sanitize_text_field()` | Clean text input | Form fields, user input |
| `sanitize_email()` | Clean email | Email addresses |
| `wp_kses()` | Allow specific HTML | Rich text with limited tags |
| `esc_url()` | Escape URLs | Links, image sources |
| `esc_js()` | Escape for JavaScript | JS strings |
| `esc_sql()` | Escape for SQL | Database queries (use prepare() instead) |
| `wp_nonce_field()` | Add nonce to form | Form security |
| `wp_verify_nonce()` | Verify nonce | Form processing |
| `wp_nonce_url()` | Add nonce to URL | Link security |
