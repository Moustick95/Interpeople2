$(document).ready(function () {

    //Materialize pour la boite Option sous Valider
    $('select').material_select();

    $("#nouveauCommentaire").hide();

// Apparition de la boite pour ajouter un commentaire     
    $('#ajouterCommentaire').click(function () {
        if ($('#ajouterCommentaire').hasClass('Annuler')) {
            $("#nouveauCommentaire").hide();
            $('#ajouterCommentaire').removeClass('Annuler');
            $('#ajouterCommentaire').html('Ajouter un commentaire');            
        } else {
            $('#ajouterCommentaire').html('Annuler');
            $("#nouveauCommentaire").show();
            $('#ajouterCommentaire').addClass('Annuler');
        }
    });

    //Meme height pour les div dans le nouveau poste
    var result2 = $("#nouveauPoste").height();
    $('#boutonProfil').height(result2);
    $(window).resize(function () {
        var result = $("#nouveauPoste").height();
        $('#boutonProfil').height(result);
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