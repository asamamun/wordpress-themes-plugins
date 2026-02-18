# WordPress Custom Post Type Tutorial

This tutorial explains how to create and display a custom post type in WordPress. We'll walk through creating a "notice" custom post type as an example.

## Step 1: Register the Custom Post Type

Add the following code to your theme's `functions.php` file:

```php
<?php
// Custom post "notice"
function wdpf68_post_notice() {
    register_post_type('notice', array(
        'title' => 'Notice',
        'public' => true,
        'taxonomies'    => array('category', 'post_tag'),
        // Featured image support
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'trackbacks', 'author', 'page-attributes', 'post-formats', 'custom-fields'),
        'labels' => array(
            'name' => 'Notice 123',
            'add_new' => 'Add New Notice 4',
            'add_new_item' => 'Add New Notice 5',
            'edit_item' => 'Edit Notice 6',
            'new_item' => 'New Notice 7',
            'view_item' => 'View Notice',
            'search_items' => 'Search Notice',
            'not_found' => 'No Notice Found',
            'not_found_in_trash' => 'No Notice Found in Trash',
            'all_items' => 'All Notice 8',
            'archives' => 'Notice Archives',
            'insert_into_item' => 'Insert into Notice',
            'uploaded_to_this_item' => 'Uploaded to this Notice',
            'featured_image' => 'Featured Image',
            'set_featured_image' => 'Set Featured Image',
            'remove_featured_image' => 'Remove Featured Image',
            'use_featured_image' => 'Use as Featured Image',
            'menu_name' => 'Notice',
            'filter_items_list' => 'Filter Notice List',
            'items_list_navigation' => 'Notice List Navigation',
            'items_list' => 'Notice List',
        )
    ));
}
// Action hook, works in init
add_action('init', 'wdpf68_post_notice');
?>
```

## Step 2: Add Posts in Notice Menu

After adding the code to `functions.php`, you'll see a new "Notice" menu in your WordPress admin panel where you can add and manage notice posts.

## Step 3: Create a Page for Displaying Notices

1. Create a new page in WordPress named "notices"
2. Add this page to your main menu
3. Find the page's ID using the Reveal IDs plugin (in our example, the notice page ID is 301)

## Step 4: Create a Custom Template File

Create a file named `page-301.php` (using your actual page ID) in your theme folder. This file will display your custom post type entries.

## Step 5: Add Custom Query to Show Notice Posts

In your `page-301.php` file, add the following code to query and display your notice posts:

```php
<?php 
$args = array( 
    'posts_per_page' => '5', 
    'post_type'      => 'notice',
); 
$myNotices = new WP_Query( $args );
?>

<?php if ($myNotices->have_posts() ) : ?>
    <?php /* Start the Loop */ ?>
    <?php while ( $myNotices->have_posts() ) : $myNotices->the_post(); ?>
        <!-- Show title, excerpt, thumbnail, author name, date, time etc -->
        <article>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div><?php the_excerpt(); ?></div>
            <div><?php the_post_thumbnail(); ?></div>
            <p>By <?php the_author(); ?> on <?php the_date(); ?></p>
        </article>
    <?php endwhile; ?>
<?php endif; ?>
```

## Additional Notes

- The custom post type will support various features including title, editor, featured image, excerpt, comments, and more
- Make sure to adjust the page ID in the template filename to match your actual page ID
- You can customize the labels and features according to your needs
- Remember to flush rewrite rules by visiting Settings > Permalinks in WordPress admin after adding the custom post type
- That 404 happens because WordPress needs to rebuild its rewrite rules after registering a new post type.
- Go to:
Dashboard → Settings → Permalinks → Click “Save Changes”
👉 Don’t change anything. Just click Save.