$(document).ready(function(){
    updateCounter(100, 125);
    
    $('.counter-field').keyup(function(){
        $(this).change();
    });
    
    $('.counter-field').change(function(){
        updateCounter(100, 125);
    });
});

function updateCounter(minCharsAllowed, maxCharsAllowed){
    var counter = 0;
    
    $('.counter-field').each(function(){
        counter += $(this).val().length;
    });
    
    $('#counter span').html(counter);
    
    if(counter > maxCharsAllowed || counter < minCharsAllowed){
        $('#counter').removeClass('alert-info');
        $('#counter').addClass('alert-error');
    }else{
        $('#counter').removeClass('alert-error');
        $('#counter').addClass('alert-info');
    }
}
