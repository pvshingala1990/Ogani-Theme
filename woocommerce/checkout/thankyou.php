<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined('ABSPATH') || exit;
?>

<div class="woocommerce-order">

	<?php
	if ($order) :

		do_action('woocommerce_before_thankyou', $order->get_id());
	?>

		<?php if ($order->has_status('failed')) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
				<?php if (is_user_logged_in()) : ?>
					<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>
			<div class="row">
				<div class="col-lg-12 twc_order_receive">
					<?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>
				</div>
				<div class="col-lg-12">
					<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

						<li class="woocommerce-order-overview__order order">
							<?php esc_html_e('Order number:', 'woocommerce'); ?>
							<strong><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
						</li>

						<li class="woocommerce-order-overview__date date">
							<?php esc_html_e('Date:', 'woocommerce'); ?>
							<strong><?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
						</li>

						<?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
							<li class="woocommerce-order-overview__email email">
								<?php esc_html_e('Email:', 'woocommerce'); ?>
								<strong><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
										?></strong>
							</li>
						<?php endif; ?>

						<li class="woocommerce-order-overview__total total">
							<?php esc_html_e('Total:', 'woocommerce'); ?>
							<strong><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></strong>
						</li>

						<?php if ($order->get_payment_method_title()) : ?>
							<li class="woocommerce-order-overview__payment-method method">
								<?php esc_html_e('Payment method:', 'woocommerce'); ?>
								<strong><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
							</li>
						<?php endif; ?>

					</ul>
				</div>
			</div>
		<?php endif; ?>
		<div class="row">
			<div class="col-lg-12">
				
				<?php //do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>
				<?php //do_action('woocommerce_thankyou', $order->get_id()); ?>

				<?php /* Custom order details and billing address */ ?>
				<div class="custom-order-summary">
					<h3><?php esc_html_e('Order details', 'woocommerce'); ?></h3>
					<table>
						<thead>
							<tr>
								<th><?php esc_html_e('Product', 'woocommerce'); ?></th>
								<th><?php esc_html_e('Price', 'woocommerce'); ?></th>
								<th><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
								<th><?php esc_html_e('Total', 'woocommerce'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($order->get_items() as $item_id => $item) {
								$product = $item->get_product();
								$product_name = $item->get_name();
								$quantity = $item->get_quantity();
								$price = $item->get_subtotal() / $quantity;
								$ptotal = $quantity * $price;
							?>
								<tr>
									<td><?php echo esc_html($product_name); ?></td>
									<td><?php echo wc_price($price); ?></td> <!-- Price per product -->
									<td><?php echo esc_html($quantity); ?></td>
									<td><?php echo wc_price($ptotal); ?></td>
								</tr>
							<?php
							}
							?>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="3"><?php esc_html_e('Subtotal:', 'woocommerce'); ?></th>
								<td><?php echo wp_kses_post($order->get_subtotal_to_display()); ?></td>
							</tr>
							<?php if ($order->get_total_discount() > 0) : ?>
								<tr>
									<th colspan="3"><?php esc_html_e('Discount:', 'woocommerce'); ?></th>
									<td><?php echo wc_price($order->get_total_discount()); ?></td>
								</tr>
							<?php endif; ?>
							<tr>
								<th colspan="3"><?php esc_html_e('Shipping:', 'woocommerce'); ?></th>
								<td><?php echo wp_kses_post($order->get_shipping_to_display()); ?></td>
							</tr>
							<tr>
								<th colspan="3"><?php esc_html_e('Payment Method:', 'woocommerce'); ?></th>
								<td><?php echo esc_html($order->get_payment_method_title()); ?></td>
							</tr>
							<tr>
								<th colspan="3"><?php esc_html_e('Total:', 'woocommerce'); ?></th>
								<td><?php echo wp_kses_post($order->get_formatted_order_total()); ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				<div class="custom-addresses">
					<div class="custom-address">
						<h3><?php esc_html_e('Billing Address', 'woocommerce'); ?></h3>
						<p><?php echo wp_kses_post($order->get_formatted_billing_address()); ?></p>
					</div>
					<div class="custom-address">
						<h3><?php esc_html_e('Shipping Address', 'woocommerce'); ?></h3>
						<p><?php echo wp_kses_post($order->get_formatted_shipping_address() ? $order->get_formatted_shipping_address() : __('No shipping address provided.', 'woocommerce')); ?></p>
					</div>
				</div>
				<?php /* Custom order details end here */ ?>

			</div>
		</div>
	<?php else : ?>

		<?php wc_get_template('checkout/order-received.php', array('order' => false)); ?>

	<?php endif; ?>
	<div class="row">
		<div class="col-lg-12 twc-retrun-shop">
			<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="site-btn">Return to shop</a>
		</div>
	</div>

</div>