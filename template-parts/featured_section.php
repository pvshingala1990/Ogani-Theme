<?php
/* Featured product section  */

$featured_section_title = get_sub_field('featured_section_title'); ?>


<?php if (!empty($featured_section_title)) : ?>
    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <!-- Display WooCommerce notices for add-to-cart success or errors -->
                <div class="col-lg-12">
                    <?php wc_print_notices(); ?>
                </div>

                <div class="col-lg-12">
                    <div class="section-title">
                        <h2><?php echo esc_html($featured_section_title); ?></h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                            <li class="active" data-filter="*"><?php echo esc_html__('All', 'twc-ogani'); ?></li>

                            <?php
                            $args = array(
                                'limit' => -1,
                                'status' => 'publish',
                                'featured' => true,
                            );
                            $featured_products = wc_get_products($args);
                            $featured_categories = array();

                            foreach ($featured_products as $product) :
                                $terms = get_the_terms($product->get_id(), 'product_cat');
                                if ($terms) :
                                    foreach ($terms as $term) :
                                        $featured_categories[$term->slug] = $term->name;
                                    endforeach;
                                endif;
                            endforeach;

                            foreach ($featured_categories as $slug => $name) :
                                echo '<li data-filter=".' . esc_attr($slug) . '">' . esc_html($name) . '</li>';
                            endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row featured__filter">
                <?php foreach ($featured_products as $product) :

                    $product_id = $product->get_id();
                    $product_category_classes = '';
                    $terms = get_the_terms($product_id, 'product_cat');

                    if ($terms) :
                        foreach ($terms as $term) :
                            $product_category_classes .= $term->slug . ' ';
                        endforeach;
                    endif;

                    $add_to_cart_url = esc_url(add_query_arg('add-to-cart', $product_id));
                    $image_url = wp_get_attachment_url($product->get_image_id()); ?>

                    <div class="col-lg-3 col-md-4 col-sm-6 mix <?php echo esc_attr($product_category_classes); ?>">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg" data-setbg="<?php echo esc_url($image_url); ?>">
                                <ul class="featured__item__pic__hover">
                                    <li><a href="<?php echo $add_to_cart_url; ?>" class="add-to-cart"><i class="fa fa-shopping-cart"></i></a></li>
                                    <li><?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product_id . '"]'); ?></li>
                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6><a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product->get_name()); ?></a></h6>
                                <h5><?php echo wp_kses_post($product->get_price_html()); ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>
    <!-- Featured Section End -->
<?php endif; ?>