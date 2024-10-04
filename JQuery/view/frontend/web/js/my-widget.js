define(['jquery', 'jquery/ui'], function($) {
    'use strict';

    $.widget('tigren.myWidget', {
        options: {
            message: 'Hello, this is your custom widget!', // Tùy chọn mặc định
            buttonSelector: '[data-role="widget-button"]' // Chọn button theo data-role
        },

        _create: function() {
            var self = this;

            // Gán sự kiện click cho button
            $(this.options.buttonSelector).on('click', function() {
                self._showMessage(); // Gọi hàm hiển thị thông báo
            });
        },

        _showMessage: function() {
            alert(this.options.message); // Hiển thị thông báo
        }
    });

    return $.tigren.myWidget; // Trả về widget
});
