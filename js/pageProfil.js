$(document).ready(function(){


    $(".loader").hide();/*je cache le loader après le chargement de la page*/    
        // Init Sidenav
    
    $('#groupeListe').hide();

    $("#groupeButton").click(function(){
        var $this = $(this);
        
        if($this.data('clicked')) {
            $this.data('clicked', false);
            $('#groupeListe').hide();
        }
        else {
            $this.data('clicked', true);
            $('#groupeListe').show();
        }
});
});
$(".button-collapse").sideNav(); 
