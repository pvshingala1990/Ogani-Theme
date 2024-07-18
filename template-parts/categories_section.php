<?php
/* Product's category with image section on home page */

$prd_cat_img_select_category = get_sub_field('prd_cat_img_select_category'); ?>

<!-- Categories Section Begin -->
<?php if ($prd_cat_img_select_category) : ?>
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php foreach ($prd_cat_img_select_category as $category) :
                        $term_id = is_object($category) ? $category->term_id : $category;
                        $term = get_term($term_id);
                        $term_link = get_term_link($term);
                        $thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
                        $image_url = wp_get_attachment_url($thumbnail_id);
                        $def_image_url = TWC_OGANI_IMAGES . 'categories/cat-1.jpg'; ?>

                        <div class="col-lg-3">
                            <div class="categories__item set-bg" data-setbg="<?php echo !empty($image_url) ? esc_url($image_url) : esc_url($def_image_url); ?>">
                                <h5><a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a></h5>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<!-- Categories Section End -->