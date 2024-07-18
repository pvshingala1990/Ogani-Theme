<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
	<div class="row">
		<div class="col-lg-12">
			<?php do_action('woocommerce_before_cart_table'); ?>
			<div class="shoping__cart__table">
				<table>
					<thead>
						<tr>
							<th class="shoping__product"><?php esc_html_e('Product', 'woocommerce'); ?></th>
							<th><?php esc_html_e('Price', 'woocommerce'); ?></th>
							<th><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
							<th><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
							<th><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
						</tr>
					</thead>
					<tbody>
						<?php do_action('woocommerce_before_cart_contents'); ?>

						<?php
						foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
							$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
							$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
							/**
							 * Filter the product name.
							 *
							 * @since 2.1.0
							 * @param string $product_name Name of the product in the cart.
							 * @param array $cart_item The product in the cart.
							 * @param string $cart_item_key Key for the product in the cart.
							 */
							$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

							if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
								$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key); ?>

								<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">

									<td class="shoping__cart__item">

										<?php
										// Get the product thumbnail URL.
										$thumbnail_url = wp_get_attachment_image_url($_product->get_image_id(), 'full');

										// Create a custom <img> tag.
										$custom_thumbnail = sprintf('<img src="%s" alt="%s" height ="100px" width="100px" />', esc_url($thumbnail_url), esc_attr($_product->get_name()));

										if (!$product_permalink) :
											echo $custom_thumbnail; // Output the custom <img> tag without a link.
										else :
											printf('<a href="%s">%s</a>', esc_url($product_permalink), $custom_thumbnail); // Output the custom <img> tag wrapped in a link.
										endif; ?>



										<?php
										if (!$product_permalink) :
											echo '<h5>' . wp_kses_post($product_name . '&nbsp;') . '</h5>';
										else :
											/**
											 * This filter is documented above.
											 *
											 * @since 2.1.0
											 */
											echo '<h5>' . wp_kses_post($product_name . '&nbsp;') . '</h5>';
										/* echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<h5><a href="%s">%s</a></h5>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key)); */
										endif;

										do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

										// Meta data.
										echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

										// Backorder notification.
										if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) :
											echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
										endif; ?>

									</td>

									<td class="shoping__cart__price product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
										<?php
										echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
										?>
									</td>

									<td class="shoping__cart__quantity product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">

										<?php
										if ($_product->is_sold_individually()) :
											$min_quantity = 1;
											$max_quantity = 1;
										else :
											$min_quantity = 0;
											$max_quantity = $_product->get_max_purchase_quantity();
										endif;

										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $max_quantity,
												'min_value'    => $min_quantity,
												'product_name' => $product_name,
											),
											$_product,
											false
										);

										echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
										?>
									</td>

									<td class="shoping__cart__total product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
										<?php
										echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
										?>
									</td>
									<td class="shoping__cart__item__close product-remove">
										<?php
										echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											'woocommerce_cart_item_remove_link',
											sprintf(
												'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="icon_close"></span></a>',
												esc_url(wc_get_cart_remove_url($cart_item_key)),
												/* translators: %s is the product name */
												esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
												esc_attr($product_id),
												esc_attr($_product->get_sku())
											),
											$cart_item_key
										);
										?>
									</td>
								</tr>
						<?php endif;
						endforeach; ?>

						<?php do_action('woocommerce_cart_contents'); ?>

						<?php do_action('woocommerce_after_cart_contents'); ?>
					</tbody>
				</table>
			</div>
			<?php do_action('woocommerce_after_cart_table'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="shoping__cart__btns">
				<a href="#" class="primary-btn cart-btn"><?php esc_attr_e('CONTINUE SHOPPING', 'woocommerce'); ?></a>
				<button type="submit" class="primary-btn cart-btn cart-btn-right button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="shoping__continue">
				<div class="shoping__discount">
					<h5><?php esc_attr_e('Discount Codes', 'woocommerce'); ?></h5>
					<?php if (wc_coupons_enabled()) : ?>
						<input type="text" name="coupon_code" class="twc_input_text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Enter your coupon code', 'woocommerce'); ?>" />
						<button type="submit" class="site-btn" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
						<?php do_action('woocommerce_cart_coupon'); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
</form>
<?php do_action('woocommerce_before_cart_collaterals'); ?>

		<?php

		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		do_action('woocommerce_cart_collaterals');
		?>

<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>