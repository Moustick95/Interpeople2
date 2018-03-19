<?php
session_start();

try {
    $bdd = new PDO('mysql:host=localhost;dbname=team2;charset=utf8', 'team2', 'TwoFace');
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

if ( ISSET($_POST['mailCo']) && ISSET($_POST['mdpCo'])) {

    $mail = $_POST['mailCo'];
    $mdp = $_POST['mdpCo'];


    $verif = $bdd->query('SELECT `MDP`, `Profil_ID` FROM `utilisateur` WHERE `Email` = "'.$mail.'" ');
    $donnees = $verif->fetch();
    $verifMdp = password_verify($mdp,  $donnees['MDP']);

    if ($verifMdp) {
        $_SESSION['id'] = $donnees['Profil_ID'];
        header('Location: PageMur.php');
        exit;
    }
    else {
        $failure = '<script language="Javascript">alert("Mauvais mot de passe ou mauvais mail")</script>';
        header("location: index.php");
    }
}

if (ISSET($_GET['logout']) && ISSET($_SESSION['id'])) {
    echo '<script language="Javascript">alert("Vous êtes bien déconnecté")</script>';
    $bdd->query('UPDATE `utilisateur` SET `Status` = "Déconnecté" WHERE `Profil_ID` = "'.$_SESSION['id'].'" ');
    session_unset();
    session_destroy();
}

if (ISSET($_POST['mdp']) && ISSET($_POST['nom']) && ISSET($_POST['prenom']) && ISSET($_POST['mail'])) {
    //Inscription:
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $mail = $_POST['mail'];

    $verif = $bdd->query(' SELECT `Email` FROM `utilisateur` WHERE `Email` = "'.$mail.'" ');
    $donnees = $verif->fetch();
    if ($mail != $donnees['Email'] && $mail  != null) {
        $reponse = $bdd->query(' INSERT INTO `utilisateur`(`Profil_ID`, `Nom`, `Prenom`, `Email`, `MDP`, `Photo`, `Photo_Fond`) VALUES (null, "'. $nom .'" , "'. $prenom .'" , "'. $mail .'" , "'. $mdp .'" , "image/index.png", "image/FondProfil.jpg" )');
        $verif = $bdd->query('SELECT `Profil_ID` FROM `utilisateur` WHERE `Email` = "'.$mail.'" ');
        $donnees = $verif->fetch();
        $_SESSION['id'] = $donnees['Profil_ID'];
        header('location:PageProfil?Profil='.$_SESSION['id'].'.php');
    }
    else {
        echo '<script language="Javascript">alert("Adresse mail déjà utilisé")</script>';
        header("location: index.php");
    }
}

if (isset($failure)) {
    echo $failure;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta nom="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">     

    <!-- Import CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>Interpeople Material</title>

    <!-- A RECUPERER -->

    <script>
        function validateForm() {
            var x = document.forms["inscription"]["mdp"].value;
            var y = document.forms["inscription"]["mdp2"].value;
            if (x != y) {
                alert("Vos mots de passes sont différents");
                return false;
            }
        }
    </script>

    <!-- FIN RECUPERATION -->

</head>

<body>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <!--Import jQuery before materialize.js-->

    <!-- import JS -->

    <div class="row" id="ligne1">

        <!-- Colonne de gauche -->
        <div class="col s6 xl2  z-depth-5 left-align" id="colonne1">
            <h5>InterPeople, c'est :</h5>
            <br />
            <p>Plus de 5000 connexions par jour</p>
            <br />
            <p>Des rencontres possibles chaque jour</p>
            <br />
            <p>Notre site est disponible dans plus de 70 pays</p>
            <br />
            <p>Une plateforme sans limite</p>
            <br />
        </div>

        <!-- Logo et titre centré -->
        <div class="col s12 xl8 center-align" id="TitreLogo">
            <h1>InterPeople</h1>
            <img src="image/LogoInterpeople.png" class="z-depth-5" alt="">
        </div>

        <!-- Colonne de droite -->
        <div class="col s6 xl2 z-depth-5 left-align " id="colonne2">
            <h5>Fonctionnalités : </h5>
            <br />
            <p>Une liste d'amis facile à gérer</p>
            <br />
            <p>Partager les postes de votre mur avec vos amis</p>
            <br />
            <p>Gérer des groupes</p>
            <br />
            <p>Chatter directement avec vos amis en LIVE !</p>
            <br />
        </div>
    </div>

    <!-- Bouton de connexion -->
    <div id="ensembleBouton">
        <div  id="BoutonLogIn">
            <a class=" z-depth-3 btn btn-large indigo lighten  waves-effect waves-light modal-trigger " id="connexion" href="#modal1">Connexion</a>
        </div>
        <div id="boutonConnexion">
            <a class=" z-depth-3 btn btn-large indigo lighten  waves-effect waves-light modal-trigger " id="inscription" href="#modal2">Inscription</a>
        </div>
    </div>
    <!-- Bouton de connexion -->

    <!-- Structure de  la boite Modal -->
    <div id="modal1" class="modal">
        <div class="modal-content center-align">
            <div class="col s12 right-align">
                <button class="btn red" id="modal1Fermer">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <h4>Connexion à InterPeople</h4>
            <p>Bienvenue cher utilisateur</p>
            <form class="center-align" name="connexion" method="post" action="index.php">
                <div class="input-field ">
                    <input type="email" name="mailCo" id="email2" class="validate" required>
                    <label class="active" for="email2">Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="mdpCo" id="motDePasse2" required>
                    <label class="active" for="motDePasse2">Mot de passe</label>
                </div>
            <div class="col s12">
                <button type="submit" class=" green white-text modal-action modal-close waves-effect waves-green btn-flat">Valider</a>
            </div>
            </form>
            <div class="col s12" style="margin-top:5px;">
                <a href="motDePasse.php" class=" cyan accent-3 white-text modal-action modal-close waves-effect btn-flat">Mot de passe oublié ?</a>
            </div>
        </div>
    </div>

    <!-- Structure de  la boite Modal -->
    <div id="modal2" class="modal">
        <div class="modal-content center-align">
            <div class="col s12 right-align">
                <button class="btn red" id="modal2Fermer">
                    <i class="material-icons">close</i>
                </button>
            </div>
            <h4>Inscription à InterPeople</h4>
                <form class="col s12" name="inscription" method="post" action="index.php" onsubmit="return validateForm()">
                <div class="row">
                </div>
                <div class="input-field">
                <input type="text" id="nom" name="nom" required>
                    <label class="active" for="nom">Nom</label>
                </div>
                <div class="input-field">
                <input type="text" id="prenom" name="prenom" required>
                        <label class="active" for="prenom">Prénom</label>
                </div>
                <div class="input-field">
                    <input type="email" id="email" name="mail" class="validate" required>
                    <label class="active" for="email" data-error="Votre mail doit être de forme exemple@domaine.fr" data-success="OK">Email</label>
                </div>
                <div class="input-field">
                    <input type="password" id="mdp" name="mdp" required>
                    <label class="active" for="motDePasse">Mot de passe</label>
                </div>
                <div class="input-field">
                    <input type="password" id="motDePasseC" name="mdp2" required>
                    <label class="active" for="motDePasseC">Confirmer mot de passe</label>
                </div>
                <div class="input-field center-align" id="validationInscription">
                    <button class="btn green waves-effect waves-light" type="submit" name="action">S'inscrire
                        <i class="material-icons right">check</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>


    <footer class="page-footer z-depth-2">
        <div class="container">
            <div class="row" id="ligneFooter">
                <div class="col l8 s12">
                    <h5 class="black-text">Blop Team</h5>
                    <p class="black-text " id="texteFooter">
                        Nous sommes pour l'instant une équipe réduite de 2 personnes qui veulent accomplir de grandes idées. Nous mettons à profit
                        notre passion pour un web plus éthique et respecteux envers les utilisateurs.
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-copyright z-depth-1">
            <div class="container black-text">
                © 2018 Copyright Tanguy Legendre & Flavien Lair
                <a class="black-text right" href="#!">Contacts</a>
            </div>
        </div>
    </footer>
    <!-- Fin de la ligne1 -->

    <script src="js/PageInscription.js"></script>

</body>


</html>




<!-- A RECUPERER -->