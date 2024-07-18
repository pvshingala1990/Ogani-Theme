jQuery(document).ready(function($) {
    var minPrice = parseFloat(priceData.minPrice);
    var maxPrice = parseFloat(priceData.maxPrice);

    $(".price-range").slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
            $("#minamount").val(ui.values[0]);
            $("#maxamount").val(ui.values[1]);
        }
    });

    $("#minamount").val($(".price-range").slider("values", 0));
    $("#maxamount").val($(".price-range").slider("values", 1));
});
