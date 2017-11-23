/**
 * Created by danny on 20/07/2016.
 */
$(document).ready(function(e){

    $('.clone-torrent-form').click(function(e){
        e.preventDefault();

        var original = $('.torrent-seperator.clone-me');

        var clone = original.clone();
        clone.find(':input').val('');
        clone.removeClass('clone-me');
        clone.insertBefore($('.torrent-seperator:last'));


    });


});
