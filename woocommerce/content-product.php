<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}
?>

<div class="col-lg-4 col-md-6 col-sm-6">
	<div class="product__item">
		<div class="product__item__pic set-bg" style="background-image: url('<?php echo wp_get_attachment_url($product->get_image_id()); ?>');" data-setbg="<?php echo wp_get_attachment_url($product->get_image_id()); ?>">
			<ul class="product__item__pic__hover">
				<li><a href="<?php echo esc_url($product->add_to_cart_url()); ?>" class="button add_to_cart_button"><i class="fa fa-shopping-cart"></i></a></li>
				<li><?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?></li>
			</ul>
		</div>
		<div class="product__item__text">
			<h6><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
			<h5><?php echo $product->get_price_html(); ?></h5>
		</div>
	</div>
</div>