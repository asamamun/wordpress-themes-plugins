<?php
//create dynamic sidebar named 'sidebar-1'
function wdpf68_sidebar() {
    register_sidebar(array(
        'name' => 'Right Sidebar',
        'id' => 'sidebar-right',
        'description' => 'Sidebar for bs5wdpf68 theme',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'wdpf68_sidebar');