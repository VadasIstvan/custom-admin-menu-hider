<?php
/*
Plugin Name: Custom Admin Menu Hider
Description: Removes specific admin menu items for non-admin users and adds a custom dashboard widget.
Version: 1.0
Author: WhiteX
*/

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

// Function to add a custom dashboard widget
function custom_dashboard_widget()
{
    echo '<div class="custom-dashboard-widget">';
    echo '<h2 style="font-size: 24px;">Support</h2>';
    echo '<p>Welcome to the CMS section of your website.</p>';
    echo '<p>If you encounter any problems please reach out to <a href="mailto:contact@whitex.design">contact@whitex.design</a></p>';
    echo '</div>';
}

// Hook to add the custom dashboard widget at the top
function add_custom_dashboard_widgets()
{
    wp_add_dashboard_widget('custom_dashboard_widget', 'Custom Dashboard Widget', 'custom_dashboard_widget');

    // Reorder the widgets to make the custom widget appear first
    global $wp_meta_boxes;
    $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
    $custom_widget = array('custom_dashboard_widget' => $normal_dashboard['custom_dashboard_widget']);
    unset($normal_dashboard['custom_dashboard_widget']);
    $sorted_dashboard = array_merge($custom_widget, $normal_dashboard);
    $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}

add_action('wp_dashboard_setup', 'add_custom_dashboard_widgets');
