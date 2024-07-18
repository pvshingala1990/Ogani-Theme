<?php

function enqueue_custom_scripts_social()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-user-social', TWC_OGANI_JS . 'custom-user-social.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-user-social', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'), // URL to admin-ajax.php for AJAX requests
        'site_url' => get_site_url(), // URL of the current site
    ));
}

// Ensure scripts are loaded in the admin area and on the user profile page
function enqueue_admin_custom_scripts($hook_suffix)
{
    if ('profile.php' === $hook_suffix || 'user-edit.php' === $hook_suffix) {
        enqueue_custom_scripts_social();
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_custom_scripts');


function custom_user_social_media_fields($user)
{
    $social_media_links = get_user_meta($user->ID, 'social_media_links', true);
?>
    <h3><?php _e("Social Media Links", "blank"); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="social_media_links"><?php _e("Social Media Links"); ?></label></th>
            <td>
                <div id="social-media-repeater">
                    <?php if (!empty($social_media_links)) {
                        foreach ($social_media_links as $link) { ?>
                            <div class="social-media-item">
                                <select name="social_media_class[]">
                                    <option value="" <?php selected($link['class'], ''); ?>>Select Social Media</option>
                                    <option value="fa-facebook" <?php selected($link['class'], 'fa-facebook'); ?>>Facebook</option>
                                    <option value="fa-twitter" <?php selected($link['class'], 'fa-twitter'); ?>>Twitter</option>
                                    <option value="fa-instagram" <?php selected($link['class'], 'fa-instagram'); ?>>Instagram</option>
                                    <option value="fa-google-plus" <?php selected($link['class'], 'fa-google-plus'); ?>>Google+</option>
                                </select>
                                <input type="url" name="social_media_url[]" value="<?php echo esc_attr($link['url']); ?>" placeholder="Enter URL" />
                                <select name="social_media_new_tab[]">
                                    <option value="">Open in a new tab?</option>
                                    <option value="yes" <?php selected($link['new_tab'], 'yes'); ?>>Yes</option>
                                    <option value="no" <?php selected($link['new_tab'], 'no'); ?>>No</option>
                                </select>
                                <button type="button" class="remove-social-media">Remove</button>
                            </div>
                        <?php }
                    } else { ?>
                        <div class="social-media-item">
                            <select name="social_media_class[]">
                                <option value="">Select Social Media</option>
                                <option value="fa-facebook">Facebook</option>
                                <option value="fa-twitter">Twitter</option>
                                <option value="fa-instagram">Instagram</option>
                                <option value="fa-google-plus">Google+</option>
                            </select>
                            <input type="url" name="social_media_url[]" placeholder="Enter URL" />
                            <select name="social_media_new_tab[]">
                                <option value="">Open in a new tab?</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                            <button type="button" class="remove-social-media">Remove</button>
                        </div>
                    <?php } ?>
                </div>
                <button type="button" id="add-social-media">Add Social Media</button>
            </td>
        </tr>
    </table>
<?php
}

add_action('show_user_profile', 'custom_user_social_media_fields');
add_action('edit_user_profile', 'custom_user_social_media_fields');

// Save the custom user profile fields
function save_custom_user_social_media_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    $social_media_links = [];
    if (isset($_POST['social_media_class']) && isset($_POST['social_media_url'])) {
        for ($i = 0; $i < count($_POST['social_media_class']); $i++) {
            if (!empty($_POST['social_media_class'][$i]) && !empty($_POST['social_media_url'][$i])) {
                $social_media_links[] = [
                    'class' => sanitize_text_field($_POST['social_media_class'][$i]),
                    'url' => esc_url($_POST['social_media_url'][$i]),
                    'new_tab' => sanitize_text_field($_POST['social_media_new_tab'][$i]), // Use sanitize_text_field for dropdown value
                ];
            }
        }
    }

    update_user_meta($user_id, 'social_media_links', $social_media_links);
}

add_action('personal_options_update', 'save_custom_user_social_media_fields');
add_action('edit_user_profile_update', 'save_custom_user_social_media_fields');

// Function to get social media links HTML
function get_social_media_links_html($user_id)
{
    $social_media_links = get_user_meta($user_id, 'social_media_links', true);
    $html = '';

    if (!empty($social_media_links)) {
        $html .= '<div class="blog__details__social">';

        foreach ($social_media_links as $link) {
            $target_attr = ($link['new_tab'] === 'yes') ? 'target="_blank"' : '';
            $html .= '<a href="' . esc_url($link['url']) . '" ' . $target_attr . '><i class="fa ' . esc_attr($link['class']) . '"></i></a>';
        }

        $html .= '</div>';
    }

    return $html;
}

// Display the social media links on the blog details page
function display_social_media_links()
{
    global $post;

    // Check if the post author has social media links
    if ($post && $post->post_author) {
        $social_media_html = get_social_media_links_html($post->post_author);

        // Display the social media links if available
        if ($social_media_html) {
            echo $social_media_html;
        }
    }
}

// Add social media links to the blog details
add_action('blog_details_social_media', 'display_social_media_links');
