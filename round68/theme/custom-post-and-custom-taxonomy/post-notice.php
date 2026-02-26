<?php
function magazine_lume_post_notice(){
    $args = array(
        'public' => true,
        'label' => 'Notice'
    );
    register_post_type('notice',$args);
}


add_action("init","magazine_lume_post_notice");