<?php
/* Banner section for home page two banner images */

$banner_section_img1 = get_sub_field('banner_section_img1');
$banner_section_img2 = get_sub_field('banner_section_img2'); ?>

<!-- Banner Begin -->
<?php if (!empty($banner_section_img1) && !empty($banner_section_img2)) : ?>
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="<?php echo esc_url($banner_section_img1); ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="<?php echo esc_url($banner_section_img2); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Banner End -->