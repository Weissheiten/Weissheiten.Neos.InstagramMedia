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
        linkImageToCollectionImageField = $('#link-image-to-instagramcollection-form-image', linkImageToInstagramCollectionForm),
        linkImageToCollectionField = $('#link-image-to-instagramcollection-form-imagecollection', linkImageToInstagramCollectionForm);
    $('.droppable-instagramCollection').each(function () {
        $(this).droppable({
            addClasses: false,
            activeClass: 'instagramcollection-drag-active',
            hoverClass: 'instagramcollection-drag-hover',
            tolerance: 'pointer',
            drop: function (event, ui) {
                var instagramCollection = $(this),
                    asset = $(ui.draggable[0]),
                    assetIdentifier = asset.data('image-identifier'),
                    countElement = instagramCollection.children('span'),
                    count = parseInt(countElement.text());
                linkImageToCollectionImageField.val(assetIdentifier);
                linkImageToCollectionField.val(instagramCollection.data('instagramCollection-identifier'));
                countElement.html('<span class="neos-ellipsis" />');
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
            }
        });
    });

    $('span.InstagramCollections-edit-toggle').click(function(){
        $('.collectionEditingPanel').toggle();
        $('.collectionCountPanel').toggle();
        $('.collectionAddPanel').toggle();
    })

})(jQuery);