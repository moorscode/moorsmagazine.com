(function($) {
    $(document.body).ready(function () {

        var base = $('meta[name="template"]').attr('content');

        $('#galerie a').lightBox({
            overlayBgColor: '#000000',
            overlayOpacity: 1.0,
            imageLoading: base + "/assets/img/lb-loading.gif",
            imageBtnClose: base + "/assets/img/close.gif",
            imageBtnPrev: base + "/assets/img/prev.gif",
            imageBtnNext: base + "/assets/img/next.gif",
            imageBlank: base + "/assets/img/blank.gif"
        });

        var $gallery = $('#gallery');

        if ($gallery.length) {
            var galleryColor = $gallery.attr('bgcolor');
            $.ajax({
                url: ajaxurl,
                data: {
                    action: 'gallery',
                    source: originalurl
                },
                method: 'GET',
                success: function (html) {
                    $gallery.html(html);
                    $gallery.find('img').css('border', '1px solid ' + galleryColor);
                    $gallery.find('a').lightBox({
                        overlayBgColor: galleryColor,
                        overlayOpacity: 1.0,
                        imageLoading: base + "/assets/img/lb-loading.gif",
                        imageBtnClose: base + "/assets/img/close.gif",
                        imageBtnPrev: base + "/assets/img/prev.gif",
                        imageBtnNext: base + "/assets/img/next.gif",
                        imageBlank: base + "/assets/img/blank.gif"
                    });
                }
            });
        }
    });
})(jQuery);
