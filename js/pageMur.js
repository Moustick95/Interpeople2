$(document).ready(function(){

$('#groupeListe').hide();

(function(){
    let nCommentaire = $('.blue-grey').length;
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
    var result = $("#cartePoste").height();
    $('#fenetreCommentaire').height(result);
});

var result = $("#cartePoste").height();
$('#fenetreCommentaire').height(result);

});