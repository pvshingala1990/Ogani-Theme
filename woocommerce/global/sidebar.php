<?php

/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
<div class="col-lg-3 col-md-5">
	<div class="sidebar">
		<div class="sidebar__item">
			<h4>Department</h4>
			<?php echo do_shortcode('[product_categories_list]'); ?>
		</div>

		<div class="sidebar__item">
			<h4>Price</h4>
			<div class="price-range-wrap">
				<div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="10" data-max="540">
					<div class="ui-slider-range ui-corner-all ui-widget-header"></div>
					<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
					<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
				</div>
				<div class="range-slider">
					<div class="price-input">
						<input type="text" id="minamount">
						<input type="text" id="maxamount">
					</div>
				</div>
			</div>
		</div>

		<div class="sidebar__item sidebar__item__color--option">
			<h4>Colors</h4>
			<div class="sidebar__item__color sidebar__item__color--white">
				<label for="white">
					White
					<input type="radio" id="white">
				</label>
			</div>
			<div class="sidebar__item__color sidebar__item__color--gray">
				<label for="gray">
					Gray
					<input type="radio" id="gray">
				</label>
			</div>
			<div class="sidebar__item__color sidebar__item__color--red">
				<label for="red">
					Red
					<input type="radio" id="red">
				</label>
			</div>
			<div class="sidebar__item__color sidebar__item__color--black">
				<label for="black">
					Black
					<input type="radio" id="black">
				</label>
			</div>
			<div class="sidebar__item__color sidebar__item__color--blue">
				<label for="blue">
					Blue
					<input type="radio" id="blue">
				</label>
			</div>
			<div class="sidebar__item__color sidebar__item__color--green">
				<label for="green">
					Green
					<input type="radio" id="green">
				</label>
			</div>
		</div>

		<div class="sidebar__item">
			<h4>Popular Size</h4>
			<div class="sidebar__item__size">
				<label for="large">
					Large
					<input type="radio" id="large">
				</label>
			</div>
			<div class="sidebar__item__size">
				<label for="medium">
					Medium
					<input type="radio" id="medium">
				</label>
			</div>
			<div class="sidebar__item__size">
				<label for="small">
					Small
					<input type="radio" id="small">
				</label>
			</div>
			<div class="sidebar__item__size">
				<label for="tiny">
					Tiny
					<input type="radio" id="tiny">
				</label>
			</div>
		</div>

		<div class="sidebar__item">
			<div class="latest-product__text">
				<h4>Latest Products</h4>
				<div class="latest-product__slider owl-carousel">
					<?php
					$latest_args = array(
						'limit' => 6,
						'status' => 'publish',
						'orderby' => 'date',
						'order' => 'DESC'
					);
					$latest_products = wc_get_products($latest_args);
					$latest_chunks = array_chunk($latest_products, 3);
					foreach ($latest_chunks as $chunk) :
					?>
						<div class="latest-prdouct__slider__item">
							<?php foreach ($chunk as $product) :
								$product_id = $product->get_id();
								$product_link = get_permalink($product_id);
								$product_image = wp_get_attachment_url($product->get_image_id());
								$product_name = $product->get_name();
								$product_price = $product->get_price_html();
							?>
								<a href="<?php echo esc_url($product_link); ?>" class="latest-product__item">
									<div class="latest-product__item__pic">
										<img src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_attr($product_name); ?>">
									</div>
									<div class="latest-product__item__text">
										<h6><?php echo esc_html($product_name); ?></h6>
										<span><?php echo wp_kses_post($product_price); ?></span>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
