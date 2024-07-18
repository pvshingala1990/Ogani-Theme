<?php
/* Contact page section */

$info_address_label = get_field('info_address_label', 'option');
$info_address = get_field('info_address', 'option');

$info_phone_label = get_field('info_phone_label', 'option');
$info_phone_number = get_field('info_phone_number', 'option');

$info_email_label = get_field('info_email_label', 'option');
$info_email_id = get_field('info_email_id', 'option');

$info_open_time_label = get_field('info_open_time_label', 'option');
$info_open_time = get_field('info_open_time', 'option'); ?>

<!-- Contact Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <?php if (!empty($info_phone_number)) : ?>
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4><?php echo !empty($info_phone_label) ? esc_html($info_phone_label) : 'Phone'; ?></h4>
                        <p><?php echo esc_html($info_phone_number); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <?php if (!empty($info_address)) : ?>
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4><?php echo !empty($info_address_label) ? esc_html($info_address_label) : 'Address'; ?></h4>
                        <p><?php echo esc_html($info_address); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <?php if (!empty($info_open_time)) : ?>
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4><?php echo !empty($info_open_time_label) ? esc_html($info_open_time_label) : 'Open time'; ?></h4>
                        <p><?php echo esc_html($info_open_time); ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                <?php if (!empty($info_email_id)) : ?>
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4><?php echo !empty($info_email_label) ? esc_html($info_email_label) : 'Email'; ?></h4>
                        <p><?php echo esc_html($info_email_id); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<?php $google_map_link = get_sub_field('google_map_link'); ?>

<!-- Map Begin -->
<?php if (!empty($google_map_link)) : ?>
    <div class="map">
        <?php echo $google_map_link; ?>
        <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4><?php echo esc_html__('New York', 'twc-ogani'); ?></h4>
                <ul>
                    <li><?php echo esc_html__('Phone: +12-345-6789', 'twc-ogani'); ?></li>
                    <li><?php echo esc_html__('Add: 16 Creek Ave. Farmingdale, NY', 'twc-ogani'); ?></li>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Map End -->

<?php $contact_form_title = get_sub_field('contact_form_title');
$contact_form_shortcode = get_sub_field('contact_form_shortcode'); ?>

<!-- Contact Form Begin -->
<?php if (!empty($contact_form_title)) : ?>
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2><?php echo esc_html($contact_form_title); ?></h2>
                    </div>
                </div>
            </div>
            <?php echo do_shortcode($contact_form_shortcode); ?>
        </div>
    </div>
<?php endif; ?>
<!-- Contact Form End -->