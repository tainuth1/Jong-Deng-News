jQuery('document').ready(function(){

    jQuery('.admin li.parent').click(function(){
        $(this).find('.child').slideToggle();
        $(this).find('img').toggleClass('rotate');
    });

    $('.btn-remove').click(function(){
        var data = $(this).attr('remove-id');
        $('.value_remove').val(data);
    });

    // @tiny
    tinymce.init({
        selector: 'textarea',
        plugins: 'advlist autolink lists link image charmap preview anchor pagebreak',
        toolbar_mode: 'floating',
    });

});
