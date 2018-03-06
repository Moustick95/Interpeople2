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
$InfoGeneral = $bdd->query('SELECT `Nom`,`Prenom`,`Email`, `Photo`, `Photo_Fond` FROM `utilisateur` WHERE `Profil_ID` = "'.$id.'"  ');
$info = $InfoGeneral->fetchAll(PDO::FETCH_ASSOC);
$profile = $_SESSION['id'];

if (ISSET($_GET['Profil'])) {
    $ProfileVisite = $bdd->query('SELECT * FROM `utilisateur` WHERE `Profil_ID` = "'.$_GET['Profil'].'" ');
    $InfoVisite = $ProfileVisite->fetchAll(PDO::FETCH_ASSOC);
    $profile = $_GET['Profil'];
    if (sizeof($InfoVisite) == 0)
        header('location:?Profil='.$_SESSION['id']);
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


    <!-- Navbar -->
    <ul id="slide-out" class="side-nav">
        <li>
            <div class="user-view">
                <div class="background">
                <?php
                    echo '<img id="fondNav" src='.$info[0]['Photo_Fond'].'>';
                ?>
                </div>
                <div id="navProfil">
                <?php
                $pp = $info[0]['Photo'];
                echo '<a href="?Profil='.$_SESSION['id'].'"><img class="circle" src='.$pp.'></a>';
                ?>
                    <div id="navTexte">
                    <?php
                    echo '<span class="white-text name" id="name"><p>'.$info[0]['Prenom'].' '.$info[0]['Nom'].'</p></span>';
                    echo '<span class="white-text email" id="email"><p>'.$info[0]['Email'].'</p></span>';
                    ?>
                    <br>
                    </div>
                </div>
            </div>
        </li>
        <li>
            <div class="subheader center-align">Gestion de votre profil</div>
        </li>
        <li>
        <?php
            echo '<a href="?Profil='.$_SESSION['id'].'"><i class="material-icons">account_circle</i> Profil</a>';
        ?>
        </li>
        <li>
            <div class="divider"></div>
        </li>
        <li>
            <div class="subheader center-align">Vos relations</div>
        </li>
        <li>
        <?php
            echo '<a href="PageAmis.php"><i class="material-icons">contacts</i>Amis</a>';
        ?>
        </li>
		<li>
                <a href="pageAmis.html" >
                    <i class="material-icons red-text" >public</i>Accueil</a>
            </li>
        <li>
            <a href="#" id="groupeButton">
				<i class="material-icons">group</i>Groupes</a>
        </li>
        <li>
           <ul class="collection" id="groupeListe">
                <!-- Affichage des groupes qu'on appartient -->
                <?php
                $qry = $bdd->query('SELECT `Groupe_Nom`, `Groupe_ID` FROM `groupe` WHERE `PROFIL_ID` = "'. $id .'" ');
                $groups = $qry->fetchAll(PDO::FETCH_ASSOC);
                foreach ($groups as $group) {
                    echo '<li class="collection-item"><a class="black-text" href="?Groupe='.$group['Groupe_ID'].'">'.$group['Groupe_Nom'].'</a></li>';
                }
                
                ?>
				<li class="collection-item">
				                    <a class="black-text" href="#!">
				                        <i class="material-icons">add_circle</i>
				                    </a>
				                </li>
            </ul>
        </li>
        <li>
            <div class="divider"></div>
        </li>
        <li>
            <div class="subheader center-align">Autres</div>
        </li>
        <li>
            <a href="index.php?logout=1">
				<i class="material-icons">exit_to_app</i>Logout</a>
        </li>
    </ul>
    <!-- Navbar -->

    <!-- Bouton Navbar -->
    <div  id="btnSide">
        <a data-activates="slide-out" class="btn btn-large blue darken-3 white-text waves-effect button-collapse" >
			<i class="material-icons" >chevron_right</i>
		</a>
    </div>
    <!-- Bouton Navbar -->
                     
    <!-- Composant de la page -->
    <!-- ------------------------- -->

     <!-- Début Header -->
    <nav>
        <div class="nav-wrapper blue lighten-2" id="navTop">
            <a href="PageProfil.php" class="brand-logo center" id="titreNav">Interpeople</a>
        </div>
    </nav>
     <!-- Fin Header -->              
    <!-- Petite ligne -->
    <div class="col s12  blue lighten" style="height:3px;">
    </div>
    <!-- Petite ligne -->

    <!--  Ligne 1 -->
    <div class="row">
        <div class="col s12">
            <?php
                echo '<h4 class="center-align">'.$InfoVisite[0]['Prenom']." ".$InfoVisite[0]['Nom'].'</h4>';
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
                    echo '<a class="btn-floating orange btn-large z-depth-2"><i class="large material-icons ">mode_edit</i></a>';
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
                            <li class="tab"><a href="#test4">Description</a></li>
                            <li class="tab"><a class="active" href="#test5">Informations générales</a></li>
                            <?php
                            if ($_SESSION['id'] == $_GET['Profil'])
                                echo '<li class="tab"><a href="#test6">Compte</a></li>';
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
                                <ul class="">
                                <?php
                                if ($_SESSION['id'] == $_GET['Profil'])
                                    echo '<li class="btn red">Changer de mot passe  </li>';
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
                    <div class="card-panel grey lighten-4 z-depth-2">
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
                    <div class="col s8 valign-wrapper" style="height:12em;margin-top:0.5em;">
                        <div class="card-panel grey lighten-4 z-depth-2">
                            <div class="card-content messageType">
                                <span class="card-title ">'.$DateCom.'</span>
                                <p>'.$CommentaireInfo['CommentaireContenu'].'</p>
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
                        <form action="">
                            <label for="textarea1">Saisissez votre nouvelle description</label>
                            <textarea id="textarea1" class="materialize-textarea blue lighten-5" data-length="120" maxlength="120"></textarea>
                        </form>
                        <!-- Formulaire -->
                        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat blue lighten-4 black-text">Confirmer</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- Modal Description  -->

    <!-- Modal Structure -->
    <div id="modal2" class="modal bottom-sheet">
        <div class="modal-content center-align">
            <div class="container">
                <h4>Informations générales</h4>
                <div class="row">
                    <!-- Formulaire -->
                    <div class="input-field col s4 offset-s4">
                        <input value="John" id="prenom" type="text" class="validate">
                        <label class="active" for="prenom">Prénom</label>
                    </div>
                    <div class="input-field col s4 offset-s4">
                        <input value="Doe" id="nom" type="text" class="validate">
                        <label class="active" for="nom">Nom</label>
                    </div>
                    <div class="input-field col s4 offset-s4">
                        <input value="01/02/1995" id="dateNaissance" type="text" class="validate">
                        <label class="active" for="dateNaissance">Date de naissance</label>
                    </div>
                    <div class="input-field col s4 offset-s4">
                        <input value="Musique" id="hobbie" type="text" class="validate">
                        <label class="active" for="hobbie">Hobbies</label>
                    </div>
                    <!-- Formulaire -->
                </div>
            </div>
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat blue lighten-4 black-text">Confirmer</a>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    <!-- Modal Structure  -->

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