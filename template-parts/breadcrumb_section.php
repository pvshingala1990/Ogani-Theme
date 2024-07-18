<?php
/* Breadcrumb section for all pages */

$breadcrumb_image = get_sub_field('breadcrumb_image');
$def_breadcrumb_image = TWC_OGANI_IMAGES . 'breadcrumb.jpg';
$breadcrumb_title = get_sub_field('breadcrumb_title'); ?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="<?php echo !empty($breadcrumb_image) ? esc_url($breadcrumb_image) : esc_url($def_breadcrumb_image); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2><?php echo !empty($breadcrumb_title) ? esc_html($breadcrumb_title) : get_the_title(); ?></h2>
                    <?php if (function_exists('custom_breadcrumb')) :
                        custom_breadcrumb();
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->