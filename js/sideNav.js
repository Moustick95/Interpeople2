$(document).ready(function () {
    $('#groupeListe').hide();
    //Fonction pour la sideNav
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

    $(".button-collapse").sideNav();
});