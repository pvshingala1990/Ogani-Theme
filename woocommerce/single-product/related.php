<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if ($related_products) : ?>

	<div class="row">
		<div class="col-lg-12">
			<div class="section-title related__product__title">
				<h2><?php esc_html_e('Related Products', 'woocommerce'); ?></h2>
			</div>
		</div>
	</div>
	<div class="row twc_related_view">
		<?php foreach ($related_products as $related_product) : ?>
			<?php
			$post_object = get_post($related_product->get_id());

			setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
			?>
			<div class="col-lg-3 col-md-4 col-sm-6">
				<div class="product__item">
					<div class="product__item__pic set-bg" data-setbg="<?php echo get_the_post_thumbnail_url($related_product->get_id(), 'full'); ?>">
						<ul class="product__item__pic__hover">
							<li><a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>"><i class="fa fa-heart"></i></a></li>
							<li><a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>"><i class="fa fa-retweet"></i></a></li>
							<li><a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>"><i class="fa fa-shopping-cart"></i></a></li>
						</ul>
					</div>
					<div class="product__item__text">
						<h6><a href="<?php echo esc_url(get_permalink($related_product->get_id())); ?>"><?php echo get_the_title($related_product->get_id()); ?></a></h6>
						<h5><?php echo $related_product->get_price_html(); ?></h5>
					</div>
				</div>
			</div>
		<?php endforeach; ?>

	</div>


<?php
endif;

wp_reset_postdata();
?>