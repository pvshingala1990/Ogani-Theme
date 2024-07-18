<?php
/* About Delivery Information Begin */

$about_delivery_title = get_sub_field('about_delivery_title');
$about_delivery_content1 = get_sub_field('about_delivery_content1');
$about_delivery_content2 = get_sub_field('about_delivery_content2');

if (!empty($about_delivery_title)) :
?>

<!-- Delivery Information -->
<section class="delivery-information" id="about_delivery_info">
    <div class="container">
        <div class="section-title">
            <h2><?php echo esc_html($about_delivery_title); ?></h2>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="delivery-information__content">
                <?php echo !empty($about_delivery_content1) ? $about_delivery_content1 : ''; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="delivery-information__info">
                <?php echo !empty($about_delivery_content2) ? $about_delivery_content2 : ''; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif;