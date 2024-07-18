<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <?php $single_blog_sidebar = get_field('single_blog_sidebar', 'option'); ?>

                    <?php $sidebar_category_title = $single_blog_sidebar['single_blog_category_title']; ?>
                    <?php if (!empty($sidebar_category_title)) : ?>
                        <div class="blog__sidebar__item">
                            <h4><?php echo esc_html($sidebar_category_title); ?></h4>
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

                    <?php $sidebar_blog_title = $single_blog_sidebar['single_blog_latest_title']; ?>
                    <?php if (!empty($sidebar_blog_title)) :
                        echo '<div class="blog__sidebar__item">';
                        echo '<h4>' . esc_html($sidebar_blog_title) . '</h4>';
                        echo '<div class="blog__sidebar__recent">';

                        $args = array(
                            'posts_per_page' => 3,
                            'post_status'    => 'publish',
                        );

                        $recent_posts = new WP_Query($args);
                        if ($recent_posts->have_posts()) :
                            while ($recent_posts->have_posts()) :
                                $recent_posts->the_post();

                                echo '<a href="' . esc_url(get_the_permalink()) . '" class="blog__sidebar__recent__item">';
                                echo '<div class="blog__sidebar__recent__item__pic">';

                                $blog_image = get_the_post_thumbnail_url();
                                $def_blog_image = TWC_OGANI_IMAGES . 'blog/sidebar/sr-2.jpg';

                                echo '<img src="' . esc_url(!empty($blog_image) ? $blog_image : $def_blog_image) . '" alt="' . esc_attr(get_the_title()) . '" width="70px" height="70px">';
                                echo '</div>';

                                echo '<div class="blog__sidebar__recent__item__text">';

                                $string = get_the_title();
                                $formatted_string = insert_break_at_half($string);

                                echo '<h6>' . $formatted_string . '</h6>';
                                echo '<span>' . esc_html(get_the_date('M d, Y')) . '</span>';
                                echo '</div></a>';

                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p>No recent posts available.</p>';
                        endif;

                        echo '</div>';
                        echo '</div>';
                    endif; ?>

                    <?php $sidebar_tag_title = $single_blog_sidebar['single_blog_tag_title']; ?>
                    <?php if (!empty($sidebar_tag_title)) : ?>
                        <div class="blog__sidebar__item">
                            <h4><?php echo esc_html($sidebar_tag_title); ?></h4>
                            <div class="blog__sidebar__item__tags">
                                <?php $tags = get_tags();

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
                    $blog_section_number_show = get_sub_field('blog_section_number_show');
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                    $args = array(
                        'post_type'      => 'post',
                        'posts_per_page' => $blog_section_number_show,
                        'paged'          => $paged,
                        'post_status'    => 'publish'
                    );

                    $all_posts = new WP_Query($args);

                    if ($all_posts->have_posts()) :
                        while ($all_posts->have_posts()) :

                            $all_posts->the_post();

                            get_template_part('template-parts/loop/blog-item');

                        endwhile;

                        // Pagination
                        echo '<div class="col-lg-12">';
                        echo '<div class="product__pagination blog__pagination">';
                        echo paginate_links(array(
                            'base'      => '%_%',
                            'format'    => 'page/%#%',
                            'current'   => max(1, get_query_var('paged')),
                            'total'     => $all_posts->max_num_pages,
                            'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
                            'next_text' => '<i class="fa fa-long-arrow-right"></i>',
                        ));
                        echo '</div>';
                        echo '</div>';
                        wp_reset_postdata();
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