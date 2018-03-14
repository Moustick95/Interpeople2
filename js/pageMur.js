$(document).ready(function(){

    var result2 = $("#nouveauPoste").height();
            $('#boutonProfil').height(result2);

            $(window).resize(function () {
                var result = $("#nouveauPoste").height();
                $('#boutonProfil').height(result);
            });

$('#groupeListe').hide();

(function(){
    let nCommentaire = $('.fenetreCommentaire').length;
    $('#nombreCommentaire').html(nCommentaire);
})()

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

$(".button-collapse").sideNav( ); 

$( window ).resize(function() {
    var result = $(".cartePoste").height();
    $('.fenetreCommentaire').height(result);
});

var result = $(".cartePoste").height();
$('.fenetreCommentaire').height(result);

});