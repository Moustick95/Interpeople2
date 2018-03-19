$(document).ready(function () {

    Materialize.updateTextFields();

    $('.modal').modal({
        dismissible: false, // Modal can be dismissed by clicking outside of the modal
        opacity: .25, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 150, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
    }
    );

    $('#modal1Fermer').click(function(){
        $('#modal1').modal('close');        
    })
    $('#modal2Fermer').click(function(){
        $('#modal2').modal('close');        
    })
    $('#modal3Fermer').click(function(){
        $('#modal3').modal('close');        
    })
    $('#modal4Fermer').click(function(){
        $('#modal4').modal('close');        
    })
    $('#modal5Fermer').click(function(){
        $('#modal5').modal('close');        
    })

    

    $('input#input_text, textarea#textarea1').characterCounter();
    $(".loader").hide();

    //Focus sur la modal à l'ouverture
    $('#connexion').click(function () {
        $('#modal1').modal('open');
        $('#email2').focus();
    });

    //Fermeture du modal par le bouton
    $('#modal2Fermer').click(function () {
        $('#modal2').modal('close');
    })

    //Affiche la partie Description
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
        Materialize.toast('Modification validé', 2500)        
        $(bouton).removeClass('disabled');
        $('#validerEditer').remove();
        $('#annulerEditer').remove();
        $(contenu).attr("contenteditable", "false");
    }

    //Fonction pour annuler l'édition
    function annulerEdition(contenu, bouton, message) {
        Materialize.toast('Modification annulé', 2500)
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
            annulerEdition($('#textePoste'), $('#editPoste'), message);
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
            annulerEdition($('#texteCommentaire'), $('#editerCommentaire'), message);
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
