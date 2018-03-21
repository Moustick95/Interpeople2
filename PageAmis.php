<?php
include 'navbar.php';

$UtilisateursNonAmis = $bdd->query(' SELECT `Nom`, `Prenom`, `Photo`, `Profil_ID` FROM `utilisateur` WHERE `Profil_ID` != "'.$_SESSION['id'].'"  && `Profil_ID` NOT IN (SELECT `Profil_ID_Utilisateur` FROM `ami` WHERE `Profil_ID` = "'.$_SESSION['id'].'" OR `Profil_ID_Utilisateur` = "'.$_SESSION['id'].'") LIMIT 10 ');
$UtilisateursNonAmis = $UtilisateursNonAmis->fetchAll(PDO::FETCH_ASSOC);
$UtilisateursAmis = $bdd->query(' SELECT `Nom`, `Prenom`, `Photo`, `Profil_ID` FROM `utilisateur` WHERE `Profil_ID` IN (SELECT `Profil_ID_Utilisateur` FROM `ami` WHERE `Profil_ID` = "'.$_SESSION['id'].'") ');
$UtilisateursAmis = $UtilisateursAmis->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

    <!--Import Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

    <!-- Import CSS -->
    <link rel="stylesheet" href="css/styleAmis.css">
    <link rel="stylesheet" href="css/styleSideNav.css">

    <title>Profil/Interpeople</title>

</head>

<body>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Import jQuery before materialize.js-->

   <!-- Début Header -->
   <nav>
        <div class="nav-wrapper blue darken-1" id="navTop">
            <a href="#" class="brand-logo center" id="titreNav">Amis</a>
        </div>
    </nav>
    <!-- Fin Header -->

    <!-- Petite ligne -->
    <div class="col s12 white" style="height:3px;">
    </div>
    <!-- Petite ligne -->

    <!-- Bouton Navbar -->
    <div id="btnSide">
        <a href="#" data-activates="slide-out" class="btn btn-large blue darken-3 white-text waves-effect button-collapse">
            <i class="material-icons">chevron_right</i>
        </a>
    </div>
    <!-- Bouton Navbar -->


    <div class="row">
        <div class="input-field col s6 offset-s3 z-depth-4 white valign-wrapper">
            <i class="material-icons prefix">search</i>
            <input type="text" id="autocomplete-input" class="autocomplete">
            <label for="autocomplete-input">Trouver un ami</label>
        </div>
    </div>

    <div class="row" style="margin-bottom:0px !important">
        <div class="col s4 offset-s1">
            <h4>Mes suggestions</h4>
        </div>
    </div>
   
    
    <div class="row">
        <div class="col s10 offset-s1 blue lighten-4 z-depth-2 blocAmis">
            <div class="row">
                <div class="col s12 left-align">
                    <!-- Carte Amis -->
                    <?php
                    foreach ($UtilisateursNonAmis as $UtilisateurNonAmi)
                        echo '<div class="Contenant">
                            <div class="card z-depth-3">
                                <div class="card-image">
                                    <img class="responsive-img" src='.$UtilisateurNonAmi['Photo'].'>
                                </div>
                                <div class="card-content center-align  light-blue darken-4 white-text">
                                    <p>'.$UtilisateurNonAmi['Prenom']." ".$UtilisateurNonAmi['Nom'].'</p>
                                </div>
                                <a href="PageProfil.php?Profil='.$UtilisateurNonAmi['Profil_ID'].'" class="btn waves-effect" id="bouton">Profil</a>
                                <button class="boutonAjoutAmi" id='.$UtilisateurNonAmi['Profil_ID'].' >
                                    <a class="btn teal left-align valign-wrapper bouton" style="padding:0px !important; width:100% !important;">Ajouter</a>
                                </button>
                            </div>
                        </div>';
                    ?>
                            <!-- Carte Amis -->
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="row" style="margin-bottom:0px !important">
                <div class="col s4 offset-s1">
                    <h4>Mes amis</h4>
                </div>
            </div>
    <?php
    //Amis
    $i2 = 0;
    $boucle2 = 1;
        while ($i2 < count($UtilisateursAmis)) {
            echo '<div class="row">
            <div class="col s10 offset-s1 blue lighten-4 z-depth-2 blocAmis">
                <div class="row">
                    <div class="col s12 left-align">';
                    for (;$i2 < 10*$boucle2; $i2 += 1) {
                        if ($i2 < count($UtilisateursAmis)) {
                            echo '<!-- Carte Amis -->
                            <div class="Contenant">
                                <div class="card z-depth-3">
                                    <div class="card-image">
                                        <img class="responsive-img" src='.$UtilisateursAmis[$i2]['Photo'].'>
                                    </div>
                                    <div class="card-content center-align  light-blue darken-4 white-text">
                                        <p>'.$UtilisateursAmis[$i2]['Prenom']." ".$UtilisateursAmis[$i2]['Nom'].'</p>
                                    </div>
                                    <a href="PageProfil.php?Profil='.$UtilisateursAmis[$i2]['Profil_ID'].'" class="btn waves-effect" id="bouton">Profil</a>
                                </div>
                            </div>
                            <!-- Carte Amis -->';
                        }
                    }
                    echo '</div>
                </div>
            </div>
        </div>';
    $boucle2 += 1;
    }
    ?>
    <script src="js/pageAmis.js"></script>
    <script src="js/sideNav.js"></script>

</body>

</html>