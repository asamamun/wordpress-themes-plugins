<?php 
add_action( 'init', 'notice_type_taxonomy' );
function notice_type_taxonomy() {
    register_taxonomy(
        'type', 
        'notice',
        array( 
            'hierarchical' => true,
            'label'        => 'Type',
'query_var' => true,
            'rewrite'      => true
) 
);
//add mood taxonomy in post 
    register_taxonomy(
        'mood', 
        'post',
        array( 
            'hierarchical' => true,
            'label'        => 'Mood',
'query_var'
    => true,
            'rewrite'      => true,
            'show_ui'      => true,
            'show_in_menu' => true,
            'show_in_rest' => true
) 
);
} 
?> 