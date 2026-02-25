# WordPress Customizer API Tutorial

## Overview
This tutorial explains how `customize-fields.php` works using the WordPress Customizer API to create theme options with live preview functionality.

---

## Table of Contents
1. [Customizer vs Settings API](#1-customizer-vs-settings-api)
2. [Core Concepts](#2-core-concepts)
3. [add_section() - Creating Sections](#3-add_section---creating-sections)
4. [add_setting() - Storing Data](#4-add_setting---storing-data)
5. [add_control() - User Interface](#5-add_control---user-interface)
6. [Control Types](#6-control-types)
7. [Retrieving Values](#7-retrieving-values)
8. [Complete Workflow](#8-complete-workflow)
9. [Carousel Implementation](#9-carousel-implementation)

---

## 1. Customizer vs Settings API

### Settings API (theme-options.php)
- Creates admin menu pages
- Uses `add_option()`, `register_setting()`, `add_menu_page()`
- Data stored in `wp_options` table
- Full page refresh on save
- Good for complex admin interfaces

### Customizer API (customize-fields.php)
- Built-in WordPress Customizer interface
- Uses `add_section()`, `add_setting()`, `add_control()`
- Data stored in `wp_options` table as theme mods
- Live preview capability
- Good for theme styling options

**Key Difference:**
```php
// Settings API
add_option('my_option', 'value');
$value = get_option('my_option');

// Customizer API
set_theme_mod('my_setting', 'value');
$value = get_theme_mod('my_setting');
```

---

## 2. Core Concepts

### The Three-Step Process

Every customizer option requires THREE steps:

```php
// STEP 1: Create Section (container)
$wp_customize->add_section('section_id', [...]);

// STEP 2: Create Setting (data storage)
$wp_customize->add_setting('setting_id', [...]);

// STEP 3: Create Control (user interface)
$wp_customize->add_control('control_id', [...]);
```

### Visual Hierarchy
```
Customizer Panel
  └── Section (e.g., "Carousel Settings")
       ├── Control 1 (e.g., "Image 1" upload button)
       │    └── Setting 1 (stores image URL)
       ├── Control 2 (e.g., "Image 2" upload button)
       │    └── Setting 2 (stores image URL)
       └── Control 3 (e.g., "Image 3" upload button)
            └── Setting 3 (stores image URL)
```

---

## 3. add_section() - Creating Sections

### Purpose
Groups related controls together in the Customizer sidebar.

### Syntax
```php
$wp_customize->add_section('section_id', array(
    'title'       => __('Section Title', 'textdomain'),
    'description' => __('Section description', 'textdomain'),
    'priority'    => 30,
    'capability'  => 'edit_theme_options',
));
```

### Parameters Explained

| Parameter | Type | Description |
|-----------|------|-------------|
| `title` | string | Display name in Customizer |
| `description` | string | Help text shown at top of section |
| `priority` | int | Order in Customizer (lower = higher) |
| `capability` | string | User permission required |

### Example from customize-fields.php
```php
$wp_customize->add_section('wdpf68_carousel_section', array(
    'title'    => __('Carousel Settings', 'wdpf68'),
    'priority' => 30,
));
```

**Result:** Creates "Carousel Settings" section in Customizer.

---

## 4. add_setting() - Storing Data

### Purpose
Defines HOW and WHERE data is stored.

### Syntax
```php
$wp_customize->add_setting('setting_id', array(
    'default'           => 'default_value',
    'transport'         => 'refresh',
    'sanitize_callback' => 'sanitize_function',
    'type'              => 'theme_mod',
));
```

### Parameters Explained

| Parameter | Type | Description |
|-----------|------|-------------|
| `default` | mixed | Default value if not set |
| `transport` | string | `refresh` (reload page) or `postMessage` (live preview) |
| `sanitize_callback` | string | Function to clean/validate input |
| `type` | string | `theme_mod` (default) or `option` |

### Storage Types

#### theme_mod (Default)
```php
$wp_customize->add_setting('carousel_image_1', array(
    'default'   => '',
    'transport' => 'refresh',
));

// Stored as: wp_options → theme_mods_themename
// Retrieved with: get_theme_mod('carousel_image_1')
```

#### option
```php
$wp_customize->add_setting('my_custom_option', array(
    'type'    => 'option',
    'default' => '',
));

// Stored as: wp_options → my_custom_option
// Retrieved with: get_option('my_custom_option')
```

### Common Sanitize Callbacks

```php
// URL
'sanitize_callback' => 'esc_url_raw'

// Hex color
'sanitize_callback' => 'sanitize_hex_color'

// HTML
'sanitize_callback' => 'wp_kses_post'

// Text
'sanitize_callback' => 'sanitize_text_field'

// Integer
'sanitize_callback' => 'absint'
```

### Example from customize-fields.php
```php
// Image setting
$wp_customize->add_setting('carousel_image_1', array(
    'default'   => '',
    'transport' => 'refresh',
));

// URL setting with sanitization
$wp_customize->add_setting('social_facebook', array(
    'default'           => '',
    'sanitize_callback' => 'esc_url_raw',
));

// Color setting
$wp_customize->add_setting('theme_background_color', array(
    'default'           => '#ffffff',
    'sanitize_callback' => 'sanitize_hex_color',
));
```

---

## 5. add_control() - User Interface

### Purpose
Creates the actual input field users interact with.

### Basic Syntax
```php
$wp_customize->add_control('control_id', array(
    'label'    => __('Control Label', 'textdomain'),
    'section'  => 'section_id',
    'settings' => 'setting_id',
    'type'     => 'text',
));
```

### Parameters Explained

| Parameter | Type | Description |
|-----------|------|-------------|
| `label` | string | Display label for the control |
| `description` | string | Help text below control |
| `section` | string | Which section to place control in |
| `settings` | string | Which setting to bind to |
| `type` | string | Input type (text, url, textarea, etc.) |
| `priority` | int | Order within section |

### Example from customize-fields.php
```php
// Text URL input
$wp_customize->add_control('social_facebook', array(
    'label'    => __('Facebook URL', 'wdpf68'),
    'section'  => 'wdpf68_social_section',
    'type'     => 'url',
));

// Textarea
$wp_customize->add_control('google_analytics_code', array(
    'label'       => __('Google Analytics Code', 'wdpf68'),
    'description' => __('Paste your tracking code here', 'wdpf68'),
    'section'     => 'wdpf68_analytics_section',
    'type'        => 'textarea',
));
```

---

## 6. Control Types

### Built-in Control Types

#### Basic Controls
```php
// Text input
'type' => 'text'

// URL input
'type' => 'url'

// Email input
'type' => 'email'

// Textarea
'type' => 'textarea'

// Checkbox
'type' => 'checkbox'

// Radio buttons
'type' => 'radio'
'choices' => array(
    'option1' => 'Label 1',
    'option2' => 'Label 2',
)

// Select dropdown
'type' => 'select'
'choices' => array(
    'value1' => 'Label 1',
    'value2' => 'Label 2',
)
```

### Special Control Classes

#### Image Upload Control
```php
$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'carousel_image_1', array(
        'label'    => __('Carousel Image 1', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_1',
    ))
);
```

**Features:**
- Upload button
- Media library access
- Image preview
- Remove button

#### Color Picker Control
```php
$wp_customize->add_control(
    new WP_Customize_Color_Control($wp_customize, 'theme_background_color', array(
        'label'    => __('Background Color', 'wdpf68'),
        'section'  => 'wdpf68_styling_section',
        'settings' => 'theme_background_color',
    ))
);
```

**Features:**
- Color picker interface
- Hex color input
- Visual color selection

### Control Type Comparison

| Control Type | Use Case | Example |
|--------------|----------|---------|
| `text` | Short text input | Site tagline |
| `url` | Website links | Social media URLs |
| `textarea` | Long text/code | Analytics code |
| `WP_Customize_Image_Control` | Image upload | Logo, carousel images |
| `WP_Customize_Color_Control` | Color selection | Theme colors |
| `checkbox` | On/off toggle | Show/hide feature |
| `select` | Multiple options | Layout choices |

---

## 7. Retrieving Values

### get_theme_mod()
Default method for customizer settings.

```php
// Get single value
$facebook_url = get_theme_mod('social_facebook');

// Get with default fallback
$bg_color = get_theme_mod('theme_background_color', '#ffffff');

// Check if exists
if (get_theme_mod('carousel_image_1')) {
    // Do something
}
```

### Using in Templates
```php
// In header.php
<body style="background-color: <?php echo esc_attr(get_theme_mod('theme_background_color', '#fff')); ?>;">

// In footer.php
<?php if (get_theme_mod('social_facebook')) : ?>
    <a href="<?php echo esc_url(get_theme_mod('social_facebook')); ?>">Facebook</a>
<?php endif; ?>

// In functions.php
function my_custom_styles() {
    $text_color = get_theme_mod('theme_text_color', '#333');
    echo '<style>body { color: ' . esc_attr($text_color) . '; }</style>';
}
add_action('wp_head', 'my_custom_styles');
```

### Helper Functions (from customize-fields.php)

```php
// Get all carousel images
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

// Usage
$carousel_images = wdpf68_get_carousel_images();
foreach ($carousel_images as $image) {
    echo '<img src="' . esc_url($image) . '">';
}
```

```php
// Get all social links
function wdpf68_get_social_links() {
    return array(
        'facebook'  => get_theme_mod('social_facebook'),
        'twitter'   => get_theme_mod('social_twitter'),
        'instagram' => get_theme_mod('social_instagram'),
        'youtube'   => get_theme_mod('social_youtube'),
    );
}

// Usage
$social = wdpf68_get_social_links();
if ($social['facebook']) {
    echo '<a href="' . esc_url($social['facebook']) . '">Facebook</a>';
}
```

---

## 8. Complete Workflow

### Step-by-Step Example: Adding Carousel Image

#### Step 1: Register with Customizer Hook
```php
function wdpf68_customize_register($wp_customize) {
    // All customizer code goes here
}
add_action('customize_register', 'wdpf68_customize_register');
```

#### Step 2: Create Section
```php
$wp_customize->add_section('wdpf68_carousel_section', array(
    'title'    => __('Carousel Settings', 'wdpf68'),
    'priority' => 30,
));
```

#### Step 3: Create Setting
```php
$wp_customize->add_setting('carousel_image_1', array(
    'default'   => '',
    'transport' => 'refresh',
));
```

#### Step 4: Create Control
```php
$wp_customize->add_control(
    new WP_Customize_Image_Control($wp_customize, 'carousel_image_1', array(
        'label'    => __('Carousel Image 1 (1600x500)', 'wdpf68'),
        'section'  => 'wdpf68_carousel_section',
        'settings' => 'carousel_image_1',
    ))
);
```

#### Step 5: Retrieve in Template
```php
$image = get_theme_mod('carousel_image_1');
if ($image) {
    echo '<img src="' . esc_url($image) . '" alt="Carousel">';
}
```

### Data Flow Diagram
```
User uploads image in Customizer
    ↓
WP_Customize_Image_Control (UI)
    ↓
carousel_image_1 setting
    ↓
Saved to wp_options table as theme_mod
    ↓
get_theme_mod('carousel_image_1') retrieves URL
    ↓
Display in template
```

---

## 9. Carousel Implementation

### How Index.php Shows Carousel

#### Index.php Structure
```php
<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS -->
</head>
<body>
    <div class="container">
        <?php get_template_part('includes/carousel'); ?>
        <!-- Other content -->
    </div>
    <!-- Bootstrap JS -->
</body>
</html>
```

**Key Function:** `get_template_part('includes/carousel')`
- Looks for `includes/carousel.php`
- Includes the file content
- Equivalent to: `include(get_template_directory() . '/includes/carousel.php');`

### includes/carousel.php Breakdown

```php
<?php
// STEP 1: Get images from customizer
$carousel_images = wdpf68_get_carousel_images();

// STEP 2: Check if images exist
if (!empty($carousel_images)) :
?>

<!-- STEP 3: Bootstrap carousel structure -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  
  <!-- STEP 4: Generate indicators dynamically -->
  <div class="carousel-indicators">
    <?php foreach ($carousel_images as $index => $image) : ?>
      <button type="button" 
              data-bs-target="#carouselExampleIndicators" 
              data-bs-slide-to="<?php echo $index; ?>" 
              <?php echo ($index === 0) ? 'class="active"' : ''; ?> 
              aria-label="Slide <?php echo $index + 1; ?>">
      </button>
    <?php endforeach; ?>
  </div>
  
  <!-- STEP 5: Generate carousel items dynamically -->
  <div class="carousel-inner">
    <?php foreach ($carousel_images as $index => $image) : ?>
      <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
        <img src="<?php echo esc_url($image); ?>" 
             class="d-block w-100" 
             alt="Slide <?php echo $index + 1; ?>">
      </div>
    <?php endforeach; ?>
  </div>
  
  <!-- STEP 6: Navigation controls -->
  <button class="carousel-control-prev" type="button" 
          data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" 
          data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<?php endif; ?>
```

### Carousel Logic Explained

#### 1. Get Images
```php
$carousel_images = wdpf68_get_carousel_images();
```
- Calls helper function from `customize-fields.php`
- Returns array of image URLs: `['url1', 'url2', 'url3']`
- Only includes images that have been uploaded

#### 2. Check if Empty
```php
if (!empty($carousel_images)) :
```
- Prevents showing empty carousel
- Only displays if at least one image exists

#### 3. Generate Indicators
```php
<?php foreach ($carousel_images as $index => $image) : ?>
  <button data-bs-slide-to="<?php echo $index; ?>" 
          <?php echo ($index === 0) ? 'class="active"' : ''; ?>>
  </button>
<?php endforeach; ?>
```
- Creates one indicator per image
- First indicator gets `active` class
- `$index` starts at 0 (0, 1, 2, 3, 4)

#### 4. Generate Slides
```php
<?php foreach ($carousel_images as $index => $image) : ?>
  <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
    <img src="<?php echo esc_url($image); ?>" class="d-block w-100">
  </div>
<?php endforeach; ?>
```
- Creates one slide per image
- First slide gets `active` class
- `esc_url()` sanitizes URL for security

### Complete Data Flow

```
1. User uploads images in Customizer
   └── Appearance → Customize → Carousel Settings
   
2. Images saved to database
   └── wp_options → theme_mods_wdpf68 → carousel_image_1, carousel_image_2, etc.
   
3. Index.php loads
   └── Calls get_template_part('includes/carousel')
   
4. carousel.php executes
   └── Calls wdpf68_get_carousel_images()
   
5. Helper function retrieves images
   └── Loops through carousel_image_1 to carousel_image_5
   └── Uses get_theme_mod() for each
   └── Returns array of URLs
   
6. Carousel renders
   └── Loops through array
   └── Generates HTML for each image
   └── First image marked as active
   
7. Bootstrap JS handles interaction
   └── Slide transitions
   └── Indicator clicks
   └── Navigation buttons
```

---

## Comparison: add_option vs add_setting

### add_option() - Settings API
```php
// In theme-options.php
add_option('idborg_custom_option', ['round' => 68]);

// Retrieve
$data = get_option('idborg_custom_option');
echo $data['round']; // 68
```

**Characteristics:**
- Direct database storage
- No UI automatically created
- Requires manual form creation
- Used with Settings API
- Stored in `wp_options` table

### add_setting() - Customizer API
```php
// In customize-fields.php
$wp_customize->add_setting('carousel_image_1', [...]);

// Retrieve
$image = get_theme_mod('carousel_image_1');
```

**Characteristics:**
- Stored as theme_mod
- UI created with add_control()
- Live preview capability
- Used with Customizer API
- Stored in `wp_options` as serialized theme_mods

---

## Best Practices

### 1. Always Sanitize Output
```php
// URLs
echo esc_url($url);

// Attributes
echo esc_attr($value);

// HTML
echo wp_kses_post($html);
```

### 2. Provide Defaults
```php
$color = get_theme_mod('theme_text_color', '#333333');
```

### 3. Check Before Using
```php
if (get_theme_mod('carousel_image_1')) {
    // Display image
}
```

### 4. Use Helper Functions
```php
// Instead of repeating get_theme_mod() everywhere
function wdpf68_get_carousel_images() {
    // Centralized logic
}
```

### 5. Organize by Section
```php
// Group related settings
- Carousel Section
  - carousel_image_1
  - carousel_image_2
- Social Section
  - social_facebook
  - social_twitter
```

---

## Testing Your Customizer

1. **Access Customizer:**
   - Go to: Appearance → Customize

2. **Find Your Sections:**
   - Look for "Carousel Settings", "Social Media Links", etc.

3. **Upload Images:**
   - Click "Carousel Image 1"
   - Upload or select from media library
   - Repeat for other images

4. **Check Live Preview:**
   - Changes should appear in preview pane
   - Click "Publish" to save

5. **Verify Frontend:**
   - Visit your site
   - Carousel should display uploaded images

6. **Check Database:**
   - phpMyAdmin → `wp_options`
   - Find `theme_mods_wdpf68`
   - Verify serialized data contains your settings

---

## Summary

### Key Concepts
- **Section**: Container for related controls
- **Setting**: Defines data storage
- **Control**: User interface element
- **theme_mod**: Customizer storage method

### Three-Step Pattern
```php
add_section()  → Creates container
add_setting()  → Defines storage
add_control()  → Creates UI
```

### Retrieval
```php
get_theme_mod('setting_id', 'default')
```

### Carousel Flow
```
Customizer → theme_mods → get_theme_mod() → Helper function → carousel.php → Display
```

The Customizer API provides a user-friendly way to manage theme options with live preview, while the Settings API offers more control for complex admin interfaces. Both store data in `wp_options`, but use different retrieval methods.
