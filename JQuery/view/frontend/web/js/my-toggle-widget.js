define(['jquery'], function($) {
    'use strict';

    $.widget('custom.myToggleWidget', {
        options: {
            imageUrl: 'pub/media/testimonial/image/nen.jpg'
        },

        _create: function() {

            var toggleButton = $('<button>')
                .text('Show/Hide Image')
                .on('click', this._toggleImage.bind(this));

            this.imageContainer = $('<img>')
                .attr('src', this.options.imageUrl)
                .css({ display: 'none', width: '300px', height: 'auto' });

            this.element.append(toggleButton).append(this.imageContainer);
        },

        _toggleImage: function() {
            this.imageContainer.toggle();
        }
    });
    return $.custom.myToggleWidget;
});
