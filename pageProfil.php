<?php
session_start();
if (!ISSET($_SESSION['id']))
    header('location:index.php?error=id');

try {
    $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', 'root');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
$id = $_SESSION['id'];
$InfoGeneral = $bdd->query('SELECT `Nom`,`Prenom`,`Email`, `Photo`, `Photo_Fond`, `Date_Naissance` FROM `utilisateur` WHERE `Profil_ID` = "'.$id.'"  ');
$info = $InfoGeneral->fetchAll(PDO::FETCH_ASSOC);
$profile = $_SESSION['id'];

if (ISSET($_GET['Profil'])) {
    $ProfileVisite = $bdd->prepare('SELECT * FROM `utilisateur` WHERE `Profil_ID` = :Profil ');
    $ProfileVisite -> bindParam(":Profil", $_GET['Profil']);
    $ProfileVisite -> execute();
    $InfoVisite = $ProfileVisite->fetchAll(PDO::FETCH_ASSOC);
    $profile = $_GET['Profil'];
    if (sizeof($InfoVisite) == 0)
        header('location:?Profil='.$_SESSION['id']);
}

if (ISSET($_POST['formDescription']) && ISSET($_POST['nouvelleDescription'])) {
    $Description = $bdd->prepare(' UPDATE `utilisateur` SET `Description` = :formDescription WHERE `utilisateur`.`Profil_ID` = "'.$_SESSION['id'].'" ');
    $Description -> bindParam(":formDescription", $_POST['formDescription']);
    $Description -> execute();
    header('location:?Profil='.$_SESSION['id']);
}
if (ISSET($_POST['nom']) && ISSET($_POST['prenom']) && ISSET($_POST['date']) && ISSET($_POST['hobbies'])) {
    $Information = $bdd->prepare('UPDATE `utilisateur` SET `Prenom` = :Prenom, `Nom` = :Nom, `Date_Naissance` = :DateAnniv, `Hobbies` = :Hobbies WHERE `Profil_ID` = "'.$id.'" ');
    $Information -> bindParam(":Prenom", $_POST['prenom']);
    $Information -> bindParam(":Nom", $_POST['nom']);
    $Information -> bindParam(":DateAnniv", $_POST['date']);
    $Information -> bindParam(":Hobbies", $_POST['hobbies']);
    $Information -> execute();
    header('location:?Profil='.$_SESSION['id'].'');
}

$PubliGeneral = $bdd->query('SELECT `Contenu` FROM `publication` WHERE `Profil_ID` = "'.$profile.'" ');
$publi = $PubliGeneral->fetchAll(PDO::FETCH_ASSOC);

$bdd->query(' UPDATE `utilisateur` SET `Status` = "Connecté" WHERE `Profil_ID` = "'.$_SESSION['id'].'"  ');
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
    <link rel="stylesheet" href="css/styleProfil.css">
    <link rel="stylesheet" href="css/styleSideNav.css">
    <!-- Import CSS -->
    
    <title>Profil/Interpeople</title>

</head>





<body>

    <!--Import jQuery before materialize.js-->
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Import jQuery before materialize.js-->

    <!-- Animation durant le chargement de la page -->
    <div class="loader center-align">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Animation durant le chargement de la page -->


    <div w3-include-html="navbar.php"></div>
                     
    <!-- Composant de la page -->
    <!-- ------------------------- -->

     <!-- Début Header -->
    <nav>
        <div class="nav-wrapper indigo" id="navTop">
            <a href="PageProfil.php" class="brand-logo center" id="titreNav">Interpeople</a>
        </div>
    </nav>
     <!-- Fin Header -->              
    <!-- Petite ligne -->
    <div class="col s12  indigo lighten-3" style="height:3px;">
    </div>
    <!-- Petite ligne -->

    <!--  Ligne 1 -->
    <div class="row">
        <div class="col s12 light-blue darken-4 z-depth-1 white-text">
            <?php
                echo '<h4 class="center-align" id="prenomTitre">'.$InfoVisite[0]['Prenom']." ".$InfoVisite[0]['Nom'].'</h4>';
            ?>
        </div>

        <!-- Image Profil -->
        <div class="col s3 offset-s1">
            <div class="card-panel white z-depth-3 center-align hauteur">
                <?php
                echo '<img class="responsive-img z-depth-1" width="200" src='.$InfoVisite[0]['Photo'].' alt="Image-Profil">';
                ?>
                <div id="modifierImage">
                    <?php
                    if (ISSET($_GET['Profil']) && $_SESSION['id'] == $_GET['Profil'])
                    echo '<a class="btn-floating orange btn-large z-depth-2">
							<i class="large material-icons ">mode_edit</i></a>';
                    ?>
                </div>
            </div>
        </div>
        <!-- Image Profil -->

        <!-- Description Utilisateur -->
        <div class="col s12 m6 offset-m1">
            <div class="card horizontal z-depth-3">
                <div class="card-stacked indigo lighten-4">
                    <div class="card-content z-depth-1 white" id="carteDescription">
                        <div class="card-tabs">
                        	<ul class="tabs tabs-fixed-width">
                            	<li class="tab">
									<a id="case1" href="#test4">Description</a></li>
                            	<li class="tab">
									<a id="case2" class="active" href="#test5">Informations générales</a></li>
                            	<?php
                            	if ($_SESSION['id'] == $_GET['Profil'])
                                    echo '<li class="tab">
                                          <a id="case3" href="#test6">Compte</a></li>';
                            	?>
                        	</ul>
                        </div>
                        <div class="card-content grey lighten-4" id="infosUtilisateur">
						<!-- Contenu panneau Description -->
                        <?php
                        if ($InfoVisite[0]['Description'] != null)
                            echo '<div id="test4">'.$InfoVisite[0]['Description'].'</div>';
                        ?>
                        
                        <div id="test5">
                            <ul class="collection " id="colonne1">
                                <li class="collection-item">Date de naissance</li>
                                <li class="collection-item">Hobbies :</li>
                            </ul>
                            <ul class="collection" id="colonne2">
                            <?php
                                if ($InfoVisite[0]['Date_Naissance'] != null) {
                                    date_default_timezone_set('Europe/Paris');
                                    sscanf($InfoVisite[0]['Date_Naissance'], "%4d-%2s-%2d", $annee, $mois, $jour);
                                    setlocale(LC_TIME, 'fr');
                                    $date = utf8_encode(strftime("%d %B %Y",strtotime($mois."/".$jour."/".$annee)));
                                    echo '<li class="collection-item">'.$date.'</li>';
                                    }
                                else
                                    echo '<li class="collection-item">Detail non renseigné </li>';
                                if ($InfoVisite[0]['Hobbies'] != null)
                                    echo '<li class="collection-item">'.$InfoVisite[0]['Hobbies'].'</li>' ;
                                else
                                    echo '<li class="collection-item">Pas de Hobbies </li>';
                            ?>
                            </ul>
                            </div>
                            
							<!-- Contenu panneau Informations générales -->
                            <!-- Contenu panneau Compte -->
                            <div id="test6">
                                <ul style="display:flex;flex-direction:column;">
                                <?php
                                if ($_SESSION['id'] == $_GET['Profil'])
                                    echo '<li class="btn red accent-2 waves-effect waves-light ">Changer de mot passe </li>
                                    <li class="btn blue accent-4 waves-effect waves-light">Changer de mail</li>
                                    <li class="btn purple accent-3 waves-effect waves-light">Supprimer le compte</li>
                                    <li class="btn green accent-3 waves-effect waves-light">Changer l\'image de fond</li>';
                                ?>
                                </ul>
                            </div>
							<!-- Contenu panneau Compte -->
                        </div>
                    </div>
                    <?php
                    if ($_SESSION['id'] == $_GET['Profil'])
                    echo '<a class="btn blue accent-2 hoverable waves-effect z-depth-2 modal-trigger" id="boutonDescription">Modifier la description</a>';
                    ?>
                </div>
            </div>
        </div>
        <!-- Description Utilisateur -->

    </div>
    <!--  Fin Ligne 1 -->

    <!-- Debut ligne 2-->
    <div class="row ">
        <div class="col offset-s1 TitreMessage">
            <h4>Mes postes</h4>
        </div>
        <!--Commenaires de l'utilisateurs-->
        <div class="col s10 offset-s1  z-depth-3 Postes cyan lighten-5">
        <?php
        $postes = $bdd->query(' SELECT `Contenu`,`DatePubli` FROM `publication` WHERE `Profil_ID` = "'.$_GET['Profil'].'" ORDER BY `DatePubli` ASC ');
        $PostesContenu = $postes->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($PostesContenu) != 0) {
            foreach($PostesContenu as $PosteContenu) {
                sscanf($PosteContenu['DatePubli'], "%4d-%2s-%2d", $AnneePubli, $MoisPubli, $JourPubli);
                $DatePubli = utf8_encode(strftime("%d %B %Y",strtotime($MoisPubli."/".$JourPubli."/".$AnneePubli)));
            //commentaire
            echo '<div class="row">
                <!--Auteur-->
                <div class="col s2 left-align valign-wrapper " style="height:12em;">
                    <div class="col s10 offset-s1 center-align">
                        <h5 style="padding-left:10px;margin-top:0;">'.$InfoVisite[0]['Prenom'].' '.$InfoVisite[0]['Nom'].'</h5>
                        <img src='.$InfoVisite[0]['Photo'].' class="z-depth-2 responsive-img" width="100" alt="Auteur">
                        
                    </div>
                </div>
                <!--Auteur-->
                <!--Message-->
                <div class="col s8 valign-wrapper" style="height:12em;margin-top:0.5em;">
                    <div style="width:100%" class="card-panel grey lighten-4 z-depth-2">
                        <div class="card-content messageType">
                            <span class="card-title ">'.$DatePubli.'</span>
                            <p>'.$PosteContenu['Contenu'].'</p>
                        </div>
                    </div>
                </div>
                <!--Message-->
                <!--Boutons-->
                <div class="col s1 offset-s1 valign-wrapper" style="display:flex;flex-direction:column;height:12em;padding-top:1.25em;margin-top:0.5em;">
                    <button class="btn green lighten waves-effect waves-light" style="margin-bottom:1em;">
                        <i class="material-icons">edit</i>
                    </button>
                    <button class="btn red lighten waves-effect waves-light" style="margin-bottom:1em;">
                        <i class="material-icons">delete</i>
                    </button>
                    <button class="btn blue lighten waves-effect waves-light">
                        <i class="material-icons">message</i>
                    </button>
                </div>
                <!--Boutons-->
            </div>';
            //Commenaires de l'utilisateurs
            }
        }
            ?>
        </div>
    </div>
    <!-- Debut ligne 2 -->
    <div class="row">
            <div class="col offset-s1">
                    <h4>Mes commentaires</h4>            
            </div>
            <!-- Commenaires de l'utilisateurs -->
            <div class="col s10 offset-s1 white z-depth-3 Postes light-blue lighten-4">
                <div class="row">
                <?php
                $commentaires = $bdd->query(' SELECT `CommentaireContenu`, `PublicationApp_ID`, `CommentaireDate` FROM `commentaire` WHERE `ProfilApp_ID` = "'.$_GET['Profil'].'" ORDER BY `CommentaireDate` ASC ');
                $CommentairesInfo = $commentaires->fetchAll(PDO::FETCH_ASSOC);
                foreach ($CommentairesInfo as $CommentaireInfo) {
                    $PubliComm = $bdd->query(' SELECT `DatePubli`,`Contenu`,`Profil_ID` FROM `publication` WHERE `Publication_ID` = "'.$CommentaireInfo['PublicationApp_ID'].'" ');
                    $PubliComm = $PubliComm->fetchAll(PDO::FETCH_ASSOC);
                    $CreateurPubli = $bdd->query(' SELECT `Nom`,`Prenom`, `Photo` FROM `utilisateur` WHERE `Profil_ID` = "'.$PubliComm[0]['Profil_ID'].'"  ');
                    $CreateurPubli = $CreateurPubli->fetchAll(PDO::FETCH_ASSOC);
                    sscanf($CommentaireInfo['CommentaireDate'], "%4d-%2s-%2d", $AnneeCom, $MoisCom, $JourCom);
                    $DateCom = utf8_encode(strftime("%d %B %Y",strtotime($MoisCom."/".$JourCom."/".$AnneeCom)));
                    echo '
                    <!-- Auteur -->
                    <div class="col s2 left-align valign-wrapper " style="height:12em;">
                        <div class="col s10 offset-s1 center-align">
                            <h5 style="padding-left:10px;margin-top:0;">'.$CreateurPubli[0]['Prenom'].' '.$CreateurPubli[0]['Nom'].'</h5>
                            <img src='.$CreateurPubli[0]['Photo'].' class="z-depth-2 responsive-img" width="100" alt="Auteur">
                        </div>
                    </div>
                    <!-- Auteur -->
                <!-- Message -->
                <div class="col s8 valign-wrapper"  style="height:12em;margin-top:0.5em;">
                    <div class="card-panel grey lighten-4 z-depth-2"id="messageCommentaire">
                        <div class="card-content messageType">
                            <span class="card-title ">Card Title</span>
                            <p>I am a very simple card. I</p>
                        </div>
                    </div>
                 </div>
                    <!-- Message -->
                    <!-- Boutons  -->
                    <div class="col s1 offset-s1 valign-wrapper" style="display:flex;flex-direction:column;height:12em;padding-top:1.25em;margin-top:0.5em;">
                        <button class="btn green lighten waves-effect waves-light" style="margin-bottom:1em;">
                            <i class="material-icons">edit</i>
                        </button>
                        <button class="btn red lighten waves-effect waves-light" style="margin-bottom:1em;">
                            <i class="material-icons">delete</i>
                        </button>
                        <button class="btn blue lighten waves-effect waves-light">
                            <i class="material-icons">message</i>
                        </button>
                    </div>
                    <!-- Boutons  -->
                    
                    ';
                }
                ?>
                </div>
            </div>

    <!-- Modal Description -->
    <div id="modal1" class="modal bottom-sheet">
        <div class="modal-content center-align">
            <h4>Description</h4>
            <div class="container">
                <div class="row">
                    <div class="col s8 offset-s2">
                        <!-- Formulaire -->
                        <form method="post" name = "NouvelleDescription">
                            <label for="formDescription">Saisissez votre nouvelle description</label>
                            <textarea name='formDescription' id="formDescription" class="materialize-textarea blue lighten-5" data-length="120" maxlength="120"></textarea>
                            <button name="nouvelleDescription" id="nouvelleDescription" class="modal-action modal-close waves-effect waves-green btn-flat blue lighten-4 black-text">Confirmer</button>
                        </form>
                        <!-- Formulaire -->
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- Modal Description  -->

    <!-- Modal Informations gÃ©nÃ©rales -->
    <div id="modal2" class="modal bottom-sheet">
        <div class="modal-content center-align">
            <form method="post" name = "NouvelleInfo">
                <div class="container">
                    <h4>Informations générales</h4>
                    <div class="row">
                        <!-- Formulaire -->
                        <div class="input-field col s4 offset-s4">
                            <?php
                            echo '<input name="prenom" value='.$InfoVisite[0]['Prenom'].' name="prenom" id="prenom" type="text" class="validate">
                            <label class="active" for="prenom">Prénom</label>';
                            ?>
                        </div>
                        <div class="input-field col s4 offset-s4">
                            <?php
                            echo '<input name="nom" value='.$InfoVisite[0]['Nom'].' name="nom" id="nom" type="text" class="validate">
                            <label class="active" for="nom">Nom</label>';
                            ?>
                        </div>
                        <div class="input-field col s4 offset-s4">
                            <?php
                            echo '<input type="date" name="date" value='.$info[0]['Date_Naissance'].' id="dateNaissance" type="text" class="validate">
                            <label class="active" for="dateNaissance">Date de naissance</label>';
                            ?>
                        </div>
                        <div class="input-field col s4 offset-s4">
                            <?php
                            $hobbies = " ";
                            if ($InfoVisite[0]['Hobbies'] != null)
                                $hobbies = $InfoVisite[0]['Hobbies'];
                            echo '<input name="hobbies" value="'.$hobbies.'" id="hobbie" type="text" class="validate">
                            <label class="active" for="hobbie">Hobbies</label>';
                            ?>
                        </div>
                        <!-- Formulaire -->
                    </div>
                </div>
                <button id="nouvellesInfos"  class="modal-action modal-close waves-effect waves-green btn-flat blue lighten-4 black-text">Confirmer</button>
            </form>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- Modal Infos gÃ©nÃ©rales  -->

    <!-- Modal Structure WIP  //!\\  -->
    <div id="modal3" class="modal bottom-sheet">
        <div class="modal-content">
            <h4>Modal 3</h4>
            <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>
    <!-- Modal Structure WIP  //!\\  -->

    <script src="js/pageProfil.js"></script>

</body>
</html>



<?php



?>