<?php
/* 
* Dequeue Parent theme style css file
*/

// Function to deregister the parent theme's stylesheet
function deregister_parent_theme_styles()
{
    wp_dequeue_style('twentytwentyone-style');
    wp_deregister_style('twentytwentyone-style');
}
add_action('wp_enqueue_scripts', 'deregister_parent_theme_styles', 20);

// Enqueue parent theme styles
function new_ogani_2021_enqueue_styles()
{
    wp_dequeue_style('twenty-twenty-one-style');
    wp_enqueue_style('child-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version'));
}
add_action('wp_enqueue_scripts', 'new_ogani_2021_enqueue_styles', 11);


/*
* define a path and include the css & js file.
*/
if (!defined('TWC_OGANI_URL')) {
    define('TWC_OGANI_URL', get_stylesheet_directory_uri());
    define('TWC_OGANI_JS', get_stylesheet_directory_uri() . '/assets/js/');
    define('TWC_OGANI_CSS', get_stylesheet_directory_uri() . '/assets/css/');
    define('TWC_OGANI_IMAGES', get_stylesheet_directory_uri() . '/assets/img/');
    define('TWC_OGANI_VERSION', '1.10');
}

/**
 * To register and enque the theme styles and js
 */
function ogani_child_enqueue_styles()
{
    /* enqueue style css fiel */
    wp_enqueue_style('bootstrap', TWC_OGANI_CSS . 'bootstrap.min.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('font-awesome', TWC_OGANI_CSS . 'font-awesome.min.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('elegant-icons', TWC_OGANI_CSS . 'elegant-icons.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('nice-select', TWC_OGANI_CSS . 'nice-select.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('jquery-ui', TWC_OGANI_CSS . 'jquery-ui.min.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('owl.carousel', TWC_OGANI_CSS . 'owl.carousel.min.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('slicknav', TWC_OGANI_CSS . 'slicknav.min.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('style', TWC_OGANI_CSS . 'style.css', array(), TWC_OGANI_VERSION, 'all');
    wp_enqueue_style('style', TWC_OGANI_URL . 'style.css', array(), TWC_OGANI_VERSION, 'all');

    /* enqueue js file */
    wp_enqueue_script('jquery', TWC_OGANI_JS . 'jquery-3.3.1.min.js', NULL, NULL, true);
    wp_enqueue_script('bootstrap', TWC_OGANI_JS . 'bootstrap.min.js', NULL, NULL, true);
    wp_enqueue_script('nice-select', TWC_OGANI_JS . 'jquery.nice-select.min.js', NULL, NULL, true);
    wp_enqueue_script('jquery-ui', TWC_OGANI_JS . 'jquery-ui.min.js', NULL, NULL, true);
    wp_enqueue_script('slicknav', TWC_OGANI_JS . 'jquery.slicknav.js', NULL, NULL, true);
    wp_enqueue_script('mixitup', TWC_OGANI_JS . 'mixitup.min.js', NULL, NULL, true);
    wp_enqueue_script('owl-carousel', TWC_OGANI_JS . 'owl.carousel.min.js', NULL, NULL, true);
    wp_enqueue_script('main', TWC_OGANI_JS . 'main.js', NULL, NULL, true);
}
add_action('wp_enqueue_scripts', 'ogani_child_enqueue_styles', 999);

require_once 'inc/admin-social-media.php';
require_once 'inc/custom_woocommerce.php';


// Define a function to enqueue custom scripts
function enqueue_custom_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-ajax-sorting', TWC_OGANI_JS . 'custom-ajax-sorting.js', array('jquery'), '1.0', true);
    wp_localize_script('custom-ajax-sorting', 'ajax_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'site_url' => get_site_url(),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



/* Register ACF Option page
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => __('Theme Settings', 'twc-ogani'),
        'menu_title'    => __('Theme Settings', 'twc-ogani'),
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => __('Header Settings', 'twc-ogani'),
        'menu_title'    => __('Header', 'twc-ogani'),
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => __('Footer Settings', 'twc-ogani'),
        'menu_title'    => __('Footer', 'twc-ogani'),
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => __('Information Settings', 'twc-ogani'),
        'menu_title'    => __('Information', 'twc-ogani'),
        'parent_slug'   => 'theme-general-settings',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => __('Blog Detail And Archive Page', 'twc-ogani'),
        'menu_title'    => __('Blog Pages', 'twc-ogani'),
        'parent_slug'   => 'theme-general-settings',
    ));
}

/*
Register custom menu for header and footer
*/
function register_custom_menu()
{
    register_nav_menus(array(
        'header' => __('Header Menu', 'twc-ogani'),
        'footer1'  => __('Footer Column 1', 'twc-ogani'),
        'footer2'  => __('Footer Column 2', 'twc-ogani')
    ));
}
add_action('init', 'register_custom_menu');

/**
 * Break string half for sidebar bloglist
 */
function insert_break_at_half($string)
{
    $length = strlen($string);
    $middle = intval($length / 2);
    $breakpoint = strpos($string, ' ', $middle);

    if ($breakpoint === false) {
        $breakpoint = strrpos($string, ' ', - (strlen($string) - $middle));
    }

    if ($breakpoint === false) {
        $breakpoint = $middle;
    }

    return substr($string, 0, $breakpoint) . '<br>' . substr($string, $breakpoint + 1);
}

/* 
register custom breadcrumb
 */
function custom_breadcrumb()
{
    $post_id = get_queried_object_id();
    $breadcrumbs = array();

    $breadcrumbs[] = '<a href="' . home_url('/') . '">' . __('Home', 'twc-ogani') . '</a>';

    $ancestors = get_post_ancestors($post_id);

    if ($ancestors) {
        $ancestors = array_reverse($ancestors);

        foreach ($ancestors as $ancestor) {
            $breadcrumbs[] = '<a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a>';
        }
    }

    $breadcrumbs[] = '<span>' . get_the_title($post_id) . '</span>';

    echo ' <div class="breadcrumb__option">' . implode(' ', $breadcrumbs) . '</div>';
}


/**
 * Blog Post fetch by the category, tag, or search query
 */
function ajax_fetch_posts_by_filter()
{
    // Check for filter type and page number
    $filter_type = isset($_POST['filter_type']) ? sanitize_text_field($_POST['filter_type']) : '';
    $filter_id = isset($_POST['filter_id']) ? sanitize_text_field($_POST['filter_id']) : '';
    $tag_filter = isset($_POST['tag_filter']) ? sanitize_text_field($_POST['tag_filter']) : '';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Set up query arguments
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'paged'          => $paged,
    );

    // Handle category filter
    if ($filter_type === 'category' && !empty($filter_id) && $filter_id !== 'all') {
        $args['cat'] = intval($filter_id);
    }

    // Handle tag filter
    if (!empty($tag_filter) && $tag_filter !== 'all') {
        $args['tag_id'] = intval($tag_filter);
    }

    // Handle search filter
    if ($filter_type === 'search' && isset($_POST['search_query'])) {
        $search_query = sanitize_text_field($_POST['search_query']);
        if (!empty($search_query)) {
            $args['s'] = $search_query;
        }
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/loop/blog-item');
        }
        wp_reset_postdata();

        // Output pagination
        $total_pages = $query->max_num_pages;
        if ($total_pages > 1) {
            echo '<div class="col-lg-12">';
            echo '<div class="product__pagination blog__pagination">';
            echo paginate_links(array(
                'base'      => '%_%',
                'format'    => '#page/%#%',
                'current'   => $paged,
                'total'     => $total_pages,
                'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
                'next_text' => '<i class="fa fa-long-arrow-right"></i>',
            ));
            echo '</div>';
            echo '</div>';
        }

        $response = ob_get_clean();
        wp_send_json_success($response);
    } else {
        wp_send_json_error('No posts found');
    }
}
add_action('wp_ajax_nopriv_ajax_fetch_posts_by_filter', 'ajax_fetch_posts_by_filter');
add_action('wp_ajax_ajax_fetch_posts_by_filter', 'ajax_fetch_posts_by_filter');

/**
 * Custom login URL for WooCommerce login form
 */
function custom_wc_login_url() {
    return home_url('/form-login'); // Replace '/custom-login' with your desired custom URL slug
}
add_filter('woocommerce_login_redirect', 'custom_wc_login_url', 10, 2);
