$(document).ready(function () {

    //fonction pour changer taille div
    function resize(divInitial, divModifier) {
        var result = divInitial.height();
        divModifier.height(result);
    }
    resize($('.card-stacked'), $('.card-panel'));

    $(window).resize(function () {
    resize($('.card-stacked'), $('.card-panel'));    
    });
});