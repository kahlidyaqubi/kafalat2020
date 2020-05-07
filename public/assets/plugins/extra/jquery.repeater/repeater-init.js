$(function() {
    'use strict';

    // Default
    $('.repeater-default').repeater();
    $('.dropdown-trigger').dropdown();

    // Custom Show / Hide Configurations
    $('.file-repeater, .income-repeater').repeater({
        show: function() {
            $(this).slideDown();
            $('.dropdown-trigger').dropdown();
        },
        hide: function(remove) {
            if (confirm('هل انت متآكد من عمليه الحذف')) {
                $(this).slideUp(remove);
                $('.dropdown-trigger').dropdown();
            }
        }
    });


});