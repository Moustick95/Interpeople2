$(document).ready(function(){

    $('input#input_text, textarea#textarea1').characterCounter();

    $(".loader").hide();/*je cache le loader après le chargement de la page*/    
        // Init Sidenav
    
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
    
});


$('#case2').click(function(){
    $('#boutonDescription').text('Modifier des informations');
    $("#boutonDescription").attr("href", "#modal2");
});



$('#case3').click(function(){
    $('#boutonDescription').text('Modifier votre compte');
    $("#boutonDescription").attr("href", "#modal3");
});

$('#boutonDescription').click(function(){

    if($('#case1').hasClass('active')){
        $('#modal1').modal('open');
    }

    if($('#case2').hasClass('active')){
        $('#modal2').modal('open');
    }

    if($('#case3').hasClass('active')){
        $('#modal3').modal('open');
    }

});
});

$(".button-collapse").sideNav( ); 



   

