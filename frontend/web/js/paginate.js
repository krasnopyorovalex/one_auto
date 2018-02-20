(function () {

    var contentBody = jQuery('.content__body'),
        paginateBtn = contentBody.find('.load__more-btn span'),
        box = contentBody.find('.items');

    var paginate = {
        'url': window.location.pathname,
        'path': '/page/',
        'offset': paginateBtn.attr('data-offset'),
        'count': paginateBtn.attr('data-count'),
        'getPath': function () {
            return this.url + this.path + this.offset
        },
        'setOffset': function (value) {
            return this.offset = value;
        }
    };

    contentBody.on('click', '.load__more-btn', function () {
        jQuery.post(paginate.getPath(), function (data) {
            if(data.offset >= paginate.count){
                paginateBtn.closest('.load__more-btn').remove();
            }
            return paginate.setOffset(data.offset) && box.find('.item:last-child').after(data['products']);
        });
    });

    /*
    |-----------------------------------------------------------
    |   flash message
    |-----------------------------------------------------------
    */
    jQuery('#success__message').fadeIn().delay(5000).fadeOut();

})(jQuery);