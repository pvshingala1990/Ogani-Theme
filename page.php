<?php
get_header();
if (have_posts()) {
    while (have_posts()) {
        the_post();


        if (have_rows('page_layouts')) {
            while (have_rows('page_layouts')) {
                the_row();
                $layout = get_row_layout();
                get_template_part('template-parts/' . $layout);
            }
        }
        
        if (is_cart() || is_checkout() || is_account_page() ||yith_wcwl_is_wishlist_page()) :
            $woo_body_class = 'twc-wishlist';
            if (is_cart()) :
                $woo_body_class = 'shoping-cart';
            elseif (is_checkout() || is_account_page()) :
                $woo_body_class = 'checkout';
            endif; ?>
            <section class="<?php echo esc_html($woo_body_class); ?> spad">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </section>
<?php endif;
    }
}

//footer Part
get_footer();
