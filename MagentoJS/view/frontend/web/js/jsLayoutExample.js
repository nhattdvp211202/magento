define(['jquery'], function ($) {
    'use strict';

    return function (config, element) {
        $(element).on('click', '#click-button', function () {
            alert(config.message);
        });
    };
});
