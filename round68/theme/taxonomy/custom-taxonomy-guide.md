# WordPress Custom Taxonomy Guide

This guide explains how to create custom taxonomies in WordPress using the `register_taxonomy()` function, based on the example in `post-taxonomy.php`.

## What is a Custom Taxonomy?

A custom taxonomy is a way to group posts or other content types together. Think of it as a labeling system that helps organize and categorize your content. Common examples include:
- Categories and tags (built-in taxonomies)
- Product types, colors, sizes
- Event types, locations
- News topics, departments

## Basic Syntax

```php
register_taxonomy( $taxonomy, $object_type, $args );
```

**Parameters:**
- `$taxonomy` (string) - The name of your taxonomy (e.g., 'genre', 'type', 'mood')
- `$object_type` (array|string) - Post type(s) to associate with this taxonomy
- `$args` (array) - Configuration options for the taxonomy

## Example Breakdown

Let's examine the code in `post-taxonomy.php`:

### 1. Notice Type Taxonomy

```php
register_taxonomy(
    'type',           // Taxonomy name
    'notice',         // Associated post type
    array( 
        'hierarchical' => true,    // Behaves like categories (can have parent/child)
        'label'        => 'Type',  // Display name in admin
        'query_var'    => true,    // Enable query variables
        'rewrite'      => true     // Enable pretty URLs
    ) 
);
```

### 2. Post Mood Taxonomy

```php
register_taxonomy(
    'mood', 
    'post',           // Associated with default 'post' type
    array( 
        'hierarchical' => true,
        'label'        => 'Mood',
        'query_var'    => true,
        'rewrite'      => true,
        'show_ui'      => true,    // Show in admin UI
        'show_in_menu' => true,    // Show in admin menu
        'show_in_rest' => true     // Enable in Gutenberg editor
    ) 
);
```

## Key Arguments Explained

### Essential Arguments

| Argument | Type | Description | Example |
|----------|------|-------------|---------|
| `hierarchical` | boolean | `true` = category-like (with parent/child), `false` = tag-like | `true` |
| `label` | string | Display name in admin interface | `'Product Type'` |
| `labels` | array | Custom labels for different UI elements | `array('name' => 'Genres')` |
| `public` | boolean | Whether taxonomy is publicly queryable | `true` |
| `show_ui` | boolean | Show admin interface | `true` |
| `show_in_menu` | boolean | Show in admin menu | `true` |
| `show_in_nav_menus` | boolean | Show in navigation menus | `true` |
| `show_in_rest` | boolean | Enable in REST API (Gutenberg) | `true` |
| `show_tagcloud` | boolean | Show in tag cloud widgets | `true` |
| `show_in_quick_edit` | boolean | Show in quick/bulk edit | `true` |
| `show_admin_column` | boolean | Show taxonomy column in post list | `true` |

### URL and Query Arguments

| Argument | Type | Description | Example |
|----------|------|-------------|---------|
| `rewrite` | boolean/array | URL rewriting rules | `true` or `array('slug' => 'genre')` |
| `query_var` | boolean/string | Query variable name | `true` or `'genre_filter'` |
| `rewrite` array options | array | Custom rewrite settings | See below |

### Rewrite Array Options

```php
'rewrite' => array(
    'slug' => 'genre',           // URL prefix: /genre/action/
    'with_front' => true,        // Include permalink structure prefix
    'hierarchical' => false,     // Allow hierarchical URLs
    'ep_mask' => EP_NONE         // Endpoint mask
)
```

## Complete Example with All Options

```php
function create_custom_taxonomies() {
    // Genre taxonomy for books
    register_taxonomy(
        'genre',
        'book',  // Custom post type
        array(
            'hierarchical'          => true,
            'labels'                => array(
                'name'              => 'Genres',
                'singular_name'     => 'Genre',
                'search_items'      => 'Search Genres',
                'all_items'         => 'All Genres',
                'parent_item'       => 'Parent Genre',
                'parent_item_colon' => 'Parent Genre:',
                'edit_item'         => 'Edit Genre',
                'update_item'       => 'Update Genre',
                'add_new_item'      => 'Add New Genre',
                'new_item_name'     => 'New Genre Name',
                'menu_name'         => 'Genres',
            ),
            'show_ui'               => true,
            'show_admin_column'     => true,
            'show_in_rest'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'genre'),
        )
    );
}
add_action('init', 'create_custom_taxonomies');
```

## Best Practices

### 1. Naming Conventions
- Use lowercase letters and underscores
- Keep names short but descriptive
- Avoid reserved names like 'post', 'page', 'tag', 'category'

### 2. Hook Usage
Always hook into `init` action:
```php
add_action('init', 'your_taxonomy_function');
```

### 3. Performance Considerations
- Only enable features you need
- Use `show_in_rest => false` if not using Gutenberg
- Consider `public => false` for private taxonomies

### 4. Admin Interface
```php
'show_ui'           => true,  // Show in admin
'show_in_menu'      => true,  // Show in main menu
'show_in_nav_menus' => true,  // Show in menus
'show_admin_column' => true,  // Show column in post list
```

## Querying Taxonomy Terms

### Get Terms
```php
$terms = get_terms(array(
    'taxonomy' => 'genre',
    'hide_empty' => false,
));
```

### Query Posts by Taxonomy
```php
$query = new WP_Query(array(
    'post_type' => 'book',
    'tax_query' => array(
        array(
            'taxonomy' => 'genre',
            'field'    => 'slug',
            'terms'    => 'fiction',
        ),
    ),
));
```

### Multiple Taxonomies
```php
'tax_query' => array(
    'relation' => 'AND',  // or 'OR'
    array(
        'taxonomy' => 'genre',
        'field'    => 'slug',
        'terms'    => array('fiction', 'mystery'),
    ),
    array(
        'taxonomy' => 'author',
        'field'    => 'term_id',
        'terms'    => array(10, 15),
    ),
)
```

## Common Issues and Solutions

### 1. 404 Errors After Adding Taxonomy
**Solution:** Flush permalinks by visiting Settings → Permalinks and clicking "Save Changes"

### 2. Taxonomy Not Showing in Admin
**Check:**
- `show_ui` is set to `true`
- User has proper capabilities
- Hook is properly added to `init`

### 3. REST API Not Working
**Solution:** Ensure `'show_in_rest' => true` is set

### 4. Custom Post Type Not Recognizing Taxonomy
**Make sure:**
- Taxonomy is registered after the post type
- Both use the `init` hook
- Correct post type name is used

## Advanced Features

### Custom Meta Fields for Terms
```php
// Add custom fields to term edit form
add_action('genre_edit_form_fields', 'edit_genre_custom_field');
function edit_genre_custom_field($term) {
    $color = get_term_meta($term->term_id, 'color', true);
    echo '<tr class="form-field">
        <th scope="row" valign="top"><label for="color">Color</label></th>
        <td><input type="text" name="color" id="color" value="' . esc_attr($color) . '"></td>
    </tr>';
}

// Save custom field
add_action('edited_genre', 'save_genre_custom_field');
function save_genre_custom_field($term_id) {
    if (isset($_POST['color'])) {
        update_term_meta($term_id, 'color', sanitize_text_field($_POST['color']));
    }
}
```

### Custom Rewrite Rules
```php
'rewrite' => array(
    'slug' => 'books/genre',
    'with_front' => false,
    'hierarchical' => true
)
```

## File Organization Tips

### 1. Separate File Approach
Create `taxonomy-register.php` and include in `functions.php`:
```php
// In functions.php
require_once get_template_directory() . '/inc/taxonomy-register.php';
```

### 2. Class-Based Organization
```php
class CustomTaxonomies {
    public function __construct() {
        add_action('init', array($this, 'register_taxonomies'));
    }
    
    public function register_taxonomies() {
        // Register your taxonomies here
    }
}
new CustomTaxonomies();
```

## Testing Your Taxonomy

### 1. Check Registration
```php
// Add temporarily to verify
add_action('admin_init', function() {
    global $wp_taxonomies;
    error_log(print_r(array_keys($wp_taxonomies), true));
});
```

### 2. Verify in Admin
- Check if taxonomy appears in the post edit screen
- Verify it shows in the admin menu
- Test creating and assigning terms

## Security Considerations

### 1. Sanitize Input
Always sanitize data when saving:
```php
sanitize_text_field($_POST['field_name'])
```

### 2. Capability Checks
```php
if (!current_user_can('manage_categories')) {
    return;
}
```

### 3. Nonce Verification
```php
wp_verify_nonce($_POST['nonce_field'], 'nonce_action')
```

## Migration and Updates

When modifying existing taxonomies:
1. Always test on staging first
2. Consider using migration plugins for major changes
3. Backup database before making changes
4. Flush permalinks after changes

## Resources

- [WordPress Codex: register_taxonomy()](https://developer.wordpress.org/reference/functions/register_taxonomy/)
- [Taxonomies Handbook](https://developer.wordpress.org/plugins/taxonomies/)
- [REST API Taxonomy Schema](https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/)

---

*This guide was created based on the taxonomy implementation in `post-taxonomy.php`*