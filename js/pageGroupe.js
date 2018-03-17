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

    //SideNav
    $('#groupeListe').hide();

    //SideNav
    $("#groupeButton").click(function () {
        var $this = $(this);

        if ($this.data('clicked')) {
            $this.data('clicked', false);
            $('#groupeListe').hide();
        }
        else {
            $this.data('clicked', true);
            $('#groupeListe').show();
        }
    });

    //SideNav
    $(".button-collapse").sideNav();
});