<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'product__details__pic',
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$gallery_image_ids = $product->get_gallery_image_ids();
?>

<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
	<div class="woocommerce-product-gallery__wrapper">
		<div class="product__details__pic__item">
			<?php
			if ( $post_thumbnail_id ) {
				echo wc_get_gallery_image_html( $post_thumbnail_id, true );
			} else {
				echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			}
			?>
		</div>

		<?php if ( ! empty( $gallery_image_ids ) ) : ?>
			<div class="product__details__pic__slider owl-carousel">
				<?php foreach ( $gallery_image_ids as $attachment_id ) : ?>
					<?php 
						$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
						$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
						$thumbnail_html  = wp_get_attachment_image( $attachment_id, 'thumbnail' );

						echo sprintf(
							'<img data-imgbigurl="%s" src="%s" alt="">',
							esc_url( $full_size_image[0] ),
							esc_url( $thumbnail[0] )
						);
					?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
