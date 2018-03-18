$(document).ready(function () {

    function resize(divInitial, divModifier,ecran) {    
        let result = $('#ligne1').height();
        result-=ecran;
        divModifier.height(result);
    }

    $('#connexion').click(function () {
        $('#modal1').modal('open');
        $('#email2').focus();
    });

    $('#modal2Fermer').click(function(){
        $('#modal2').modal('close');        
    })

    $('#modal1Fermer').click(function(){
        $('#modal1').modal('close');        
    })

    $('#inscription').click(function () {
        $('#modal2').modal('open');
        $('#email2').focus();
    });

    resize($('#ligne1'), $('#colonne1'),100);
    resize($('#ligne1'), $('#colonne2'),100);

    $(window).resize(function () {
        resize($('#ligne1'), $('#colonne1'),100)
        resize($('#ligne1'), $('#colonne2'),100)
    });

    $(function() { 
        var windowswidth= $(window).width();
        console.log(windowswidth);
        if(windowswidth < 1366){
            resize($('#ligne1'), $('#colonne1'),0);
            resize($('#ligne1'), $('#colonne2'),0);
            $(window).resize(function () {
                resize($('#ligne1'), $('#colonne1'),0)
                resize($('#ligne1'), $('#colonne2'),0)
            });
        }
    });

    $(function() { 
        var windowswidth= $(window).width();
        if(windowswidth < 1000){
            $('#colonne1').hide();
            $('#colonne2').hide();            
        }
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
        dismissible: false, // Modal can be dismissed by clicking outside of the modal
        opacity: .25, // Opacity of modal background
        inDuration: 300, // Transition in duration
        outDuration: 150, // Transition out duration
        startingTop: '4%', // Starting top style attribute
        endingTop: '10%', // Ending top style attribute
    }
    );


});


