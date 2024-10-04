define(['jquery'], function ($) {
    'use strict';

    return function (config) {
        $(document).on('click', '.action.tocart', function (event) {
            console.log(config.message);
        });
    };
});
