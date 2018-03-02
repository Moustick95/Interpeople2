<?php
session_start();

if (ISSET($_POST['connection']) && ISSET($_POST['mailCo']) && ISSET($_POST['mdpCo'])) {

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', 'root');
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $mail = $_POST['mailCo'];
    $mdp = $_POST['mdpCo'];


    $verif = $bdd->query('SELECT `MDP`, `Profil_ID` FROM `utilisateur` WHERE `Email` = "'.$mail.'" ');
    $donnees = $verif->fetch();
    $verifMdp = password_verify($mdp,  $donnees['MDP']);

    if ($verifMdp) {
        $_SESSION['id'] = $donnees['Profil_ID'];
        header('Location: PageProfil.php?Profil='.$_SESSION['id'].'');
        exit;
    }
    else {
        $failure = '<script language="Javascript">alert("Mauvais mot de passe ou mauvais mail")</script>';
    }
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
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <!--Import Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet"> 

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
            else
                alert("Votre compte a bien été créé");
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
    <script src="js/PageInscription.js"></script>

    <div class=" row " >
        <!-- Début de la ligne 1 -->
        <div class="col s12" id="ligne1">

             <!-- Formulaire d'inscription -->
            <div class="col offset-s5 s4  offset-l4 l4 white z-depth-3 blue" id="formulaire">
                    <h3 id="InscriptionTitre center-align" >Inscrivez-vous</h3>

                <!-- A RECUPERER (et vérifier les input sur les id et nom)-->
                <form name="inscription" method="post" action="index.php" onsubmit="return validateForm()">
                <!-- FIN RECUPERATION -->
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
                    <div class="center-align" id="boutonInscription">
                        <input type="submit" class="btn waves-effect waves-light indigo lighten" name="inscription" value="Inscription"> 
                    </div>
                </form>
            </div>
            <!-- Formulaire d'inscription -->

            <!-- Bouton de connexion -->
            <div class="col  offset-s3 offset-l3" id="BoutonLogIn">
                <a class="btn btn-large indigo lighten-1  waves-effect waves-light modal-trigger " href="#modal1">Connexion</a>
            </div>
            <!-- Bouton de connexion -->

            <!-- Structure de  la boite Modal -->
            <div id="modal1" class="modal">
                <form class="center-align" method="post" action="index.php">
                    <div class="modal-content center-align">
                        <h4>Connexion à InterPeople</h4>
                            
                                <div class="input-field ">
                                    <input type="email" name="mailCo" id="emailCo" class="validate" required>
                                    <label class="active" for="email">Email</label>
                                </div>
                                <div class="input-field">
                                    <input type="password" name="mdpCo" id="motDePasse" required>
                                    <label class="active" for="motDePasse">Mot de passe</label>
                                </div>
                            
                        <p>Bienvenue cher utilisateur</p>
                    </div>
                    <div class="modal-footer">
                        <input type="Submit" name="connection" class=" green white-text waves-effect waves-green btn-flat">
                    </div>
                </div>
            </form>
        </div>

        <!-- Fin de la ligne1 -->
        
        <!-- Début de la ligne 2 -->
         <div class="col s12 z-depth-5" id="ligne2">
             <!-- Colonne de gauche -->
                <div class="col s2 xl2  z-depth-5 left-align" id="colonne1">
                        <h5>InterPeople, c'est :</h5><br />
                        <p>Plus de 5000 connexions par jour</p><br />
                        <p>Des rencontres possibles chaque jour</p><br />
                        <p>Notre site est disponible dans plus de 70 pays</p><br />
                        <p>Une plateforme sans limite</p><br />
                </div>
        
                <!-- Logo et titre centré -->
                <div class="col s6 offset-s1 center-align" id="TitreLogo">
                        <h1>InterPeople</h1>
                        <p id="sousTitre">Connect people, open your mind</p>
                </div>

                <!-- Colonne de droite -->
                <div class="col s2 offset-s1 z-depth-5 left-align "id="colonne2">
                        <h5>Fonctionnaliés : </h5><br />
                        <p>Une liste d'amis facile à gérer</p><br />
                        <p>Partager les postes de votre mur avec vos amis</p><br />
                        <p>Gérer des groupes</p><br />
                        <p>Chatter directement avec vos amis en LIVE !</p><br />
                </div>
             </div>
           <!-- Fin  de la ligne -->
     </div>
     <!-- Fin de Row -->
    </body>
</html>




<!-- A RECUPERER -->




<?php
if (ISSET($_POST['inscription']) && ISSET($_POST['mdp']) && ISSET($_POST['nom']) && ISSET($_POST['prenom']) && ISSET($_POST['mail'])) {
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', 'root');
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    echo '<script language="Javascript">alert(document.getElementById("motDePasse").value;)</script>';
    //Inscription:
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    $mail = $_POST['mail'];

    $verif = $bdd->query(' SELECT `Email` FROM `utilisateur` WHERE `Email` = "'.$mail.'" ');
    //$verif->execute();
    $donnees = $verif->fetch();
    if ($mail != $donnees['Email'] && $mail  != null) {
        $reponse = $bdd->query(' INSERT INTO `utilisateur`(`Profil_ID`, `Nom`, `Prenom`, `Email`, `MDP`, `Photo`, `Photo_Fond`) VALUES (null, "'. $nom .'" , "'. $prenom .'" , "'. $mail .'" , "'. $mdp .'" , "image/index.png"), "image/FondProfil.jpg" ');
    }
    else {
        echo '<script language="Javascript">alert("Adresse mail déjà utilisé")</script>';
    }
}

if (isset($failure)) {
    echo $failure;
}

if ($_GET['logout']==1) {
    unset($_SESSION['id']);
    echo '<script language="Javascript">alert("Vous êtes bien déconnecté")</script>';
}

?>
