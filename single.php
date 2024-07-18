<?php get_header(); ?>

<!-- Blog Details Hero Begin -->
<?php
$single_blog_breadcrumb_image = get_field('single_blog_breadcrumb_image', 'option');
$def_single_blog_breadcrumb_image = TWC_OGANI_IMAGES . 'blog/details/details-hero.jpg';

if (have_posts()) :
    while (have_posts()) :
        the_post(); ?>
        <section class="blog-details-hero set-bg" data-setbg="<?php echo !empty($single_blog_breadcrumb_image) ? esc_url($single_blog_breadcrumb_image) : esc_url($def_single_blog_breadcrumb_image); ?>">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="blog__details__hero__text">
                            <h2><?php echo get_the_title(); ?></h2>
                            <ul>
                                <li><?php echo esc_html__('By', 'twc-ogani'); ?><?php echo get_the_author(); ?></li>
                                <li><?php echo get_the_date(); ?></li>
                                <li><?php comments_number('No Comments', '1 Comment', '% Comments'); ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php
    endwhile;
endif; ?>
<!-- Blog Details Hero End -->

<!-- Blog Details Section Begin -->
<?php $single_blog_sidebar = get_field('single_blog_sidebar', 'option'); ?>

<section class="blog-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5 order-md-1 order-2">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <?php $single_blog_category_title = $single_blog_sidebar['single_blog_category_title']; ?>
                    <?php if (!empty($single_blog_category_title)) : ?>
                        <div class="blog__sidebar__item">
                            <h4><?php echo esc_html($single_blog_category_title); ?></h4>
                            <ul>
                                <li><a href="#" class="filter-link" data-type="category" data-id="all"><?php echo esc_html__('All', 'twc-ogani'); ?></a></li>
                                <?php
                                $categories = get_categories(array(
                                    'orderby'    => 'name',
                                    'order'      => 'ASC',
                                    'hide_empty' => true,
                                ));

                                if (!empty($categories)) :
                                    foreach ($categories as $category) :

                                        if (is_single()) :
                                            $archive_url = get_category_link($category->term_id);
                                            echo '<li><a href="' . esc_url($archive_url) . '">' . esc_html($category->name) . ' (' . $category->count . ')</a></li>';
                                        else :
                                            echo '<li><a href="#" class="filter-link" data-type="category" data-id="' . $category->term_id . '">' . esc_html($category->name) . ' (' . $category->count . ')</a></li>';
                                        endif;

                                    endforeach;
                                else :
                                    echo '<li>No categories found.</li>';
                                endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php $single_blog_latest_title = $single_blog_sidebar['single_blog_latest_title']; ?>
                    <?php if (!empty($single_blog_latest_title)) : ?>
                        <div class="blog__sidebar__item">
                            <h4><?php echo esc_html($single_blog_latest_title); ?></h4>
                            <div class="blog__sidebar__recent">

                                <?php $args = array(
                                    'posts_per_page' => 3,
                                    'post_status'    => 'publish',
                                );

                                $recent_posts = new WP_Query($args);
                                if ($recent_posts->have_posts()) :
                                    while ($recent_posts->have_posts()) :
                                        $recent_posts->the_post(); ?>
                                        <a href="<?php the_permalink(); ?>" class="blog__sidebar__recent__item">
                                            <div class="blog__sidebar__recent__item__pic">

                                                <?php $blog_image = get_the_post_thumbnail_url();
                                                $def_blog_image = TWC_OGANI_IMAGES . 'blog/sidebar/sr-2.jpg'; ?>

                                                <img src="<?php echo !empty($blog_image) ? esc_html($blog_image) : esc_html($def_blog_image); ?>" alt="<?php the_title(); ?>" width="70px" height="70px">

                                            </div>

                                            <div class="blog__sidebar__recent__item__text">

                                                <?php $string = get_the_title();
                                                $formatted_string = insert_break_at_half($string); ?>

                                                <h6><?php echo $formatted_string; ?></h6>
                                                <span><?php echo get_the_date('M d, Y'); ?></span>

                                            </div>
                                        </a>
                                <?php endwhile;
                                    wp_reset_postdata();
                                else :
                                    echo '<p>No recent posts available.</p>';
                                endif; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php $single_blog_tag_title = $single_blog_sidebar['single_blog_tag_title']; ?>
                    <?php if (!empty($single_blog_tag_title)) : ?>
                        <div class="blog__sidebar__item">
                            <h4><?php echo esc_html($single_blog_tag_title); ?></h4>
                            <div class="blog__sidebar__item__tags">
                                <?php
                                $tags = get_tags();

                                if (!empty($tags)) :

                                    foreach ($tags as $tag) :

                                        if (is_single()) :
                                            $archive_url = get_tag_link($tag->term_id);
                                            echo '<a href="' . esc_url($archive_url) . '">' . esc_html($tag->name) . ' (' . $tag->count . ')</a>';
                                        else :
                                            echo '<a href="#" class="filter-link" data-type="tag" data-id="' . esc_attr($tag->term_id) . '">' . esc_html($tag->name) . ' (' . $tag->count . ')</a>';
                                        endif;

                                    endforeach;

                                else :
                                    echo 'No tags found.';
                                endif;
                                ?>


                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="col-lg-8 col-md-7 order-md-1 order-1">
                        <div class="blog__details__text">
                            <img src="<?php echo get_the_post_thumbnail_url(); ?>" width="750px" height="631px" alt="">
                            <?php the_content(); ?>
                        </div>
                        <div class="blog__details__content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="blog__details__author">
                                        <div class="blog__details__author__pic">
                                            <?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
                                            <?php /* <img src="<?php echo TWC_OGANI_IMAGES ?>blog/details/details-author.jpg" alt=""> */ ?>
                                        </div>
                                        <div class="blog__details__author__text">
                                            <h6><?php echo esc_html(get_the_author()); ?></h6>
                                            <span>
                                                <?php
                                                $author_id = get_the_author_meta('ID');
                                                $user_info = get_userdata($author_id);
                                                $user_roles = $user_info->roles;

                                                if (!empty($user_roles)) :
                                                    echo esc_html(ucfirst($user_roles[0]));
                                                else :
                                                    echo 'No role assigned';
                                                endif;
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog__details__widget">
                                        <ul>
                                            <li><span><?php echo __('Categories:', 'twc-ogani'); ?></span>
                                                <?php $categories = get_the_category();
                                                if ($categories) :
                                                    $category_names = [];
                                                    foreach ($categories as $category) :
                                                        $category_names[] = $category->name;
                                                    endforeach;
                                                    echo implode(', ', $category_names);
                                                endif; ?>
                                            </li>
                                            <li><span><?php echo __('Tags:', 'twc-ogani'); ?></span>
                                                <?php $post_tags = get_the_tags();
                                                if ($post_tags) :
                                                    $tag_names = [];
                                                    foreach ($post_tags as $tag) :
                                                        $tag_names[] = $tag->name;
                                                    endforeach;
                                                    echo implode(', ', $tag_names);
                                                endif; ?>
                                            </li>
                                        </ul>
                                        <div class="blog__details__social">
                                            <?php do_action('blog_details_social_media'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

<!-- Related Blog Section Begin -->
<section class="related-blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title related-blog-title">
                    <?php $single_related_post_label = get_field('single_related_post_label', 'options'); ?>
                    <h2><?php echo !empty($single_related_post_label) ? esc_html($single_related_post_label) : __('Post You May Like', 'twc-ogani'); ?></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <?php $current_post_id = get_the_ID();
            $categories = wp_get_post_categories($current_post_id);
            $tags = wp_get_post_tags($current_post_id);

            if (!empty($categories) || !empty($tags)) :
                $args = [
                    'post__not_in' => [$current_post_id],
                    'posts_per_page' => 3,
                    'ignore_sticky_posts' => 1,
                    'orderby' => 'rand',
                    'tax_query' => [
                        'relation' => 'OR',
                        [
                            'taxonomy' => 'category',
                            'field' => 'term_id',
                            'terms' => $categories,
                        ],
                        [
                            'taxonomy' => 'post_tag',
                            'field' => 'term_id',
                            'terms' => wp_list_pluck($tags, 'term_id'),
                        ],
                    ],
                ];

                $related_posts = new WP_Query($args);

                if ($related_posts->have_posts()) :

                    while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/img/blog/default.jpg" alt="<?php the_title(); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="blog__item__text">
                                    <ul>
                                        <li><i class="fa fa-calendar-o"></i> <?php echo get_the_date(); ?></li>
                                        <li><i class="fa fa-comment-o"></i> <?php comments_number('0', '1', '%'); ?></li>
                                    </ul>
                                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                </div>
                            </div>
                        </div>
            <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
            endif; ?>
        </div>
    </div>
</section>
<!-- Related Blog Section End -->

<!-- Footer Section Begin -->
<?php
get_footer();