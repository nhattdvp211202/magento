define([
    'jquery'
], function ($) {
    'use strict';

    return function (config, element) {
        $(element).on('click', function () {
            alert(config.message);
        });
    }
});
