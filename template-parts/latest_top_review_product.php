<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <!-- Latest 6 Prodcuts Here -->
            <?php $latest_product_title = get_sub_field('latest_product_title'); ?>
            <?php if (!empty($latest_product_title)) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4><?php echo esc_html($latest_product_title); ?></h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php $last_args = array(
                                'limit' => 6,
                                'status' => 'publish',
                                'orderby' => 'date',
                                'order' => 'DESC'
                            );
                            $latest_products = wc_get_products($last_args);

                            $latest_chunks = array_chunk($latest_products, 3);

                            foreach ($latest_chunks as $chunk) : ?>
                                <div class="latest-prdouct__slider__item">
                                    <?php foreach ($chunk as $product) :
                                        $product_id = $product->get_id();
                                        $product_link = get_permalink($product_id);
                                        $product_image = wp_get_attachment_url($product->get_image_id());
                                        $product_name = $product->get_name();
                                        $product_price = $product->get_price_html(); ?>
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
            <?php endif; ?>

            <!-- Top Rated Prodcuts Here -->
            <?php $top_rated_title = get_sub_field('top_rated_title'); ?>

            <?php if (!empty($top_rated_title)) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4><?php echo esc_html($top_rated_title); ?></h4>
                        <div class="latest-product__slider owl-carousel">
                            <?php $top_args = array(
                                'limit' => 6,
                                'status' => 'publish',
                                'meta_key' => '_wc_average_rating',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                            );
                            $top_rated_products = wc_get_products($top_args);
                            $top_chunks = array_chunk($top_rated_products, 3); ?>

                            <?php foreach ($top_chunks as $top_chunk) : ?>
                                <div class="latest-prdouct__slider__item">
                                    <?php foreach ($top_chunk as $product) :
                                        $product_id = $product->get_id();
                                        $product_link = get_permalink($product_id);
                                        $product_image = wp_get_attachment_url($product->get_image_id());
                                        $product_name = $product->get_name();
                                        $product_price = $product->get_price_html(); ?>

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
            <?php endif; ?>

            <!-- Review Prodcuts Here -->
            <?php $review_product_title = get_sub_field('review_product_title'); ?>

            <?php if (!empty($review_product_title)) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4><?php echo esc_html($review_product_title); ?></h4>
                        <div class="latest-product__slider owl-carousel">

                            <?php $review_args = array(
                                'limit' => 6,
                                'status' => 'publish',
                                'meta_key' => '_wc_average_rating',
                                'orderby' => 'meta_value_num',
                                'order' => 'DESC',
                                'meta_query' => array(
                                    array(
                                        'key' => '_wc_review_count',
                                        'value' => '0',
                                        'compare' => '>',
                                        'type' => 'NUMERIC'
                                    )
                                )
                            );
                            $review_products = wc_get_products($review_args);

                            $review_chunks = array_chunk($review_products, 3);

                            foreach ($review_chunks as $review_chunk) : ?>

                                <div class="latest-prdouct__slider__item">
                                    <?php foreach ($review_chunk as $product) :
                                        $product_id = $product->get_id();
                                        $product_link = get_permalink($product_id);
                                        $product_image = wp_get_attachment_url($product->get_image_id());
                                        $product_name = $product->get_name();
                                        $product_price = $product->get_price_html(); ?>

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
            <?php endif; ?>

        </div>
    </div>
</section>
<!-- Latest Product Section End -->