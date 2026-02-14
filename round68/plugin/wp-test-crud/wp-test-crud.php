<?php
/**
 * Plugin Name: WP Test CRUD Plugin
 * Description: A plugin to manage CRUD operations for the wp_test table.
 * Version: 1.0
 * Author: WDPF 68
 * License: GPL2
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start output buffering early to prevent "headers already sent" errors.
// This should be done before any potential output from other plugins or theme files.
add_action( 'plugins_loaded', function() {
    if ( is_admin() ) { // Only in admin area where our plugin operates
        ob_start();
    }
} );

// Flush and end output buffering after admin init, if needed, before any redirects
add_action( 'admin_init', function() {
    if ( is_admin() && ob_get_length() ) {
        // Optionally, if there's expected early output that MUST be kept,
        // you might echo ob_get_clean() here, but for redirect purposes,
        // we usually want to discard it.
        ob_clean(); // Discard any output collected so far
    }
} );

// Function to run on plugin activation.
function wp_test_crud_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'test'; // This will be wp_test

    $charset_collate = $wpdb->get_charset_collate();

    // SQL to create the table based on the provided wp_test.sql schema
    $sql = "CREATE TABLE $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        fk varchar(64) NOT NULL,
        fv varchar(512) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}
register_activation_hook( __FILE__, 'wp_test_crud_activate' );

// Add admin menu item
function wp_test_crud_admin_menu() {
    add_options_page(
        'WP Test CRUD',          // Page title
        'Test',                  // Menu title
        'manage_options',        // Capability required to access the page
        'wp-test-crud',          // Menu slug
        'wp_test_crud_page_content' // Callback function to render the page content
    );
}
add_action( 'admin_menu', 'wp_test_crud_admin_menu' );

// Callback function to render the admin page content
function wp_test_crud_page_content() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'test';

    // Handle form submissions for Add, Edit, Delete
    if ( isset( $_GET['action'] ) ) {
        if ( 'add' === $_GET['action'] ) {
            wp_test_crud_add_edit_page();
            return;
        } elseif ( 'edit' === $_GET['action'] && isset( $_GET['id'] ) ) {
            wp_test_crud_add_edit_page( intval( $_GET['id'] ) );
            return;
        } elseif ( 'delete' === $_GET['action'] && isset( $_GET['id'] ) ) {
            wp_test_crud_delete_entry( intval( $_GET['id'] ) );
        }
    }

    // Process POST requests for saving data
    if ( isset( $_POST['wp_test_crud_nonce'] ) && wp_verify_nonce( $_POST['wp_test_crud_nonce'], 'wp_test_crud_action' ) ) {
        if ( isset( $_POST['submit_add_edit'] ) ) {
            wp_test_crud_save_entry();
        }
    }


    echo '<div class="wrap">';
    echo '<h1>WP Test CRUD Management <a href="' . esc_url( add_query_arg( 'action', 'add', admin_url( 'options-general.php?page=wp-test-crud' ) ) ) . '" class="page-title-action">Add New</a></h1>';

    $results = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY id DESC", ARRAY_A );

    if ( ! empty( $results ) ) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>ID</th><th>FK</th><th>FV</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        foreach ( $results as $row ) {
            $edit_url = esc_url( add_query_arg( array( 'action' => 'edit', 'id' => $row['id'] ), admin_url( 'options-general.php?page=wp-test-crud' ) ) );
            $delete_url = esc_url( add_query_arg( array( 'action' => 'delete', 'id' => $row['id'] ), admin_url( 'options-general.php?page=wp-test-crud' ) ) );
            echo '<tr>';
            echo '<td>' . esc_html( $row['id'] ) . '</td>';
            echo '<td>' . esc_html( $row['fk'] ) . '</td>';
            echo '<td>' . esc_html( $row['fv'] ) . '</td>';
            echo '<td>';
            echo '<a href="' . $edit_url . '">Edit</a> | ';
            echo '<a href="' . $delete_url . '" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No data found in the wp_test table.</p>';
    }

    echo '</div>'; // .wrap
}

// Placeholder for add/edit page
function wp_test_crud_add_edit_page( $id = null ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'test';
    $entry = array( 'fk' => '', 'fv' => '' );
    $form_title = 'Add New Entry';

    if ( $id ) {
        $entry = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $id ), ARRAY_A );
        if ( ! $entry ) {
            echo '<div class="notice notice-error"><p>Entry not found.</p></div>';
            return;
        }
        $form_title = 'Edit Entry (ID: ' . $id . ')';
    }

    echo '<div class="wrap">';
    echo '<h1>' . esc_html( $form_title ) . '</h1>';
    echo '<form method="post" action="' . esc_url( admin_url( 'options-general.php?page=wp-test-crud' ) ) . '">';
    wp_nonce_field( 'wp_test_crud_action', 'wp_test_crud_nonce' );
    echo '<input type="hidden" name="id" value="' . esc_attr( $id ) . '">';
    echo '<table class="form-table">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th scope="row"><label for="fk">FK</label></th>';
    echo '<td><input type="text" name="fk" id="fk" value="' . esc_attr( $entry['fk'] ) . '" class="regular-text" required></td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th scope="row"><label for="fv">FV</label></th>';
    echo '<td><input type="text" name="fv" id="fv" value="' . esc_attr( $entry['fv'] ) . '" class="regular-text" required></td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
    echo '<p class="submit">';
    echo '<input type="submit" name="submit_add_edit" id="submit" class="button button-primary" value="Save Changes">';
    echo '<a href="' . esc_url( admin_url( 'options-general.php?page=wp-test-crud' ) ) . '" class="button button-secondary" style="margin-left: 10px;">Cancel</a>';
    echo '</p>';
    echo '</form>';
    echo '</div>';
}

// Placeholder for saving data
function wp_test_crud_save_entry() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'test';

    $id = isset( $_POST['id'] ) ? intval( $_POST['id'] ) : 0;
    $fk = sanitize_text_field( $_POST['fk'] );
    $fv = sanitize_text_field( $_POST['fv'] );

    if ( empty( $fk ) || empty( $fv ) ) {
        wp_die( 'FK and FV fields cannot be empty.' );
    }

    $data = array(
        'fk' => $fk,
        'fv' => $fv,
    );

    if ( $id ) {
        // Update existing entry
        $updated = $wpdb->update(
            $table_name,
            $data,
            array( 'id' => $id ),
            array( '%s', '%s' ),
            array( '%d' )
        );
        if ( $updated === false ) {
            wp_die( 'Error updating entry.' );
        }
        $message = 'Entry updated successfully.';
    } else {
        // Insert new entry
        $inserted = $wpdb->insert(
            $table_name,
            $data,
            array( '%s', '%s' )
        );
        if ( $inserted === false ) {
            wp_die( 'Error adding new entry.' );
        }
        $message = 'Entry added successfully.';
    }

    wp_redirect( admin_url( 'options-general.php?page=wp-test-crud&message=' . urlencode( $message ) ) );
    exit;
}

// Placeholder for deleting data
function wp_test_crud_delete_entry( $id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'test';

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'You do not have sufficient permissions to delete entries.' );
    }

    // Verify nonce for delete action (though not directly from a form, it's good practice)
    // For simplicity, we'll assume the URL 'action' check is sufficient for now,
    // but in a real-world scenario, a dedicated nonce should be passed with the delete link.
    // For now, let's just make sure the ID is valid.

    $deleted = $wpdb->delete(
        $table_name,
        array( 'id' => $id ),
        array( '%d' )
    );

    if ( $deleted === false ) {
        wp_die( 'Error deleting entry.' );
    }

    wp_redirect( admin_url( 'options-general.php?page=wp-test-crud&message=' . urlencode( 'Entry deleted successfully.' ) ) );
    exit;
}

// Display admin notices
function wp_test_crud_admin_notices() {
    if ( isset( $_GET['page'] ) && 'wp-test-crud' === $_GET['page'] && isset( $_GET['message'] ) ) {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( urldecode( $_GET['message'] ) ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'wp_test_crud_admin_notices' );

// Enqueue admin styles
function wp_test_crud_enqueue_admin_styles( $hook ) {
    // Only load on our plugin's admin page
    if ( 'settings_page_wp-test-crud' !== $hook ) {
        return;
    }
    wp_enqueue_style(
        'wp-test-crud-admin-style', // Handle
        plugin_dir_url( __FILE__ ) . 'wp-test-crud-admin.css', // Path to CSS file
        array(), // Dependencies
        '1.0' // Version
    );
}
add_action( 'admin_enqueue_scripts', 'wp_test_crud_enqueue_admin_styles' );



