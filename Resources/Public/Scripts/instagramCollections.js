(function($) {
    var makeInstagramImagesDraggable = function() {
        $('.draggable-image').each(function () {
            $(this).draggable({
                helper: 'clone',
                opacity: 0.3,
                revert: 'invalid',
                revertDuration: 200,
                start: function (event, ui) {
                    $(event.toElement).closest('a').one('click', function (e) {
                        e.preventDefault();
                    });
                },
                stop: function (event, ui) {
                    // event.toElement is the element that was responsible
                    // for triggering this event. The handle, in case of a draggable.
                    $(event.toElement).closest('a').off('click');
                }
            });
        });
    }
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
                        var message = 'This instagram image is already part of the collection.';
                        message = window.Typo3Neos.I18n.translate('This instagram image is already part of the collection', message, 'TYPO3.Neos', 'Modules');
                        window.Typo3Neos.Notification.warning(message);
                    }
                }).fail(function () {
                    var message = 'Adding the instagram image to the collection failed.';
                    if (window.Typo3Neos) {
                        message = window.Typo3Neos.I18n.translate('Adding the instagram image to the collection failed', message, 'TYPO3.Neos', 'Modules');
                        window.Typo3Neos.Notification.error(message);
                    } else {
                        alert(message);
                    }
                });
            }
        });
    });


    function searchInstagram(){
        var searchform = $("#search-form");

        $.post(
            searchform.attr('action'),
            searchform.serialize(),
            'json'
        ).done(function(results){
            if(results!==null){
                $('#instagramCollectionImageList').hide();
                $('#instagramSearchResults').show();
                $(results.data).each(function(index, value){
                    $('#instagramSearchResultsList').append('<li>' +
                        '<div class="neos-img-container">' +
                        '<a href="' + value.link + '" target="_blank">' +
                            '<img class="draggable-image" data-image-id="' + value.id + '" data-image-shortlink="' + value.link +'" data-image-username="' + value.user.username + '" src="' + value.images.low_resolution.url + '" width="180" height="180" /><br />' +
                                value.user.username +
                        '</a>' +
                        '</div></li>');
                });
                $('#search-max-id').val(results.pagination.next_max_tag_id);
                makeInstagramImagesDraggable();
                $('#search-more').show();

            }


            console.log(results);
        }).fail(function(e){
            console.log('failed to search');
        });
    }

    $('#search-submit').click(function(e){
        e.preventDefault();
        $('#search-max-id').val('');
        $('#search-last-term').val($('#search-term').val());
        searchInstagram();
    });

    $('#search-more').click(function(){
        //$('#search-term').val($('#search-last-term').val());
        //searchInstagram();


        $('#search-term').val($('#search-last-term').val());
        searchInstagram();
    });


    $('span.InstagramCollections-edit-toggle').click(function(){
        $('.collectionEditingPanel').toggle();
        $('.collectionCountPanel').toggle();
        $('.collectionAddPanel').toggle();
    })

    $('[data-modal]').click(function(e) {
        e.preventDefault();
        var $this = $(this),
            $modal = $('#' + $this.data('modal')),
            $header = $('.neos-header', $modal),
            headerText = $header.text();
        $header.text(headerText.replace('{0}', $this.data('label')));
        $('#modal-form-object', $modal).val($this.data('object-identifier'));
        $(document).on('keyup.modal', function(e) {
            if (e.keyCode == 27) {
                $modal.modal('hide');
            }
        });
        $modal.modal().one('hide', function() {
            $this.focus();
            $header.text(headerText);
            $(document).off('keyup.modal');
        });
        $('[type="submit"]', $modal).focus();
    });



})(jQuery);