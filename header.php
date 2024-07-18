<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php
    $header_part_logo = get_field('header_part_logo', 'option');
    $def_header_part_logo = TWC_OGANI_IMAGES . 'logo.png';

    $info_email_id = get_field('info_email_id', 'option');

    $header_top_bar_message = get_field('header_top_bar_message', 'option');

    $info_social_medias_link = get_field('info_social_medias_link', 'options');

    $menu_name = 'header';
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object($locations[$menu_name]);
    $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));
    $this_item = current(wp_filter_object_list($menuitems, array('object_id' => get_queried_object_id())));
    $activeids = array();

    if ($this_item) :
        $activeids[] = $this_item->ID;
        $activeids[] = $this_item->menu_item_parent;
    endif;

    $menu = array();
    foreach ($menuitems as $m) :
        if (empty($m->menu_item_parent)) :
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID']      =   $m->ID;
            $menu[$m->ID]['title']       =   $m->title;
            $menu[$m->ID]['url']         =   $m->url;
            $menu[$m->ID]['children']    =   array();
            $menu[$m->ID]['top']    =   1;
        endif;
    endforeach;

    $submenu = array();
    foreach ($menuitems as $m) :
        if ($m->menu_item_parent) :
            $submenu[$m->ID] = array();
            $submenu[$m->ID]['ID']       =   $m->ID;
            $submenu[$m->ID]['title']    =   $m->title;
            $submenu[$m->ID]['url']  =   $m->url;
            $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
        endif;
    endforeach;

    $cart_page_id = pll_get_post(get_option('woocommerce_cart_page_id'));
    $cart_page_url = get_permalink($cart_page_id);
    ?>
    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
        <div class="humberger__menu__logo">
            <a href="<?php echo pll_home_url(); ?>"><img src="<?php echo (!empty($header_part_logo)) ? esc_url($header_part_logo) : esc_url($def_header_part_logo); ?>" alt=""></a>
        </div>

        <!-- Wishlist and Cart bag static for now -->
        <div class="humberger__menu__cart">
            <ul>
                <li><a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"><i class="fa fa-heart"></i> <span><?php echo YITH_WCWL()->count_products(); ?></span></a></li>
                <li><a href="<?php echo esc_url($cart_page_url); ?>"><i class="fa fa-shopping-bag"></i><span><?php echo WC()->cart->get_cart_contents_count(); ?></span></a></li>
            </ul>
            <div class="header__cart__price"><?php echo __('Item:', 'twc-ogani'); ?> <span><?php wc_cart_totals_order_total_html(); ?></span></div>
        </div>
        <div class="humberger__menu__widget">
            <div class="header__top__right__language">
                <?php
                $current_lang = pll_current_language('slug');
                $languages = pll_the_languages(array('raw' => 1, 'hide_if_no_translation' => 1));
                $flag_url = '';

                foreach ($languages as $language) {
                    if ($language['slug'] == $current_lang) {
                        $flag_url = $language['flag'];
                        break;
                    }
                }
                ?>
                <img src="<?php echo esc_url($flag_url); ?>" alt="Language">
                <div><?php echo pll_current_language('name'); ?></div>
                <span class="arrow_carrot-down"></span>
                <ul>
                    <?php
                    foreach ($languages as $language) {
                        echo '<li><a href="' . esc_url($language['url']) . '">' . esc_html($language['name']) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <div class="header__top__right__auth">
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i> <?php echo __('Logout', 'twc-ogani'); ?></a>
                <?php else : ?>
                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('myaccount'))); ?>"><i class="fa fa-sign-in"></i> <?php echo __('Login', 'twc-ogani'); ?></a>
                <?php endif; ?>
            </div>
        </div>
        <nav class="humberger__menu__nav mobile-menu">
            <ul>
                <?php foreach ($menu as $key => $value) : ?>
                    <?php if (empty($value['children'])) : ?>
                        <li class="<?php echo (in_array($value['ID'], $activeids)) ? 'active' : ''; ?>"><a href="<?php echo $value['url']; ?>" class="nav-item nav-link"><?php echo $value['title']; ?></a></li>
                    <?php else : ?>
                        <li>
                            <a href="<?php echo $value['url']; ?> "><?php echo $value['title']; ?></a>
                            <ul class="header__menu__dropdown">
                                <?php foreach ($value['children'] as $ckey => $childrenvalue) : ?>
                                    <li><a href="<?php echo $childrenvalue['url']; ?>" class="dropdown-item"><?php echo $childrenvalue['title']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="header__top__right__social">
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
        <div class="humberger__menu__contact">
            <ul>
                <?php if (!empty($info_email_id)) : ?>
                    <li><i class="fa fa-envelope"></i> <?php echo esc_html($info_email_id); ?></li>
                <?php endif; ?>

                <?php if (!empty($header_top_bar_message)) : ?>
                    <li><?php echo esc_html($header_top_bar_message); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__left">
                            <ul>
                                <?php if (!empty($info_email_id)) : ?>
                                    <li><i class="fa fa-envelope"></i> <?php echo esc_html($info_email_id); ?></li>
                                <?php endif; ?>

                                <?php if (!empty($header_top_bar_message)) : ?>
                                    <li><?php echo esc_html($header_top_bar_message); ?></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="header__top__right">
                            <div class="header__top__right__social">

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

                            <div class="header__top__right__language">
                                <?php
                                $current_lang = pll_current_language('slug');
                                $languages = pll_the_languages(array('raw' => 1, 'hide_if_no_translation' => 1));
                                $flag_url = '';

                                foreach ($languages as $language) :
                                    if ($language['slug'] == $current_lang) :
                                        $flag_url = $language['flag'];
                                        break;
                                    endif;
                                endforeach;
                                ?>
                                <img src="<?php echo esc_url($flag_url); ?>" alt="Language">
                                <div><?php echo pll_current_language('name'); ?></div>
                                <span class="arrow_carrot-down"></span>
                                <ul>
                                    <?php
                                    foreach ($languages as $language) :
                                        echo '<li><a href="' . esc_url($language['url']) . '">' . esc_html($language['name']) . '</a></li>';
                                    endforeach;
                                    ?>
                                </ul>
                            </div>

                            <div class="header__top__right__auth">
                                <?php if (is_user_logged_in()) : ?>
                                    <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-sign-out"></i> <?php echo __('Logout', 'twc-ogani'); ?></a>
                                <?php else : ?>
                                    <a href="<?php echo esc_url(get_permalink(wc_get_page_id('myaccount'))); ?>"><i class="fa fa-sign-in"></i> <?php echo __('Login', 'twc-ogani'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="header__logo">
                        <a href="<?php echo pll_home_url(); ?>"><img src="<?php echo (!empty($header_part_logo)) ? esc_url($header_part_logo) : esc_url($def_header_part_logo); ?>" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="header__menu">
                        <ul>
                            <?php foreach ($menu as $key => $value) : ?>
                                <?php if (empty($value['children'])) : ?>
                                    <li class="<?php echo (in_array($value['ID'], $activeids)) ? 'active' : ''; ?>"><a href="<?php echo $value['url']; ?>" class="nav-item nav-link"><?php echo $value['title']; ?></a></li>
                                <?php else : ?>
                                    <li>
                                        <a href="<?php echo $value['url']; ?> "><?php echo $value['title']; ?></a>
                                        <ul class="header__menu__dropdown">
                                            <?php foreach ($value['children'] as $ckey => $childrenvalue) : ?>
                                                <li><a href="<?php echo $childrenvalue['url']; ?>" class="dropdown-item"><?php echo $childrenvalue['title']; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3">
                    <div class="header__cart">
                        <ul>
                            <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><i class="fa fa-user"></i></a></li>
                            <li><a href="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"><i class="fa fa-heart"></i> <span><?php echo YITH_WCWL()->count_products(); ?></span></a></li>
                            <li class='abc'><a href="<?php echo esc_url($cart_page_url); ?>"><i class="fa fa-shopping-bag"></i><span id="cartItemCount"><?php echo WC()->cart->get_cart_contents_count(); ?></span></a></li>
                        </ul>
                        <div class="header__cart__price"><?php echo __('Item:', 'twc-ogani'); ?> <span><?php wc_cart_totals_order_total_html(); ?></span></div>
                    </div>
                </div>
            </div>
            <div class="humberger__open">
                <i class="fa fa-bars"></i>
            </div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <?php $info_phone_number = get_field('info_phone_number', 'option');
    $info_support_time = get_field('info_support_time', 'option'); ?>

    <section class="hero <?php echo is_front_page() ? '' : 'hero-normal'; ?>">
        <div class="container">
            <div class="row">
                <div class="col-lg-3" id="header">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span><?php echo __('All departments', 'twc-ogani'); ?></span>
                        </div>
                        <?php echo do_shortcode('[product_categories_list]'); ?>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="hero__search">

                        <div class="hero__search__form">

                            <form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
                                <div class="hero__search__categories">
                                    <?php echo __('All Categories', 'twc-ogani'); ?>
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="search" name="s" id="ajax-search-input" placeholder="<?php echo esc_attr_x('What do you need?', 'placeholder', 'twc-ogani'); ?>" value="<?php echo get_search_query(); ?>" />
                                <button id="ajax-search-button" class="site-btn" type="submit"><?php echo esc_html_x('SEARCH', 'submit button', 'twc-ogani'); ?></button>
                                <input type="hidden" name="post_type" value="product" />
                            </form>

                        </div>

                        <div class="hero__search__phone">
                            <?php if (!empty($info_phone_number)) : ?>
                                <div class="hero__search__phone__icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="hero__search__phone__text">
                                    <h5><?php echo esc_html($info_phone_number); ?></h5>

                                    <?php if (!empty($info_support_time)) : ?>
                                        <span><?php echo esc_html($info_support_time); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (is_front_page()) : ?>

                        <?php $home_header_banner = get_field('home_header_banner', 'option');
                        $def_home_header_banner = TWC_OGANI_IMAGES . 'hero/banner.jpg';
                        $home_header_title = get_field('home_header_title', 'option');
                        $home_header_bold_title = get_field('home_header_bold_title', 'option');
                        $home_header_short_content = get_field('home_header_short_content', 'option');
                        $home_header_button = get_field('home_header_button', 'option'); ?>

                        <?php if (!empty($home_header_title) && !empty($home_header_bold_title) && !empty($home_header_button)) : ?>
                            <div class="hero__item set-bg" data-setbg="<?php echo !empty($home_header_banner) ? esc_url($home_header_banner) : esc_url($def_home_header_banner); ?>">
                                <div class="hero__text">
                                    <span><?php echo esc_html($home_header_title); ?></span>
                                    <h2><?php echo $home_header_bold_title; ?></h2>
                                    <p><?php echo esc_html($home_header_short_content); ?></p>
                                    <a href="<?php echo esc_url($home_header_button['url']); ?>" target="<?php echo $home_header_button['target']; ?>" class="primary-btn"><?php echo esc_html($home_header_button['title']); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->