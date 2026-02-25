<?php
//add option 
/* add_action('admin_menu', 'wdpf68_add_option');
function wdpf68_add_option() {
    $classinfo = [
        'round' => 68,
        'batch' => 'wdpf',
        'tsp' => 'gnsl',
        'shift' => 'afternoon',
    ];
    // add a new option , //you can add any option to wp_options table using this
    add_option('idborg_custom_option', $classinfo);
} */
//delete option when this theme is deactive
/* add_action('after_switch_theme', 'wdpf68_delete_option');
function wdpf68_delete_option() {
    delete_option('idborg_custom_option');
} */

//add_menu_page( page_title, menu_title, capability,menu_slug, function, icon_url, position );
function idb_add_admin_menu() {
    $classinfo = [
        'round' => 68,
        'batch' => 'wdpf',
        'tsp' => 'gnsl',
        'shift' => 'afternoon',
        'fav_color' => '#ff0000',
    ];
    // add a new option , //you can add any option to wp_options table using this
    add_option('idborg_custom_option', $classinfo);

    add_menu_page('Round68', 'GNSL 68', 'manage_options', 'theme_customizer', 'tct_options_page', 'dashicons-admin-customizer', 4);
    // add_options_page('Round68', 'GNSL 68', 'manage_options', 'theme_customizer', 'tct_options_page',);
     //create two sub-menus: settings and support
    add_submenu_page( 'theme_customizer', 'Eid Settings Page', 
        'Settings', 'manage_options', 'eid_settings',
'prowp_settings_page' );
    add_submenu_page( 'theme_customizer', 'Eid Support Page', 
        'Support', 'manage_options', 'eid_support', 'prowp_support_page' );
        //call register settings function
    add_action( 'admin_init', 'prowp_register_settings' ); 
}
 function prowp_register_settings() {
   
     //register our settings 
     register_setting( 'prowp-settings-group', 'idborg_custom_option' );
   
 } 
add_action('admin_menu', 'idb_add_admin_menu');

function prowp_settings_page(){
    ?>
    <div class="wrap">
        <h1>Eid Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'prowp-settings-group' ); ?>
            <?php $prowp_options = get_option( 'idborg_custom_option' ); 
            var_dump($prowp_options);
            ?>
            
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="round">Round</label></th>
                    <td>
                        <input type="text" id="round" name="idborg_custom_option[round]" value="<?php echo esc_attr( $prowp_options['round'] ); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="batch">Batch</label></th>
                    <td>
                        <input type="text" id="batch" name="idborg_custom_option[batch]" value="<?php echo esc_attr( $prowp_options['batch'] ); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="tsp">TSP</label></th>
                    <td>
                        <input type="text" id="tsp" name="idborg_custom_option[tsp]" value="<?php echo esc_attr( $prowp_options['tsp'] ); ?>" class="regular-text" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="shift">Shift</label></th>
                    <td>
                        <input type="text" id="shift" name="idborg_custom_option[shift]" value="<?php echo esc_attr( $prowp_options['shift'] ); ?>" class="regular-text" />
                    </td>
                </tr>
                <!-- add color option for fav color -->
                <tr>
                    <th scope="row"><label for="fav_color">Fav Color</label></th>
                    <td>
                        <input type="color" id="fav_color" name="idborg_custom_option[fav_color]" value="<?php echo esc_attr( $prowp_options['fav_color'] ); ?>" class="regular-text" />
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

//prowp_support_page
function prowp_support_page(){
    echo '<div class="wrap">';
    echo '<h1>Eid Support Page</h1>';
    echo '<p>This is the support page for Eid.</p>';
    echo '</div>';
}


?>    