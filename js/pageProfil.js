$(document).ready(function () {

    Materialize.updateTextFields();

    $('input#input_text, textarea#textarea1').characterCounter();

    $(".loader").hide();

    $('.modal').modal();

    $('#groupeListe').hide();

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



    $('#case1').click(function () {
        $('#boutonDescription').text('Modifier la description');
        $("#boutonDescription").attr("href", "#modal1");
        $('#boutonDescription').removeClass('disabled');
    });


    $('#case2').click(function () {
        $('#boutonDescription').text('Modifier des informations');
        $("#boutonDescription").attr("href", "#modal2");
        $('#boutonDescription').removeClass('disabled');
    });

    $('#supprimerCompte').click(function () {
        confirm('T\'es sur de toi ?');
    });

    /* Edition des postes */
    $('.editerPoste').click(function () {

        message = $('.messagePoste');
        let bouton;

        console.log(bouton);

        function bool(bouton, etat) {
            if (etat == 1) {
                bouton = true;
            } else {
                bouton = false
            }
            return bouton;
        }

        function ajoutBouton() {
            $('.messagePoste').addClass('contenteditable');
            $(".messagePoste").attr("contenteditable", "true");
            $(".messagePoste").focus();
            jQuery('.messagePoste').append(' <div style="width:100%;margin-top:5px;" class="center-align"><button class="btn blue darken-4" id="boutonTexte" >Valider</button></div>');
        }

        function supprimerBouton() {
            $('#boutonTexte').remove();
            $('.messagePoste').attr("contenteditable", "false");
            bouton = bool(bouton, 0);
        }

        if (!(message.hasClass('contenteditable'))) {
            bouton = bool(bouton, 1);
            ajoutBouton();
            console.log(bouton);

        } else {
            if (bouton == false || bouton == null) {
                ajoutBouton();
                bouton = bool(bouton, 1);
                console.log(bouton);
            }
        }

        $('#boutonTexte').click(function () {
            supprimerBouton();
            console.log(bouton);
        });
    });
    /* Edition des postes */

    /* Edition des commentaires */
    $('.editerCommentaire').click(function () {
        $('.texteCommentaire').addClass('contenteditable');
        $(".texteCommentaire").attr("contenteditable", "true");
        $(".texteCommentaire").focus();

        jQuery('.texteCommentaire').append(' <div style="width:100%;margin-top:5px;" class="center-align"><button class="btn blue darken-4" id="boutonTexte" >Valider</button></div>');

        $('#boutonTexte').click(function () {
            $('#boutonTexte').remove();
            $('.texteCommentaire').attr("contenteditable", "false");
        });
    });

    /* Edition des commentaires */

    $('#case3').click(function () {
        $('#boutonDescription').text('');
        $('#boutonDescription').addClass('disabled');
    });

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