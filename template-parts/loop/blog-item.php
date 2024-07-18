<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="blog__item">
        <div class="blog__item__pic">
            <?php if (has_post_thumbnail()) :
                the_post_thumbnail('medium'); // Display the post thumbnail
            else : ?>
                <img src="<?php echo esc_url(TWC_OGANI_IMAGES . 'blog/default-thumbnail.jpg'); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
        </div>
        <div class="blog__item__text">
            <ul>
                <li><i class="fa fa-calendar-o"></i> <?php echo get_the_date('M j, Y'); ?></li>
                <li><i class="fa fa-comment-o"></i> <?php echo get_comments_number(); ?></li>
            </ul>
            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
            <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
            <a href="<?php the_permalink(); ?>" class="blog__btn">READ MORE <span class="arrow_right"></span></a>
        </div>
    </div>
</div>