define([], function() {
    'use strict';

    return function(target) {
        return target.extend({
            _showMessage: function() {
                alert(this.options.message + ' Welcome to Tigren Clothings, Modified by Mixin!');
            }
        });
    };
});
