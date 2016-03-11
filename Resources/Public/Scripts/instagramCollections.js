(function($) {
    $('.draggable-image').each(function() {
        $(this).draggable({
            helper: 'clone',
            opacity: 0.3,
            revert: 'invalid',
            revertDuration: 200,
            start: function(event, ui) {
                $(event.toElement).closest('a').one('click', function(e) {
                    e.preventDefault();
                });
            },
            stop: function(event, ui) {
                // event.toElement is the element that was responsible
                // for triggering this event. The handle, in case of a draggable.
                $(event.toElement).closest('a').off('click');
            }
        });
    });

    var linkImageToInstagramCollectionForm = $('#link-image-to-instagramcollection-form'),
        linkImageToInstagramCollectionFormCollection = $('#link-image-to-instagramcollection-form-imagecollection', linkImageToInstagramCollectionForm),
        linkImageToInstagramCollectionFormImageUsername = $('#link-image-to-instagramcollection-form-imageUsername', linkImageToInstagramCollectionForm),
        linkImageToInstagramCollectionFormImageShortLink = $('#link-image-to-instagramcollection-form-imageShortlink', linkImageToInstagramCollectionForm);

    $('.droppable-instagramCollection').each(function () {
        $(this).droppable({
            addClasses: false,
            activeClass: 'instagramcollection-drag-active',
            hoverClass: 'instagramcollection-drag-hover',
            tolerance: 'pointer',
            drop: function (event, ui) {
                var instagramCollection = $(this),
                    asset = $(ui.draggable[0]),
                    assetLink = asset.data('image-shortlink'),
                    assetUser = asset.data('image-username'),
                    countElement = instagramCollection.children('td.collectionActions').children('div.collectionCountPanel').children('span'),
                    count = parseInt(countElement.text());

                linkImageToInstagramCollectionFormCollection.val(instagramCollection.find('a').data('instagramcollectionIdentifier'));
                linkImageToInstagramCollectionFormImageUsername.val(assetUser);
                linkImageToInstagramCollectionFormImageShortLink.val(assetLink);
                countElement.html('<span class="count" />');
               // linkImageToInstagramCollectionForm.submit();
                /*
                $.post(
                    linkImageToInstagramCollectionForm.attr('action'),
                    $('#link-image-to-instagramcollection-form').serialize(),
                    'json'
                ).done(function (result) {
                    if (result === true) {
                        countElement.html(count + 1);
                        var text = instagramCollection.clone();
                        text.children().remove();
                    } else {
                        countElement.html(count);
                    }
                }).fail(function () {
                    var message = 'Adding the image to the collection failed.';
                    if (window.Typo3Neos) {
                        message = window.Typo3Neos.I18n.translate('media.addingAssetsToCollectionFailed', message, 'TYPO3.Neos', 'Modules');
                        window.Typo3Neos.Notification.error(message);
                    } else {
                        alert(message);
                    }
                });
                */
            }
        });
    });

    $('span.InstagramCollections-edit-toggle').click(function(){
        $('.collectionEditingPanel').toggle();
        $('.collectionCountPanel').toggle();
        $('.collectionAddPanel').toggle();
    })

})(jQuery);