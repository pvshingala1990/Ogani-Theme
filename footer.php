<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <?php
            $footer_logo = get_field('footer_logo', 'option');
            $header_part_logo = get_field('header_part_logo', 'option');

            /* Contact Info get field */
            $info_address_label = get_field('info_address_label', 'option');
            $info_address = get_field('info_address', 'option');
            $info_phone_label = get_field('info_phone_label', 'option');
            $info_phone_number = get_field('info_phone_number', 'option');
            $info_email_label = get_field('info_email_label', 'option');
            $info_email_id = get_field('info_email_id', 'option'); ?>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="<?php echo site_url(); ?>"><img src="<?php echo !empty($footer_logo) ? esc_url($footer_logo) : esc_url($header_part_logo); ?>" alt=""></a>
                    </div>
                    <ul>
                        <?php if (!empty($info_address)) : ?>
                            <li><?php echo !empty($info_address_label) ? esc_html($info_address_label) : __('Address', 'twc-ogani'); ?>: <?php echo esc_html($info_address); ?></li>
                        <?php endif; ?>

                        <?php if (!empty($info_phone_number)) : ?>
                            <li><?php echo !empty($info_phone_label) ? esc_html($info_phone_label) : __('Phone', 'twc-ogani'); ?>: <?php echo esc_html($info_phone_number); ?></li>
                        <?php endif; ?>

                        <?php if (!empty($info_email_id)) : ?>
                            <li><?php echo !empty($info_email_label) ? esc_html($info_email_label) : __('Email', 'twc-ogani'); ?>: <?php echo esc_html($info_email_id); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Footer Menu -->
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">

                    <?php /* 1st Menu Column */
                    $footer1 = 'footer1';
                    $location_1 = get_nav_menu_locations();
                    $menu_1 = wp_get_nav_menu_object($location_1[$footer1]);
                    $menuitem1 = wp_get_nav_menu_items($menu_1->term_id, array('order' => 'DESC')); ?>
                    <h6><?php echo $menu_1->name; ?></h6>
                    <ul>
                        <?php foreach ($menuitem1 as $key => $value_col_1) : ?>
                            <li><a href="<?php echo $value_col_1->url; ?>"><?php echo $value_col_1->title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                    <?php /* 2nd Menu Column */
                    $footer2 = 'footer2';
                    $location_2 = get_nav_menu_locations();
                    $menu_2 = wp_get_nav_menu_object($location_2[$footer2]);
                    $menuitem2 = wp_get_nav_menu_items($menu_2->term_id, array('order' => 'DESC')); ?>

                    <ul>
                        <?php foreach ($menuitem2 as $key => $value_col_2) : ?>
                            <li><a href="<?php echo $value_col_2->url; ?>"><?php echo $value_col_2->title; ?></a></li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            </div>

            <?php $ftr_newsletter_title = get_field('ftr_newsletter_title', 'option');
            $ftr_newletter_short_content = get_field('ftr_newletter_short_content', 'option');
            $ftr_newsletter_shortcode = get_field('ftr_newsletter_shortcode', 'option');

            $info_social_medias_link = get_field('info_social_medias_link', 'options'); ?>

            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <?php if (!empty($ftr_newsletter_title) && !empty($ftr_newletter_short_content)) : ?>
                        <h6><?php echo esc_html($ftr_newsletter_title); ?></h6>
                        <p><?php echo esc_html($ftr_newletter_short_content); ?></p>
                        <?php echo do_shortcode($ftr_newsletter_shortcode); ?>
                    <?php endif; ?>

                    <div class="footer__widget__social">

                        <?php if ($info_social_medias_link) :
                            foreach ($info_social_medias_link as $social_media) :
                                $social_class = $social_media['repeat_select_social'];
                                $social_link = $social_media['repeat_social_link'];
                                $open_new_tab = $social_media['repeat_open_new_tab'];

                                $target = $open_new_tab ? ' target="_blank"' : '';

                                if ($social_class != 'default' && !empty($social_link)) :
                                    echo '<a href="' . esc_url($social_link) . '"' . $target . '><i class="' . esc_attr($social_class) . '"></i></a>';
                                endif;

                            endforeach;
                        endif; ?>

                    </div>
                </div>
            </div>
        </div>
        <?php
        $footer_copy_right_line = get_field('footer_copy_right_line', 'option');
        $footer_payment_accept_image = get_field('footer_payment_accept_image', 'option'); ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <?php echo $footer_copy_right_line; ?>
                    </div>
                    <?php if (!empty($footer_payment_accept_image)) : ?>
                        <div class="footer__copyright__payment"><img src="<?php echo esc_url($footer_payment_accept_image); ?>" alt=""></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</footer>
<!-- Footer Section End -->

<?php wp_footer(); ?>
</body>

</html>