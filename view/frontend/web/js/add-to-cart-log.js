define(['jquery'], function ($) {
    'use strict';

    return function (config) {
        $(document).ready(function () {
            $(document).on('click', '.action.tocart', function (event) {
                console.log(config.message);
                alert(config.message);
            });
        });
    };
});
