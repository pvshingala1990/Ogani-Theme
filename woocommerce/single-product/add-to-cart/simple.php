<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
        <div class="product__details__quantity">
            <div class="quantity">
                <?php
                do_action('woocommerce_before_add_to_cart_quantity');

                woocommerce_quantity_input(
                    array(
                        'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                        'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                        'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                    )
                );

                do_action('woocommerce_after_add_to_cart_quantity');
                ?>
            </div>
        </div>
        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="primary-btn alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
        
        <?php
        if (function_exists('YITH_WCWL')) {
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            $add_to_wishlist_url = YITH_WCWL()->get_add_to_wishlist_url($product->get_id());
            $exists_in_wishlist = YITH_WCWL()->is_product_in_wishlist($product->get_id());
            ?>

            <a href="<?php echo esc_url($add_to_wishlist_url); ?>" class="heart-icon">
                <span class="icon_heart_alt"></span>
                <?php echo esc_html($exists_in_wishlist ? __('View Wishlist', 'yith-woocommerce-wishlist') : __('Add to Wishlist', 'yith-woocommerce-wishlist')); ?>
            </a>
        <?php } ?>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
