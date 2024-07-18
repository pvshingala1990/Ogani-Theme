<?php
function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'mytheme_add_woocommerce_support');


/* 
Woocommerce product category list display
 */
function display_product_categories_list()
{
    $args = array(
        'taxonomy'   => 'product_cat',
        'orderby'    => 'name',
        'hide_empty' => true,
    );

    $product_categories = get_terms($args);

    if (!empty($product_categories) && !is_wp_error($product_categories)) {

        $categories_with_dates = array();

        foreach ($product_categories as $category) {

            $term_meta = get_term_meta($category->term_id);
            $creation_date = isset($term_meta['created_at']) ? $term_meta['created_at'][0] : $category->term_id;

            $categories_with_dates[] = array(
                'category' => $category,
                'date' => $creation_date,
            );
        }

        usort($categories_with_dates, function ($a, $b) {
            return strcmp($b['date'], $a['date']);
        });

        echo '<ul class="product-categories-list">';
        foreach ($categories_with_dates as $category_with_date) {
            $category = $category_with_date['category'];
            $archive_url = get_category_link($category->term_id);
            echo '<li><a href="' . $archive_url . '" class="category-link">' . esc_html($category->name) . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>' . __('No categories found.', 'twc-ogani') . '</p>';
    }
}
add_shortcode('product_categories_list', 'display_product_categories_list');


function set_category_creation_date($term_id)
{
    if (!get_term_meta($term_id, 'created_at', true)) {
        update_term_meta($term_id, 'created_at', current_time('mysql'));
    }
}
add_action('created_product_cat', 'set_category_creation_date');


/**
 * Content Wrappers.
 *
 * @see woocommerce_output_content_wrapper()
 * @see woocommerce_output_content_wrapper_end()
 */
add_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 20);
add_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('init', function () {

    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
    remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
});


/**
 * custom product Review rating
 *  */
function custom_product_rating()
{
    global $product;

    if (!$product->get_rating_count()) {
        return;
    }

    $rating = $product->get_average_rating();

    echo '<div class="product__details__rating">';
    for ($i = 1; $i <= 5; $i++) {
        echo '<i class="fa ';
        if ($rating >= $i) {
            echo 'fa-star"></i>';
        } elseif ($rating + 0.5 === $i) {
            echo 'fa-star-half-o"></i>';
        } else {
            echo 'fa-star-o"></i>';
        }
    }
    echo '<span>(' . $product->get_rating_count() . ' reviews)</span>';
    echo '</div>';
}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('woocommerce_single_product_summary', 'custom_product_rating', 9);



/**
 *  Custom result count on shop page
 * */
function custom_result_count()
{
?>
    <div class="filter__item">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="filter__sort">
                    <span>Sort By</span>
                    <select name="orderby" class="orderby" aria-label="<?php esc_attr_e('Shop order'); ?>">
                        <?php
                        $orderby_options = array(
                            'menu_order' => __('Default sorting', 'woocommerce'),
                            'popularity' => __('Sort by popularity', 'woocommerce'),
                            'rating'     => __('Sort by average rating', 'woocommerce'),
                            'date'       => __('Sort by latest', 'woocommerce'),
                            'price'      => __('Sort by price: low to high', 'woocommerce'),
                            'price-desc' => __('Sort by price: high to low', 'woocommerce')
                        );

                        foreach ($orderby_options as $key => $value) {
                            echo '<option value="' . esc_attr($key) . '" ' . selected(isset($_GET['orderby']) ? $_GET['orderby'] : 'menu_order', $key, false) . '>' . esc_html($value) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <div class="filter__found">
                    <h6><span><?php echo wc_get_loop_prop('total'); ?></span> <?php echo __('Products found', 'woocommerce'); ?></h6>
                </div>
            </div>
            <div class="col-lg-4 col-md-3">
                <div class="filter__option">
                    <span class="icon_grid-2x2" onclick="setView('grid')"></span>
                    <span class="icon_ul" onclick="setView('list')"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        jQuery(function($) {
            $('.orderby').on('change', function() {
                var orderby = $(this).val();
                var url = '<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>';

                url = updateQueryStringParameter(url, 'orderby', orderby);

                window.location.href = url;
            });

            function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                } else {
                    return uri + separator + key + "=" + value;
                }
            }
        });
    </script>
    <?php
}
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('woocommerce_before_shop_loop', 'custom_result_count', 20);


/**
 * Sale off product display on shop page
 */
function display_discount_products()
{
    $sale_product_args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key'     => '_sale_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC'
            ),
            array(
                'key'     => '_min_variation_sale_price',
                'value'   => 0,
                'compare' => '>',
                'type'    => 'NUMERIC'
            )
        )
    );

    $sale_product_loop = new WP_Query($sale_product_args);

    if ($sale_product_loop->have_posts()) : ?>
        <div class="product__discount">
            <div class="section-title product__discount__title">
                <h2><?php echo __('Sale Off', 'twc-ogani'); ?></h2>
            </div>
            <div class="row">
                <div class="product__discount__slider owl-carousel">

                    <?php while ($sale_product_loop->have_posts()) : $sale_product_loop->the_post();
                        global $product;

                        $product_id = $product->get_id();
                        $add_to_cart_url = esc_url(add_query_arg('add-to-cart', $product_id));
                        $product_image_url = wp_get_attachment_url($product->get_image_id()); ?>

                        <div class="col-lg-4">
                            <div class="product__discount__item">
                                <div class="product__discount__item__pic set-bg" data-setbg=" <?php echo $product_image_url; ?> ">
                                    <div class="product__discount__percent">-<?php echo round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100) ?>%</div>
                                    <ul class="product__item__pic__hover">
                                        <li><a href="<?php echo $add_to_cart_url; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        <li><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></li>
                                    </ul>
                                </div>
                                <div class="product__discount__item__text">
                                    <span><?php echo strip_tags(wc_get_product_category_list($product_id, ', ', '', '')); ?></span>
                                    <h5><a href="<?php echo get_permalink(); ?> "><?php echo get_the_title(); ?></a></h5>
                                    <?php
                                    $sale_price = wc_price($product->get_sale_price());
                                    $sale_price_no_span = strip_tags($sale_price); ?>
                                    <div class="product__item__price"><?php echo $sale_price_no_span; ?> <span><?php echo wc_price($product->get_regular_price()); ?></span></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    <?php
        wp_reset_postdata();
    endif;
}
add_action('woocommerce_before_shop_loop', 'display_discount_products', 15);



/* 
Remove woocommerce the page title
*/
function custom_remove_shop_page_title($title, $id)
{
    if (is_shop()) {
        return ''; // Return an empty string to hide the title
    }
    return $title;
}
add_filter('woocommerce_show_page_title', '__return_false');


/* 
Remove by default breadcrumb and add new custom breadcrumb
*/
function woo_custom_breadcrumb()
{
    if (!is_woocommerce()) {
        return;
    }
    $breadcrumb_html = '<!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="' . TWC_OGANI_IMAGES . 'breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>' . woocommerce_page_title(false) . '</h2>
                        <div class="breadcrumb__option">';

    if (function_exists('woocommerce_breadcrumb')) {
        ob_start();
        woocommerce_breadcrumb(
            array(
                'wrap_before' => '',
                'wrap_after' => '',
                'before' => '<span>',
                'after' => '</span>',
                'home' => _x('Home', 'breadcrumb', 'woocommerce'),
            )
        );
        $breadcrumb_html .= ob_get_clean();
    }

    $breadcrumb_html .= '</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->';

    echo $breadcrumb_html;
}
add_action('woocommerce_before_main_content', 'woo_custom_breadcrumb', 10);

/* 
filter woocommerce_breadcrumb_defaults
*/
add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs');
function custom_woocommerce_breadcrumbs()
{
    return array(
        'delimiter'   => '',
        'wrap_before' => '',
        'wrap_after'  => '',
        'before'      => '<a href="%1$s">',
        'after'       => '</a>',
        'home'        => 'Home',
    );
}

/* Remove the terms and condition section from checkout page before prosecced checkout button */
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);

/* Custom widget for get latest 6 product in sidebar in shop page */
class Latest_Products_Widget extends WP_Widget
{
    function __construct()
    {
        parent::__construct('latest_products_widget', esc_html__('Latest Products', 'woocommerce'), array('description' => esc_html__('A Widget to display the latest products', 'woocommerce'),));
    }

    public function widget($args, $instance)
    {
        echo $args['before_widget'];
        if (!empty($instance['title'])) :
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        endif;

        $query_args = array(
            'post_type' => 'product',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC'
        );

        $loop = new WP_Query($query_args);

        if ($loop->have_posts()) :
            echo '<div class="latest-product__text">';
            echo '<div class="latest-product__slider owl-carousel">';
            $count = 0;

            while ($loop->have_posts()) :
                $loop->the_post();

                if ($count % 3 == 0) :
                    echo '<div class="latest-prdouct__slider__item">';
                endif;

                $product = wc_get_product(get_the_ID());
                echo '<a href="' . get_permalink() . '" class="latest-product__item">';
                echo '<div class="latest-product__item__pic">' . woocommerce_get_product_thumbnail() . '</div>';
                echo '<div class="latest-product__item__text">';
                echo '<h6>' . get_the_title() . '</h6>';
                $price = $product->get_price_html();
                echo '<span>' . wp_kses_post($price) . '</span>';
                echo '</div>';
                echo '</a>';

                if ($count % 3 == 2) :
                    echo '</div>';
                endif;

                $count++;
            endwhile;

            if ($count % 3 != 0) :
                echo '</div>';
            endif;

            echo '</div>';
            echo '</div>';
        else :
            echo __('No products found', 'woocommerce');
        endif;
        wp_reset_postdata();

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : esc_html__('Latest Products', 'woocommerce'); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_attr_e('Title:', 'woocommerce'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
<?php }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

/* Register Widget for sidebar */
function wpb_load_widget()
{
    register_widget('Latest_Products_Widget');
}
add_action('widgets_init', 'wpb_load_widget');



/**
 * Ajax Sorting for product dropdwon shop page
 */
/* function ajax_sort_products()
{
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'menu_order';

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 6,
    );

    switch ($sort_by) {
        case 'popularity':
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            break;
        case 'rating':
            $args['meta_key'] = '_wc_average_rating';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        case 'date':
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            break;
        case 'price':
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'ASC';
            break;
        case 'price-desc':
            $args['meta_key'] = '_price';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            break;
        default:
            $args['orderby'] = 'menu_order';
            $args['order'] = 'ASC';
            break;
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        woocommerce_product_loop_start();
        while ($query->have_posts()) : $query->the_post(); */
/**
 * Hook: woocommerce_shop_loop.
 */
/* do_action('woocommerce_shop_loop');

            wc_get_template_part('content', 'product');
        endwhile;
        woocommerce_product_loop_end();

    else :
        echo '<p>No products found</p>';
    endif;

    wp_reset_postdata();

    wp_die();
}
add_action('wp_ajax_sort_products', 'ajax_sort_products');
add_action('wp_ajax_nopriv_sort_products', 'ajax_sort_products'); */


// Change "Additional Information" tab label
add_filter('woocommerce_product_tabs', 'rename_additional_information_tab', 98);
function rename_additional_information_tab($tabs)
{
    if (isset($tabs['additional_information'])) {
        $tabs['additional_information']['title'] = __('Information', 'your-text-domain');
    }
    return $tabs;
}

// Remove default pagination and add custom pagination
remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);
add_action('woocommerce_after_shop_loop', 'custom_woocommerce_pagination', 10);

function custom_woocommerce_pagination()
{
    global $wp_query;

    if ($wp_query->max_num_pages <= 1) return;

    $big = 999999999; // need an unlikely integer

    $pages = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
        'next_text' => '<i class="fa fa-long-arrow-right"></i>',
        'type' => 'array',
        'end_size' => 2,
        'mid_size' => 3
    ));

    if (is_array($pages)) {
        echo '<div class="product__pagination">';
        foreach ($pages as $page) {
            echo $page;
        }
        echo '</div>';
    }
}


/**
 * Set the custom product_per_page value in shop page, via acf fields
 */
function custom_acf_shop_field()
{
    $shop_page_id = wc_get_page_id('shop');
    if ($shop_page_id) {
        $products_per_page = get_field('product_show_per_page', $shop_page_id);

        if ($products_per_page) {
            add_filter('loop_shop_per_page', function () use ($products_per_page) {
                return $products_per_page;
            }, 20);
        }
    }
}
add_action('init', 'custom_acf_shop_field');

// Generate custom HTML without the [Remove] link
add_filter('woocommerce_cart_totals_coupon_html', 'custom_coupon_html', 10, 2);

function custom_coupon_html($coupon_html, $coupon)
{
    $discount_amount_html = wc_price(WC()->cart->get_coupon_discount_amount($coupon->get_code()));
    $coupon_code = esc_html($coupon->get_code());
    $custom_html = '<span class="custom-coupon-amount">' . $discount_amount_html . '</span>';
    $custom_html .= '<a href="' . esc_url(add_query_arg('remove_coupon', urlencode($coupon_code), wc_get_cart_url())) . '" class="remove-coupon">X</a>';

    return $custom_html;
}

add_action('wp_ajax_custom_ajax_product_search', 'custom_ajax_product_search');
add_action('wp_ajax_nopriv_custom_ajax_product_search', 'custom_ajax_product_search');
