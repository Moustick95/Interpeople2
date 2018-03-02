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
     <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
 
     <!--Import Fonts -->
     <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 
     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 
 
     <!-- Import CSS -->
     <link rel="stylesheet" href="css/styleProfil.css">
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
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
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
            <a href="#" id="groupeButton"><i class="material-icons">group</i>Groupes</a>
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
            </ul>
        </li>
        <li>
            <div class="divider"></div>
        </li>
        <li>
            <div class="subheader center-align">Autres</div>
        </li>
        <li>
            <a href="index.php?logout=1"><i class="material-icons">exit_to_app</i>Logout</a>
        </li>
    </ul>
    <!-- Navbar -->

    <!-- Bouton Navbar -->
    <div  id="btnSide">
        <a data-activates="slide-out" class="btn btn-large blue darken-3 white-text waves-effect button-collapse" ><i class="material-icons" >chevron_right</i></a>
    </div>
    <!-- Bouton Navbar -->
                     
    <!-- Composant de la page -->
    <!-- ------------------------- -->

     <!-- Début Header -->
    <nav>
        <div class="nav-wrapper indigo lighten-2" id="navTop">
            <a href="PageProfil.php" class="brand-logo center" id="titreNav">Profil</a>
        </div>
    </nav>
     <!-- Fin Header -->              

    <!--  Ligne 1 -->
    <div class="row">
        <div class="col s12">
            <?php
                echo '<h4 class="center-align">'.$InfoVisite[0]['Prenom']." ".$InfoVisite[0]['Nom'].'</h4>';
            ?>
        </div>

        <!-- Image Profil -->
        <div class="col s3 offset-s1 ">     
            <div class="card-panel white z-depth-3 center-align hauteur"  >
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
        <div class="col s12 m7">
                            <div class="card horizontal z-depth-3">
                              <div class="card-stacked">
                                <div class="card-content">
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
                                              <div class="card-content grey lighten-4">
                                              <?php
                                              if ($InfoVisite[0]['Description'] != null)
                                                echo '<div id="test4">'.$InfoVisite[0]['Description'].'</div>';
                                                ?>
                                                <div id="test5">
                                                    <ul class="">
                                                    <?php
                                                    if ($InfoVisite[0]['Date_Naissance'] != null) {
                                                        date_default_timezone_set('Europe/Paris');
                                                        sscanf($InfoVisite[0]['Date_Naissance'], "%4d-%2s-%2d", $annee, $mois, $jour);
                                                        setlocale(LC_TIME, 'fr');
                                                        $date = utf8_encode(strftime("%d %B %Y",strtotime($mois."/".$jour."/".$annee)));
                                                        echo '<li >Date de naissance  : '.$date.'</li>';
                                                    }
                                                    if ($InfoVisite[0]['Hobbies'] != null)
                                                        echo '<li >Hobbies : '.$InfoVisite[0]['Hobbies'].'</li>' ;
                                                    ?>
                                                    </ul>

                                                </div>
                                                <div id="test6">
                                                    <ul class="">
                                                    <?php
                                                    if ($_SESSION['id'] == $_GET['Profil'])
                                                        echo '<li class="btn red">Changer de mot passe  </li>';
                                                    ?>
                                                    </ul>

                                                </div>
                                              </div>
                                </div>
                                <?php
                                if ($_SESSION['id'] == $_GET['Profil'])
                                echo '<div class="card-action">                                
                                      <button class="btn blue waves-effect z-depth-2">Modifier le texte</button>
                                      </div>';
                                ?>
                              </div>
                            </div>
                          </div>
        <!-- Description Utilisateur -->

    </div>
    <!--  Fin Ligne 1 -->


    <!--  Ligne 2 -->
    <div class="row">
        <div class="col offset-s1">
            <h4>Mes postes</h4>            
        </div>
        <!-- Postes Utilisateurs -->
        <div class="col s10 offset-s1 white z-depth-3 Postes">
                
                <div>
                    <?php
                    $postes = $bdd->query(' SELECT `Contenu`,`DatePubli` FROM `publication` WHERE `Profil_ID` = "'.$_GET['Profil'].'" ORDER BY `DatePubli` ASC ');
                    $PostesContenu = $postes->fetchAll(PDO::FETCH_ASSOC);
                    if (sizeof($PostesContenu) != 0) {
                        foreach($PostesContenu as $PosteContenu) {
                            echo '<div class="card-panel grey z-depth-2">
                                  <div class="card-content white-text">
                                    <span class="card-title ">'.$InfoVisite[0]['Prenom'].' '.$InfoVisite[0]['Nom'].'</span>
                                        <p>'.$PosteContenu['Contenu'].'</p>';
                                        if ($_SESSION['id'] == $_GET['Profil'])
                                        echo '<button class="btn green waves-effect waves-light" >Editer</button>                    
                                              <button class="btn red waves-effect waves-light" >Supprimer</button>';
                                   echo '</div>
                            </div>';
                        }
                    }
                    ?>
                </div>
        </div>
        <!-- Postes Utilisateurs -->
        
    </div>
    <!-- Fin Ligne 2 -->

    <div class="row">
            <div class="col offset-s1">
                    <h4>Mes commentaires</h4>            
            </div>
            <div class="col s10 offset-s1 white z-depth-3 Postes">
                        <?php
                        $commentaires = $bdd->query(' SELECT `CommentaireContenu`, `PublicationApp_ID` FROM `commentaire` WHERE `ProfilApp_ID` = "'.$_GET['Profil'].'" ORDER BY `CommentaireDate` ASC ');
                        $CommentairesInfo = $commentaires->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($CommentairesInfo as $CommentaireInfo) {
                            $PubliComm = $bdd->query(' SELECT `DatePubli`,`Contenu`,`Profil_ID` FROM `publication` WHERE `Publication_ID` = "'.$CommentaireInfo['PublicationApp_ID'].'" ');
                            $PubliComm = $PubliComm->fetchAll(PDO::FETCH_ASSOC);
                            $CreateurPubli = $bdd->query(' SELECT `Nom`,`Prenom` FROM `utilisateur` WHERE `Profil_ID` = "'.$PubliComm[0]['Profil_ID'].'"  ');
                            $CreateurPubli = $CreateurPubli->fetchAll(PDO::FETCH_ASSOC);
                            echo '<div class="card-panel grey z-depth-2">
                                    <div class="card-content white-text">
                                        <span class="card-title ">'.$CreateurPubli[0]['Prenom'].' '.$CreateurPubli[0]['Nom'].'</span>';
                                echo    '<p>'.$PubliComm[0]['Contenu'].'</p>
                                         <p>'.$CommentaireInfo['CommentaireContenu'].'</p>';
                                         if ($_SESSION['id'] == $_GET['Profil'])
                                            echo   '<button class="btn green waves-effect waves-light" >Editer</button>                       
                                                    <button class="btn red waves-effect waves-light" >Supprimer</button>
                                    </div>
                            </div>';
                        }
                        ?>
                            
                    </div>
    </div>

    <script src="js/pageProfil.js"></script>

</body>
</html>