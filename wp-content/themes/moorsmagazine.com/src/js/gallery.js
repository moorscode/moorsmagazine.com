(function($) {
    $(document.body).ready(function () {

        var base = $('meta[name="template"]').attr('content');

        $('#galerie').find('a').lightBox({
            overlayBgColor: galleryColor,
            overlayOpacity: 1.0,
            imageLoading: base + "/img/lb-loading.gif",
            imageBtnClose: base + "/img/close.gif",
            imageBtnPrev: base + "/img/prev.gif",
            imageBtnNext: base + "/img/next.gif",
            imageBlank: base + "/img/blank.gif"
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
                        imageLoading: base + "/img/lb-loading.gif",
                        imageBtnClose: base + "/img/close.gif",
                        imageBtnPrev: base + "/img/prev.gif",
                        imageBtnNext: base + "/img/next.gif",
                        imageBlank: base + "/img/blank.gif"
                    });
                }
            });
        }
    });
})(jQuery);
