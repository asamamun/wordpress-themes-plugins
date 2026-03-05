<?php
class Bootstrap_5_Navwalker extends Walker_Nav_Menu {

    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<ul class="dropdown-menu">';
    }

    function start_el(&$output, $item, $depth=0, $args=null, $id=0) {

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        $class_names = 'nav-item';
        if ($has_children) {
            $class_names .= ' dropdown';
        }

        $output .= '<li class="' . esc_attr($class_names) . '">';

        $atts = array();
        $atts['href'] = !empty($item->url) ? $item->url : '';

        if ($has_children && $depth === 0) {
            $atts['class'] = 'nav-link dropdown-toggle';
            $atts['data-bs-toggle'] = 'dropdown';
            $atts['aria-expanded'] = 'false';
        } else {
            $atts['class'] = $depth > 0 ? 'dropdown-item' : 'nav-link';
        }

        $attributes = '';
        foreach ($atts as $attr => $value) {
            $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
        }

        $output .= '<a' . $attributes . '>';
        $output .= esc_html($item->title);
        $output .= '</a>';
    }
}