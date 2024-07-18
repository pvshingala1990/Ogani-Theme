<?php

/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
?>
<p class="twc-dash-a">
	<?php
	printf(
		/* translators: 1: order number 2: order date 3: order status */
		esc_html__('Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce'),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<mark class="order-date">' . wc_format_datetime($order->get_date_created()) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<mark class="order-status">' . wc_get_order_status_name($order->get_status()) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
	?>
</p>

<?php if ($notes) : ?>
	<h2><?php esc_html_e('Order updates', 'woocommerce'); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ($notes as $note) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																		?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop(wptexturize($note->comment_content)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php //do_action( 'woocommerce_view_order', $order_id ); 
?>
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