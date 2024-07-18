jQuery(document).ready(function ($) {
    // Function to update social media options
    function updateSocialMediaOptions() {
        var selectedOptions = [];
        $('select[name="social_media_class[]"]').each(function () {
            if ($(this).val()) {
                selectedOptions.push($(this).val());
            }
        });

        var allOptions = ['fa-facebook', 'fa-twitter', 'fa-instagram', 'fa-google-plus'];

        $('select[name="social_media_class[]"]').each(function () {
            var currentSelect = $(this);
            currentSelect.find('option').each(function () {
                if (selectedOptions.includes($(this).val()) && $(this).val() !== currentSelect.val()) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
            });
        });

        if (selectedOptions.length >= allOptions.length) {
            $('#add-social-media').hide();
        } else {
            $('#add-social-media').show();
        }
    }

    // Function to add new social media item
    function addSocialMediaItem() {
        var newItem = `
            <div class="social-media-item">
                <select name="social_media_class[]">
                    <option value="">Select Social Media</option>
                    <option value="fa-facebook">Facebook</option>
                    <option value="fa-twitter">Twitter</option>
                    <option value="fa-instagram">Instagram</option>
                    <option value="fa-google-plus">Google+</option>
                </select>
                <input type="url" name="social_media_url[]" placeholder="Enter URL" />
                <select name="social_media_new_tab[]">
                    <option value="">Open in a new tab?</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <button type="button" class="remove-social-media">Remove</button>
            </div>
        `;
        $('#social-media-repeater').append(newItem);
        updateSocialMediaOptions();
    }

    // Attach event listener only once for adding new social media item
    $('#add-social-media').off('click').on('click', function () {
        addSocialMediaItem();
    });

    // Handle change event for social media selection
    $(document).off('change', 'select[name="social_media_class[]"]').on('change', 'select[name="social_media_class[]"]', function () {
        updateSocialMediaOptions();
    });

    // Handle click event for removing social media item
    $(document).off('click', '.remove-social-media').on('click', '.remove-social-media', function () {
        $(this).closest('.social-media-item').remove();
        updateSocialMediaOptions();
    });

    // Initialize options on page load
    updateSocialMediaOptions();
});
