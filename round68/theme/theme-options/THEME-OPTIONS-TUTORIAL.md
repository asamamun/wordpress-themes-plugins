# WordPress Theme Options & Settings Tutorial

## Overview
This tutorial explains how `theme-options.php` works to create custom admin menus, submenus, and settings pages in WordPress.

---

## Table of Contents
1. [Adding Options to Database](#1-adding-options-to-database)
2. [Creating Admin Menu & Submenus](#2-creating-admin-menu--submenus)
3. [Registering Settings](#3-registering-settings)
4. [Creating Settings Page](#4-creating-settings-page)
5. [Complete Workflow](#5-complete-workflow)

---

## 1. Adding Options to Database

### Function: `add_option()`
Stores custom data in WordPress `wp_options` table.

```php
add_action('admin_menu', 'wdpf68_add_option');
function wdpf68_add_option() {
    $classinfo = [
        'round' => 68,
        'batch' => 'wdpf',
        'tsp' => 'gnsl',
        'shift' => 'afternoon',
    ];
    add_option('idborg_custom_option', $classinfo);
}
```

**Key Points:**
- `add_option('option_name', $value)` - Creates new option if it doesn't exist
- Data can be string, array, or object
- Stored in `wp_options` table with `option_name` as key

### Deleting Options (Optional)
```php
add_action('after_switch_theme', 'wdpf68_delete_option');
function wdpf68_delete_option() {
    delete_option('idborg_custom_option');
}
```
- Cleans up when theme is deactivated
- Good practice for theme cleanup

---

## 2. Creating Admin Menu & Submenus

### Main Menu Page
```php
add_action('admin_menu', 'idb_add_admin_menu');
function idb_add_admin_menu() {
    add_menu_page(
        'Round68',                    // Page title
        'GNSL 68',                    // Menu title
        'manage_options',             // Capability required
        'theme_customizer',           // Menu slug (unique ID)
        'tct_options_page',           // Callback function
        'dashicons-admin-customizer', // Icon
        4                             // Position
    );
}
```

**Parameters Explained:**
- **Page Title**: Browser tab title
- **Menu Title**: Text shown in admin sidebar
- **Capability**: User permission level (`manage_options` = admin only)
- **Menu Slug**: Unique identifier for the page
- **Callback**: Function that displays page content
- **Icon**: Dashicon class or image URL
- **Position**: Menu order (lower = higher in menu)

### Submenu Pages
```php
add_submenu_page(
    'theme_customizer',      // Parent slug
    'Eid Settings Page',     // Page title
    'Settings',              // Menu title
    'manage_options',        // Capability
    'eid_settings',          // Menu slug
    'prowp_settings_page'    // Callback function
);

add_submenu_page(
    'theme_customizer',
    'Eid Support Page',
    'Support',
    'manage_options',
    'eid_support',
    'prowp_support_page'
);
```

**Key Points:**
- Submenus appear under parent menu
- Parent slug must match main menu slug
- Each submenu needs unique slug and callback

---

## 3. Registering Settings

### Why Register Settings?
WordPress Settings API requires registration for security and validation.

```php
add_action('admin_init', 'prowp_register_settings');
function prowp_register_settings() {
    register_setting(
        'prowp-settings-group',    // Option group name
        'idborg_custom_option'     // Option name (from database)
    );
}
```

**Important:**
- `admin_init` hook runs before admin pages load
- Option group connects form to database
- Option name must match the one used in `add_option()`

---

## 4. Creating Settings Page

### Basic Structure
```php
function prowp_settings_page() {
    ?>
    <div class="wrap">
        <h1>Eid Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('prowp-settings-group'); ?>
            <?php $prowp_options = get_option('idborg_custom_option'); ?>
            
            <!-- Form fields here -->
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
```

### Key Components:

#### 1. `settings_fields()`
```php
<?php settings_fields('prowp-settings-group'); ?>
```
- Generates hidden fields for security (nonce)
- Must match registered option group

#### 2. `get_option()`
```php
<?php $prowp_options = get_option('idborg_custom_option'); ?>
```
- Retrieves saved data from database
- Returns array/string/object based on stored data

#### 3. Form Fields
```php
<table class="form-table">
    <tr>
        <th scope="row"><label for="round">Round</label></th>
        <td>
            <input type="text" 
                   id="round" 
                   name="idborg_custom_option[round]" 
                   value="<?php echo esc_attr($prowp_options['round']); ?>" 
                   class="regular-text" />
        </td>
    </tr>
</table>
```

**Critical Naming Convention:**
- Input name MUST be: `option_name[array_key]`
- Example: `idborg_custom_option[round]`
- This tells WordPress to save as array structure

#### 4. `submit_button()`
```php
<?php submit_button(); ?>
```
- Generates WordPress-styled submit button
- Handles form submission automatically

---

## 5. Complete Workflow

### Step-by-Step Process:

1. **Initialize Option** (runs once)
   ```
   add_option() → Stores default data in database
   ```

2. **Create Menu Structure** (on admin load)
   ```
   add_menu_page() → Creates main menu
   add_submenu_page() → Creates submenus
   ```

3. **Register Settings** (before admin pages load)
   ```
   register_setting() → Connects form to database
   ```

4. **Display Form** (when page is accessed)
   ```
   get_option() → Retrieves current values
   Display form with current values
   ```

5. **Save Data** (when form is submitted)
   ```
   WordPress automatically saves to database
   Uses option name from input field names
   ```

### Data Flow Diagram:
```
User submits form
    ↓
WordPress validates (settings_fields)
    ↓
Saves to wp_options table
    ↓
Page reloads
    ↓
get_option() retrieves updated data
    ↓
Form displays new values
```

---

## Common Mistakes & Solutions

### ❌ Mistake 1: Mismatched Option Names
```php
// Registered as:
register_setting('group', 'idborg_custom_option');

// But form uses:
<input name="prowp_options[round]" />  // WRONG!
```

**✅ Solution:**
```php
<input name="idborg_custom_option[round]" />  // CORRECT!
```

### ❌ Mistake 2: Accessing String as Array
```php
// If option becomes string instead of array:
$prowp_options['round']  // Fatal error!
```

**✅ Solution:**
```php
// Always check type:
if (is_array($prowp_options)) {
    echo $prowp_options['round'];
}
```

### ❌ Mistake 3: Missing Security Functions
```php
// Unsafe:
<input value="<?php echo $prowp_options['round']; ?>" />
```

**✅ Solution:**
```php
// Safe:
<input value="<?php echo esc_attr($prowp_options['round']); ?>" />
```

---

## Best Practices

1. **Use Unique Prefixes**
   - Prefix all functions: `yourtheme_function_name()`
   - Prevents conflicts with plugins/themes

2. **Sanitize Input**
   ```php
   register_setting('group', 'option', 'sanitize_callback');
   ```

3. **Validate Data**
   ```php
   function sanitize_callback($input) {
       $output['round'] = absint($input['round']);
       $output['batch'] = sanitize_text_field($input['batch']);
       return $output;
   }
   ```

4. **Use WordPress Styling**
   - `.wrap` class for page container
   - `.form-table` for settings layout
   - `submit_button()` for consistency

5. **Check Capabilities**
   ```php
   if (!current_user_can('manage_options')) {
       wp_die('Unauthorized');
   }
   ```

---

## Testing Your Settings

1. **Check if option exists:**
   ```php
   var_dump(get_option('idborg_custom_option'));
   ```

2. **Verify menu appears:**
   - Go to WordPress admin
   - Look for your menu in sidebar

3. **Test form submission:**
   - Change values
   - Click "Save Changes"
   - Refresh page
   - Verify values persist

4. **Check database:**
   - phpMyAdmin → `wp_options` table
   - Find `option_name` = 'idborg_custom_option'
   - Verify `option_value` contains your data

---

## Additional Resources

- [WordPress Settings API](https://developer.wordpress.org/plugins/settings/settings-api/)
- [add_menu_page()](https://developer.wordpress.org/reference/functions/add_menu_page/)
- [register_setting()](https://developer.wordpress.org/reference/functions/register_setting/)
- [Dashicons](https://developer.wordpress.org/resource/dashicons/)

---

## Summary

Creating theme options involves:
1. Store default data with `add_option()`
2. Create menu structure with `add_menu_page()` and `add_submenu_page()`
3. Register settings with `register_setting()`
4. Build form with proper naming: `option_name[key]`
5. Use `settings_fields()` for security
6. Retrieve data with `get_option()`
7. WordPress handles saving automatically

**Remember:** Input names must match registered option name for WordPress to save correctly!
