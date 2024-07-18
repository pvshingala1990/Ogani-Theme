<?php
/* About Our Shop Section Begin */

$about_ourshop_title = get_sub_field('about_ourshop_title');
$about_ourshop_subtitle = get_sub_field('about_ourshop_subtitle');
$about_ourshop_content = get_sub_field('about_ourshop_content');
$about_ourshop_location = get_sub_field('about_ourshop_location');
$about_ourshop_short_content = get_sub_field('about_ourshop_short_content');

$info_address_label = get_field('info_address_label', 'option');
$info_address = get_field('info_address', 'option');

$info_open_time_label = get_field('info_open_time_label', 'option');
$info_open_time = get_field('info_open_time', 'option');


if (!empty($about_ourshop_title) || !empty($about_ourshop_content)) : ?>
    <section class="about-our-shop" id="about_our_shop">
        <div class="container">
            <div class="section-title">
                <h2><?php echo esc_html($about_ourshop_title); ?></h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-our-shop__content">
                        <?php if (!empty($about_ourshop_subtitle)) : ?>
                            <h3><?php echo esc_html($about_ourshop_subtitle); ?></h3>
                        <?php endif; ?>

                        <?php echo $about_ourshop_content; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-our-shop__info">
                        <?php
                        if (!empty($about_ourshop_location)) :

                            echo '<h3>' . esc_html($about_ourshop_location) . '</h3>';

                            if (!empty($info_address_label) || !empty($info_address)) :
                                echo '<p><strong>' . $info_address_label . ': </strong> ' . $info_address . '</p>';
                            endif;

                            if (!empty($info_open_time_label) || !empty($info_open_time)) :
                                echo '<p><strong>' . $info_open_time_label . ': </strong> ' . $info_open_time . '</p>';
                            endif;

                            if (!empty($about_ourshop_short_content)) :
                                echo '<p>' . $about_ourshop_short_content . '</p>';
                            endif;

                        endif;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
endif;
