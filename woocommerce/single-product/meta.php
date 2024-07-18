<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;
$product_url = get_permalink($product->get_id());
$product_title = $product->get_name();
$product_image = wp_get_attachment_url($product->get_image_id());
?>
<div class="product_meta">

	<?php do_action('woocommerce_product_meta_start'); ?>

	<ul class="custom-product-meta">
		<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
			<li class="sku_wrapper"><b><?php esc_html_e('SKU:', 'woocommerce'); ?></b> <span class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span></li>
		<?php endif; ?>
		<?php
		$categories = wc_get_product_category_list($product->get_id(), ', ', '', '');
		$categories_without_links = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $categories);
		?>
		<li class="category_wrapper"><b><?php esc_html_e('Category:', 'woocommerce'); ?></b> <span class="category"><?php echo $categories_without_links; ?></span></li>

		<li class="availability_wrapper"><b><?php esc_html_e('Availability:', 'woocommerce'); ?></b> <span class="availability"><?php echo esc_html($product->get_stock_status()); ?></span></li>
		<li class="shipping_wrapper">
			<b><?php esc_html_e('Shipping:', 'woocommerce'); ?></b>
			<span class="shipping">
				<?php
				$shipping_class = $product->get_shipping_class();
				if (!empty($shipping_class)) {
					echo esc_html($shipping_class);
				} else {
					echo esc_html__('Shipping not specified', 'woocommerce');
				}
				?>
			</span>
		</li>

		<li class="weight_wrapper"><b><?php esc_html_e('Weight:', 'woocommerce'); ?></b> <span class="weight"><?php echo esc_html($product->get_weight()); ?> kg</span></li>
		<li class="share_wrapper"><b><?php esc_html_e('Share on:', 'woocommerce'); ?></b>
			<div class="share">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($product_url); ?>" target="_blank"><i class="fa fa-facebook"></i></a>
				<a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($product_title); ?>&url=<?php echo urlencode($product_url); ?>" target="_blank"><i class="fa fa-twitter"></i></a>
				<a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode($product_url); ?>&media=<?php echo urlencode($product_image); ?>&description=<?php echo urlencode($product_title); ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
				<a href="https://web.skype.com/share?url=<?php echo urlencode($product_url); ?>" target="_blank"><i class="fa fa-skype"></i></a>
			</div>
		</li>
	</ul>

	<?php do_action('woocommerce_product_meta_end'); ?>

</div>