<?php
/* Latest 3 blog fetch on home page */

$blog_section_title = get_sub_field('blog_section_title'); ?>

<!-- Blog Section Begin -->
<section class="from-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title from-blog__title">
                    <?php if (!empty($blog_section_title)) : ?>
                        <h2><?php echo esc_html($blog_section_title); ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">

            <?php $args = array(
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            $blog_query = new WP_Query($args);

            if ($blog_query->have_posts()) :

                while ($blog_query->have_posts()) :

                    $blog_query->the_post(); ?>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                                <?php endif; ?>
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?></li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php else : ?>
                <?php echo '<p>No blog posts found.</p>'; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Blog Section End -->