document.addEventListener('DOMContentLoaded', function () {
    const categoryLinks = document.querySelectorAll('.category-link');
    const shopPageUrl = '/shop';

    categoryLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent the default anchor behavior

            const categoryId = this.getAttribute('data-category-id');
            const currentUrl = window.location.href;

            if (!currentUrl.includes(shopPageUrl)) {

                const redirectUrl = shopPageUrl + '?product_cat=' + categoryId;
                window.location.href = redirectUrl;
            }
        });
    });
});
