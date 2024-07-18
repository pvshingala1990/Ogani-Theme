<?php get_header(); ?>

<?php
/* Blog archive page */

$archive_blog_breadcrumb_image = get_field('archive_blog_breadcrumb_image', 'option');
$def_archive_blog_breadcrumb_image = TWC_OGANI_IMAGES . 'breadcrumb.jpg'; ?>

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="<?php echo !empty($archive_blog_breadcrumb_image) ? esc_url($archive_blog_breadcrumb_image) : esc_url($def_archive_blog_breadcrumb_image); ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2><?php echo esc_html__('Blog', 'twc-ogani'); ?></h2>
                    <div class="breadcrumb__option">
                        <a href="<?php echo site_url(); ?>"><?php echo esc_html__('Home', 'twc-ogani'); ?></a>
                        <span><?php echo esc_html__('Blog', 'twc-ogani'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<?php $blog_section_number_show = get_sub_field('blog_section_number_show'); ?>

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">

                    <!-- sidebar section here -->
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <?php $single_blog_sidebar = get_field('single_blog_sidebar', 'option'); ?>

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
                                        echo '<li><a href="#" class="filter-link" data-type="category" data-id="' . $category->term_id . '">' . esc_html($category->name) . ' (' . $category->count . ')</a></li>';
                                    endforeach;
                                else :
                                    echo '<li>No categories found.</li>';
                                endif;
                                ?>
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
                                        echo '<a href="#" class="filter-link" data-type="tag" data-id="' . $tag->term_id . '">' . esc_html($tag->name) . ' (' . $tag->count . ')</a>';
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

            <div class="col-lg-8 col-md-7">
                <div class="row" id="blog__item__container">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            get_template_part('template-parts/loop/blog-item');
                        endwhile;

                        // Pagination
                        echo '<div class="col-lg-12">';
                        echo '<div class="product__pagination blog__pagination">';
                        echo paginate_links(array(
                            'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                            'format'    => 'page/%#%',
                            'current'   => max(1, get_query_var('paged')),
                            'total'     => $wp_query->max_num_pages,
                            'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
                            'next_text' => '<i class="fa fa-long-arrow-right"></i>',
                        ));
                        echo '</div>';
                        echo '</div>';
                    else :
                        echo '<p>No posts available.</p>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

<?php get_footer(); ?>