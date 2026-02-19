# Content Ads Plugin Documentation

## Overview
The Content Ads plugin randomly displays advertisements within your WordPress content. It automatically injects ad images after post content using WordPress hooks.

## How It Works

### 1. Plugin Structure
```
content-ads/
├── content-ads.php    # Main plugin file
├── ads/              # Directory containing ad images
│   ├── abc.gif
│   ├── bashundhara.jpg
│   ├── nagad.jpg
│   └── tata.gif
└── README.md         # This documentation
```

### 2. Core Components

#### Plugin Header
```php
<?php 
/*
Plugin Name: Random Content Ads
Plugin URI: http://proqoder.com/wordpress-plugins/random-content-ads
Description: Randomly display ads in your content after the content
Version: 1.0
Author: GNSL Round 68
Author URI: http://proqoder.com
Text Domain: random-content-ads
License: GPLv2
*/
```

#### Constants Definition
```php
define( 'RCAD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'RCAD_PLUGIN_PATH', dirname( __FILE__ ) . '/' );
```

- `RCAD_PLUGIN_URL`: Web URL path to the plugin directory
- `RCAD_PLUGIN_PATH`: File system path to the plugin directory

### 3. Main Function: `display_ads()`

This function is hooked to `the_content` filter and processes all post content.

#### Step-by-Step Process:

1. **Locate Ad Files**
```php
$ads_directory = RCAD_PLUGIN_PATH . 'ads/';
$ads_files = glob($ads_directory . "*.{jpg,png,gif,jpeg,webp}", GLOB_BRACE);
```
- Uses file system path to search for image files
- Supports multiple image formats: jpg, png, gif, jpeg, webp
- `GLOB_BRACE` allows pattern matching with curly braces

2. **Error Handling**
```php
if (empty($ads_files)) {
    error_log('Content Ads: No ad images found in ' . $ads_directory);
    return $content;
}
```
- Checks if any ad images exist
- Returns original content unchanged if no ads found
- Logs error for debugging

3. **Random Selection**
```php
shuffle($ads_files);
$ad_file = basename($ads_files[0]);
```
- Randomizes the array of found files
- Selects the first file from shuffled array

4. **Generate Display URL**
```php
$ad_url = RCAD_PLUGIN_URL . 'ads/' . $ad_file;
```
- Converts file system path to web-accessible URL
- Uses the plugin URL constant for proper web paths

5. **Inject Ad into Content**
```php
return $content . '<div class="ads"><img style="display: block; margin: 0 auto;" width="100%" height="auto" src="' . $ad_url . '" alt="Advertisement" /></div>';
```

### 4. WordPress Hook Integration

```php
add_filter('the_content', 'display_ads');
```

- Hooks into WordPress `the_content` filter
- Automatically processes all post/page content
- No manual template modifications required

## Technical Details

### Path Handling
**Key Concept**: `glob()` requires file system paths, not URLs
- ✅ Correct: `D:\xampp\htdocs\wp-content\plugins\content-ads\ads\`
- ❌ Wrong: `http://localhost/wp-content/plugins/content-ads/ads/`

### File Operations Flow
```
1. Plugin loads → Define constants
2. Content requested → Hook triggers
3. Find image files → Use file system path + glob()
4. Select random file → shuffle() array
5. Generate web URL → Convert file path to URL
6. Inject HTML → Append to content
```

### Supported Image Formats
- JPEG (.jpg, .jpeg)
- PNG (.png)
- GIF (.gif)
- WebP (.webp)

## Usage Examples

### Basic Implementation
The plugin works automatically once activated. No configuration needed.

### Customization Options
You can modify the display by editing the HTML in the return statement:
```php
return $content . '<div class="my-custom-ads">
    <img src="' . $ad_url . '" alt="Sponsored Content" class="responsive-ad" />
</div>';
```

### Adding New Ads
1. Place image files in the `ads/` directory
2. Supported formats: jpg, png, gif, jpeg, webp
3. No filename restrictions (spaces, special characters OK)
4. Images are automatically detected and included

## Troubleshooting

### Common Issues

1. **Ads not displaying**
   - Check if `ads/` directory exists
   - Verify image files are in supported formats
   - Check WordPress error log for messages

2. **Wrong path errors**
   - Ensure `RCAD_PLUGIN_PATH` uses `dirname(__FILE__)`
   - Don't use `plugin_dir_path()` for file operations

3. **Images not loading**
   - Verify web server can access the ads directory
   - Check file permissions
   - Ensure `RCAD_PLUGIN_URL` generates correct URLs

### Debug Mode
Uncomment these lines for debugging:
```php
// var_dump($ads_files);
// error_log('Selected ad: ' . $ad_url);
```

## Best Practices

1. **File Management**
   - Keep ad images optimized for web
   - Use descriptive filenames
   - Regular cleanup of unused images

2. **Performance**
   - Limit number of ad images to reasonable amount
   - Consider caching strategies for high-traffic sites

3. **Security**
   - Only place trusted image files in ads directory
   - Regular file permission checks

## Version History
- **1.0**: Initial release with basic random ad display functionality

## Author
GNSL Round 68
http://proqoder.com