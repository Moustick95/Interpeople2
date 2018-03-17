$(document).ready(function () {

    //Materialize pour la boite Option sous Valider
    $('select').material_select();

    $("#nouveauCommentaire").hide();

// Apparition de la boite pour ajouter un commentaire     
    $('#ajouterCommentaire').click(function () {
        if ($('#ajouterCommentaire').hasClass('Annuler')) {
            $("#nouveauCommentaire").slideToggle("slow");
            $('#ajouterCommentaire').removeClass('Annuler');
            $('#ajouterCommentaire').html('Ajouter un commentaire');            
        } else {                              
            $('#ajouterCommentaire').html('Annuler');
            $("#nouveauCommentaire").slideToggle("slow");
            $('#ajouterCommentaire').addClass('Annuler');
        }
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

    //Meme hieght du bloc Poste et Commentaire
    $(window).resize(function () {
        var result = $(".cartePoste").height();
        $('.fenetreCommentaire').height(result);
    });
    var result = $(".cartePoste").height();
    $('.fenetreCommentaire').height(result);

});