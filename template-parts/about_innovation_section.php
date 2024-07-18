<?php
/* About Innovation Section Begin */

$about_innovation_title = get_sub_field('about_innovation_title'); 
$about_innovations = get_sub_field('about_innovations');

if (!empty($about_innovation_title)) :
?>
    <!-- Innovation Section Begin -->
    <section class="innovation" id="about_innovation">
        <div class="container">
            <div class="section-title">
                <h2><?php echo esc_html($about_innovation_title); ?></h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="innovation__content">

                    <?php
                        if (have_rows('about_innovations')) :
                            $about_innovations = [];
                            while (have_rows('about_innovations')) : the_row();
                                $innovation_title = get_sub_field('innovation_title');
                                $innovation_content = get_sub_field('innovation_content');
                                $about_innovations[] = ['title' => $innovation_title, 'content' => $innovation_content];
                            endwhile;

                            $chunks = array_chunk($about_innovations, 3);

                            foreach ($chunks as $chunk) : ?>
                                <div class="row">
                                    <?php foreach ($chunk as $innovation) : ?>
                                        <div class="col-lg-4 col-md-6">
                                            <h3><?php echo esc_html($innovation['title']); ?></h3>
                                            <p><?php echo esc_html($innovation['content']); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                        <?php endforeach;
                        endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Innovation Section End -->
<?php endif;
