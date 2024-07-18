<?php
/* About Us Section Begin */

$about_title = get_sub_field('about_title');
$about_content = get_sub_field('about_content');
$about_button = get_sub_field('about_button');
$about_image = get_sub_field('about_image');

if (!empty($about_title) || !empty($about_content)) : ?>
    <section class="about-us" id="about_welcome">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-us__content">
                        <div class="section-title">
                            <h2><?php echo esc_html($about_title); ?></h2>
                        </div>

                        <?php echo $about_content; ?>

                        <?php if (!empty($about_button)) : ?>
                            <a href="<?php echo esc_url($about_button['url']); ?>" target="<?php echo $about_button['target']; ?>" class="site-btn"><?php echo esc_html($about_button['title']); ?></a>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-lg-6">
                    <?php if (!empty($about_image)) : ?>
                        <div class="about-us__pic">
                            <img src="<?php echo esc_url($about_image); ?>" alt="About Us Image">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif;