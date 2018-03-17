$(document).ready(function () {

    function resize(divInitial, divModifier) {
        let result = $('#ligne1').height();
        divModifier.height(result);
    }

    $('#connexion').click(function () {
        $('#modal1').modal('open');
        $('#email2').focus();
    });

    resize($('#ligne1'), $('#colonne1'));
    resize($('#ligne1'), $('#colonne2'));

    $(window).resize(function () {
        resize($('#ligne1'), $('#colonne1'))
        resize($('#ligne1'), $('#colonne2'))
    });

    $("#colonne1").hover(function () {
        $(this).css("border-bottom-right-radius", "80px 80px", "fast");
    }, function () {
        $(this).css("border-bottom-right-radius", "0px 0px");
    });
    $("#colonne2").hover(function () {
        $(this).css("border-bottom-left-radius", "80px 80px", "fast");
    }, function () {
        $(this).css("border-bottom-left-radius", "0px 0px");
    });



    $('.modal').modal({
        dismissible: true, // Modal can be dismissed by clicking outside of the modal
        opacity: .25, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 150, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
    }
    );


});


