$(document).ready(function(){

    $("#colonne1").hover(function(){
        $(this).css("border-bottom-right-radius", "80px 80px","fast");
        }, function(){
        $(this).css("border-bottom-right-radius", "0px 0px");
    });
    $("#colonne2").hover(function(){
        $(this).css("border-bottom-left-radius", "80px 80px","fast");
        }, function(){
        $(this).css("border-bottom-left-radius", "0px 0px");
    });
    $('.modal').modal();
});
 