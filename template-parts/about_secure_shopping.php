<?php
/* About Secure Shopping Section Begin */

$secure_title = get_sub_field('secure_title');
$secure_first_content = get_sub_field('secure_first_content');
$secure_second_content = get_sub_field('secure_second_content');

if (!empty($secure_title)) :
?>
    <!-- Secure Shopping -->
    <section class="secure-shopping" id="about_secure_shopping">
        <div class="container">
            <div class="section-title">
                <h2><?php echo esc_html($secure_title); ?></h2>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="secure-shopping__content">
                        <?php echo !empty($secure_first_content) ? $secure_first_content : ''; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="secure-shopping__info">
                        <?php echo !empty($secure_second_content) ? $secure_second_content : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif;
