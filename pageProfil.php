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


    <title>Profil/Interpeople</title>
</head>

<style>
html,body
{
    margin: 0;
    width: 100vw;
    height: 100vh;
}

.loader
{
    position: absolute;
    top: 50vh;
    right: 50vw;
}

  #fondNav {
	max-width:100%;
  -webkit-filter: brightness(10%); /* Safari */
    filter: brightness(10%);
    -webkit-filter: opacity(60%); /* Safari */
    filter: opacity(60%);
    -webkit-filter: contrast(60%); /* Safari 6.0 - 9.0 */
    filter: contrast(60%);
}

.user-view
{
  margin: 0 !important;
}

#navProfil span
{
  width: 100%;
  display: inline-block;
}

#navProfil
{
  display: flex;
  flex-wrap: wrap;
justify-content: flex-start;
align-content: center;
align-items: center;
font-family: 'Roboto',sans-serif;
}

#name
{
  font-size: 2.0em;
}

#email
{
  font-size: 1.10em;
}
#navTexte
{
  width: 65%;
  margin-left: 15px;
}

#navTexte p
{
  margin: 0;
}

#groupeListe > li , #groupeListe > li > a
{
    padding: 0px 0px !important;
    margin: 0px 0px !important;
    border-bottom: none !important;
}

#slide-out
{
    overflow-y: scroll;
}

#titreNav
{
    font-family: 'Oswald';
    font-size: 2.5em;
    
}
    
</style>
<body>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="js/pageProfil.js"></script>
    <!--Import jQuery before materialize.js-->

    <script type="text/Javascript">
        $(window).load(function() {
                    // Animate loader off screen
                    $(".loader").fadeOut("slow");
                    });
    </script>

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
            <li><div class="user-view">
                <div class="background">
                <?php
                if($info[0]['Photo_Fond'] == null)
                    echo '<img id="fondNav" src="image/FondProfil.jpg">';
                else
                    echo '<img id="fondNav" src='.$info[0]['Photo_Fond'].'>';
                ?>
                </div>
                <div id="navProfil">
                <?php
                if ($info[0]['Photo'] == null)
                    echo '<a href="?Profil='.$_SESSION['id'].'"><img class="circle" src="image/index.png"></a>';
                else
                    echo '<a href="?Profil='.$_SESSION['id'].'"><img class="circle" src='.$info[0]['Photo'].'></a>';
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
                     <!-- Navbar -->

                     <!-- Structure bouton -->
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
          <div class="fixed-action-btn">
          <a href="" data-activates="slide-out" class="btn btn-large red darken-3 white-text waves-effect" id="btnSide"><i class="material-icons" >chevron_right</i></a>
            </div>
                     
                     <!-- Structure bouton -->

          <nav>
                <div class="nav-wrapper" id="navTop">
                  <a href="PageProfil.php" class="brand-logo center" id="titreNav">Profil</a>
                </div>
              </nav>
              
          <!--  
              <div class="row">
            <div class="s6">
                <img class="materialboxed" width="650" src="images/sample-1.jpg">
            </div>
        </div>
    </div>
                                <div id="imageProfil">
                                    -->

          
  

          <script type="text/Javascript">
        $(document).ready(function(){
          // Init Sidenav
        $('#btnSide').sideNav();

          $('#groupeListe').hide();
          
        });
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

        </script>

</body>
</html>