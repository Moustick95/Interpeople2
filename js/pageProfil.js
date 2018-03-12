$(document).ready(function(){

    Materialize.updateTextFields();

    $('input#input_text, textarea#textarea1').characterCounter();

    $(".loader").hide();
    
    $('.modal').modal();

    $('#groupeListe').hide();

    $("#groupeButton").click(function(){
        var $this = $(this);
        
        if($this.data('clicked')) {
            $this.data('clicked', false);
            $('#groupeListe').hide();
        }
        else {
            $this.data('clicked', true);
            $('#groupeListe').show();
        }
    });

$('#case1').click(function(){
    $('#boutonDescription').text('Modifier la description');
    $("#boutonDescription").attr("href", "#modal1");
    $('#boutonDescription').removeClass('disabled');    
});


$('#case2').click(function(){
    $('#boutonDescription').text('Modifier des informations');
    $("#boutonDescription").attr("href", "#modal2");
    $('#boutonDescription').removeClass('disabled');
});



$('#case3').click(function(){
    $('#boutonDescription').text('');
    $('#boutonDescription').addClass('disabled');
});

$('#boutonDescription').click(function(){

    if($('#case1').hasClass('active')){
        $('#modal1').modal('open');
    }

    if($('#case2').hasClass('active')){
        $('#modal2').modal('open');
    }
});

});

$(".button-collapse").sideNav( ); 



   

