# WP Test CRUD Plugin

## Overview

The WP Test CRUD Plugin is a simple WordPress plugin designed to provide a full Create, Read, Update, and Delete (CRUD) interface for a custom database table named `wp_test`. This plugin is ideal for developers who need to manage custom data within the WordPress admin area without writing extensive custom code.

## Features

*   **Custom Table Creation**: Automatically creates the `wp_test` table upon plugin activation if it does not already exist.
*   **Admin Menu Integration**: Adds a "Test" menu item under the "Settings" (Options) menu in the WordPress administration panel for easy access.
*   **CRUD Operations**:
    *   **Create**: Add new entries to the `wp_test` table.
    *   **Read**: View all existing entries in a paginated, sortable table.
    *   **Update**: Edit existing entries.
    *   **Delete**: Remove entries from the table.
*   **User-Friendly Interface**: Provides a clean and intuitive admin interface, leveraging WordPress's built-in styling and UI components.
*   **Security**: Includes basic nonce verification and data sanitization for form submissions.

## Installation

1.  **Upload**: Upload the `wp-test-crud.php` file and `wp-test-crud-admin.css` to the `/wp-content/plugins/` directory of your WordPress installation.
2.  **Activate**: Activate the plugin through the 'Plugins' menu in WordPress.
3.  **Table Creation**: Upon activation, the plugin will automatically create the `wp_test` table in your WordPress database if it doesn't already exist.

## Usage

1.  After activating the plugin, navigate to **Settings > Test** in your WordPress admin dashboard.
2.  You will see a table listing all existing entries in the `wp_test` table.
3.  **To Add a New Entry**: Click the "Add New" button at the top of the page. Fill in the 'FK' and 'FV' fields and click "Save Changes".
4.  **To Edit an Entry**: Click the "Edit" link next to the entry you wish to modify. Update the 'FK' and 'FV' fields and click "Save Changes".
5.  **To Delete an Entry**: Click the "Delete" link next to the entry you wish to remove. Confirm the deletion when prompted.

## `wp_test` Table Schema

The plugin manages the `wp_test` table with the following structure:

| Column Name | Type        | Attributes      | Description                          |
| :---------- | :---------- | :-------------- | :----------------------------------- |
| `id`        | `int(11)`   | `PRIMARY KEY`, `AUTO_INCREMENT`, `NOT NULL` | Unique identifier for each entry.    |
| `fk`        | `varchar(64)` | `NOT NULL`      | A foreign key or identifier string.  |
| `fv`        | `varchar(512)`| `NOT NULL`      | A foreign value or data string.      |

## Plugin Functions and Purpose

Below is an explanation of the main functions used in the plugin:

*   **`wp_test_crud_activate()`**:
    *   **Purpose**: This function is executed when the plugin is activated.
    *   **Function**: It creates the `wp_test` database table if it doesn't already exist, using WordPress's `dbDelta` function for safe schema updates.

*   **`wp_test_crud_admin_menu()`**:
    *   **Purpose**: Registers the plugin's admin page in the WordPress dashboard menu.
    *   **Function**: Adds a submenu item named "Test" under the "Settings" (options-general.php) section, linking to the plugin's main CRUD interface.

*   **`wp_test_crud_page_content()`**:
    *   **Purpose**: Renders the main content of the plugin's admin page.
    *   **Function**: Displays a list of all entries from the `wp_test` table in a WordPress-style table. It also handles navigation to add, edit, and delete actions, and processes form submissions for saving data.

*   **`wp_test_crud_add_edit_page($id = null)`**:
    *   **Purpose**: Renders the form for adding new entries or editing existing ones.
    *   **Function**: If an `$id` is provided, it fetches the corresponding entry's data to pre-fill the form for editing. Otherwise, it presents an empty form for a new entry. Includes nonce fields for security.

*   **`wp_test_crud_save_entry()`**:
    *   **Purpose**: Processes the data submitted from the add/edit form.
    *   **Function**: Sanitizes the input fields (`fk`, `fv`), performs nonce verification, and then either inserts a new row or updates an existing row in the `wp_test` table based on whether an `id` is present. Redirects back to the main listing page with a success/error message.

*   **`wp_test_crud_delete_entry($id)`**:
    *   **Purpose**: Handles the deletion of entries from the `wp_test` table.
    *   **Function**: Verifies user capabilities and then deletes the entry corresponding to the provided `$id`. Redirects back to the main listing page with a success message.

*   **`wp_test_crud_admin_notices()`**:
    *   **Purpose**: Displays administrative notices (e.g., success messages) on the plugin's admin page.
    *   **Function**: Checks for `message` parameters in the URL and displays them as dismissible success notices.

*   **`wp_test_crud_enqueue_admin_styles($hook)`**:
    *   **Purpose**: Enqueues the custom CSS stylesheet for the plugin's admin page.
    *   **Function**: Ensures that `wp-test-crud-admin.css` is loaded only when the user is viewing the plugin's specific admin page, improving its visual aesthetics.

## Development Notes

*   **Output Buffering**: The plugin implements output buffering (`ob_start()`, `ob_clean()`) to prevent "Headers already sent" errors, which can occur due to conflicts with other plugins prematurely sending output before redirects.
*   **WordPress APIs**: This plugin adheres to WordPress coding standards and utilizes core WordPress functions (`$wpdb`, `dbDelta`, `add_options_page`, `wp_enqueue_style`, `wp_redirect`, `wp_nonce_field`, `wp_verify_nonce`, `sanitize_text_field`, `current_user_can`, etc.) for robust and secure integration.

## License

GPL2