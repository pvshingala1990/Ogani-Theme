jQuery(document).ready(function ($) {
    var activeFilters = {
        category: null,
        tag: null,
        search: null
    };

    function fetchFilteredPosts(page = 1) {
        var data = {
            action: 'ajax_fetch_posts_by_filter',
            filter_type: activeFilters.category ? 'category' : (activeFilters.tag ? 'tag' : null),
            filter_id: activeFilters.category || activeFilters.tag,
            tag_filter: activeFilters.tag,
            paged: page,
            search: activeFilters.search
        };

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#blog__item__container').html(response.data);
                } else {
                    $('#blog__item__container').html('<div class="col-lg-8 col-md-7"><div class="row"><div class="col-lg-12"><p>No blogs found according to filters.</p></div></div></div>');
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred while fetching posts');
            }
        });
    }

    // Handle tag or other filtering
    jQuery('.filter-link').on('click', function (e) {
        e.preventDefault();
        var filter_type = $(this).data('type');
        var filter_id = $(this).data('id');

        if (filter_type === 'category') {
            activeFilters.category = filter_id === 'all' ? null : filter_id;
            activeFilters.tag = null;
        } else if (filter_type === 'tag') {
            activeFilters.tag = filter_id === 'all' ? null : filter_id;
            activeFilters.category = null;
        }

        // Add active class to the clicked element and remove from others
        $('.filter-link[data-type="' + filter_type + '"]').removeClass('active');
        $(this).addClass('active');

        fetchFilteredPosts();
    });

    // Handle search form submission
    jQuery('.blog__sidebar__search form').submit(function (e) {
        e.preventDefault();
        var searchQuery = $(this).find('input[type="text"]').val();
        activeFilters.search = searchQuery;
        fetchFilteredPosts();
    });

    // Handle pagination
    jQuery(document).on('click', '.blog__pagination a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page/').pop();
        fetchFilteredPosts(page);
    });

    /* Slider team member */
    jQuery('.team-members-carousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });

    /* Slider testimonials */
    $('.testimonials-carousel').owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 2
            },
            992: {
                items: 3
            }
        }
    });

});

