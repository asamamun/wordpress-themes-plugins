<?php
class My_Custom_Widget extends WP_Widget {

    // 1. Constructor
    public function __construct() {
        parent::__construct(
            'my_custom_widget', // Base ID
            __('My Custom Widget 77', 'textdomain'), // Name
            array('description' => __('A simple custom widget', 'textdomain'))
        );
    }

    // 2. Frontend display
    public function widget($args, $instance) {
        echo $args['before_widget'];

        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        echo "<p>This is my custom widget output.</p>";

        echo $args['after_widget'];
    }

    // 3. Widget form (Admin)
    public function form($instance) {
        $title = isset($instance['title']) ? $instance['title'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input 
                class="widefat"
                id="<?php echo $this->get_field_id('title'); ?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                type="text"
                value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    // 4. Save widget options
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = sanitize_text_field($new_instance['title']);
        return $instance;
    }
}
//without registration widget will not shown
function register_my_custom_widget() {
    register_widget('My_Custom_Widget');
    //register sidebar //register widgets area
        register_sidebar(array(
        'name' => 'Test Sidebar',
        'id' => 'sidebar-7',
        'description' => 'Sidebar for wdpf68 theme',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

}
add_action('widgets_init', 'register_my_custom_widget');

/*
add this code in your themes index to show sidebar
<?php if (is_active_sidebar('sidebar-7')) : ?>
    <div class="sidebar">
        <?php dynamic_sidebar('sidebar-7'); ?>
    </div>
<?php endif; ?>
<div class="col-md-4">
or
<?php
            //if sidebar-7 exists show otherwise show archive widget
            if (is_active_sidebar('sidebar-7')) {
                dynamic_sidebar('sidebar-7');
            } else {
                //show calender
                the_widget('WP_Widget_Calendar');
            }
            ?>
</div>



