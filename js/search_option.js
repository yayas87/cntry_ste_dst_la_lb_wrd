(function($, Drupal) {
    Drupal.behaviors.search_option = {
        attach: function(context, settings) {
            $(".csd-country-details").select2();
            $(".csd-state-details").select2();
            $(".csd-district-details").select2();
        }
    };
})(jQuery, Drupal);