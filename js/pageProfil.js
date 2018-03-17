$(document).ready(function () {

    Materialize.updateTextFields();

    $('input#input_text, textarea#textarea1').characterCounter();
    $(".loader").hide();
    $('.modal').modal();
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

    //Affiche la Description
    $('#case1').click(function () {
        $('#boutonDescription').text('Modifier la description');
        $("#boutonDescription").attr("href", "#modal1");
        $('#boutonDescription').removeClass('disabled');
    });

    //Affiche les  Informations générales
    $('#case2').click(function () {
        $('#boutonDescription').text('Modifier des informations');
        $("#boutonDescription").attr("href", "#modal2");
        $('#boutonDescription').removeClass('disabled');
    });

    //Affiche le Compte
    $('#case3').click(function () {
        $('#boutonDescription').text('');
        $('#boutonDescription').addClass('disabled');
    });

    //Supprime le compte
    $('#supprimerCompte').click(function () {
        confirm('T\'es sur de toi ?');
    });

    //Fonction pour ajouter les boutons d'éditions
    function ajoutBouton(Contenu, bouton) {
        $(Contenu).addClass('contenteditable');
        $(bouton).addClass('disabled');
        $(Contenu).attr("contenteditable", "true");
        $(Contenu).focus();
        jQuery(Contenu).append(' <div style="margin-top:5px;margin-bottom:10px;" class="center-align col s12"><button class="btn blue darken-4" id="validerEditer" >Valider</button><button class="btn blue darken-4" style="margin-left:7px;" id="annulerEditer" >Annuler</button></div>');
    }

    //Fonction pour valider l'édition
    function validerEdition(contenu, bouton) {
        $(bouton).removeClass('disabled');
        $('#validerEditer').remove();
        $('#annulerEditer').remove();
        $(contenu).attr("contenteditable", "false");
    }

    //Fonction pour annuler l'édition
    function annulerEdition(contenu, bouton, message) {
        $(contenu).text(message);
        $(bouton).removeClass('disabled');
        $('#validerEditer').remove();
        $('#annulerEditer').remove();
        $(contenu).attr("contenteditable", "false");
    }

    // Edition des postes 
    $('.editerPoste').click(function () {
        message = $('#messagePoste').text();
        ajoutBouton($('#textePoste'), $('#editPoste'));
        $('#validerEditer').click(function () {
            validerEdition($('#textePoste'), $('#editPoste'));
        });
        $('#annulerEditer').click(function () {
            annulerEdition($('#textePoste'), $('#editPoste'),message );
        });
    });


    //Edition des commentaires 
    $('#editerCommentaire').click(function () {
        message = $('#texteCommentaire').text();
        ajoutBouton($('#texteCommentaire'), $('#editerCommentaire'));
        $('#validerEditer').click(function () {
            validerEdition($('#texteCommentaire'), $('#editerCommentaire'));
        });
        $('#annulerEditer').click(function () {
            annulerEdition($('#texteCommentaire'), $('#editerCommentaire'),message );
        });
    });

    //Bouton qui affiche les modal
    $('#boutonDescription').click(function () {
        if ($('#case1').hasClass('active')) {
            $('#modal1').modal('open');
        }
        if ($('#case2').hasClass('active')) {
            $('#modal2').modal('open');
        }
    });
});

$(".button-collapse").sideNav(); 