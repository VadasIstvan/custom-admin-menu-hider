<?php
/*
Plugin Name: Custom Admin Menu Hider
Description: Removes specific admin menu items for non-admin users.
Version: 1.0
Author: WhiteX
*/

// Add this code to your theme's functions.php file or a custom plugin

function remove_admin_menu_items()
{
    // Get the current user's roles
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    // Check if the user is not an admin
    if (!in_array('administrator', $user_roles)) {
        // Specify the menu items you want to remove by their slug
        $menu_items_to_remove = array(
            'edit.php',           // Posts
            'upload.php',         // Media
            'users.php',          // Users
            'tools.php',          // Tools
            'options-general.php', // Settings
            'themes.php',         // Appearance
            'edit-comments.php',  // Comments
            'plugins.php',        // Plugins
        );

        // Loop through the menu items and remove them
        foreach ($menu_items_to_remove as $menu_item) {
            remove_menu_page($menu_item);
        }
    }
}

// Hook the function to the admin_menu action
add_action('admin_menu', 'remove_admin_menu_items');
