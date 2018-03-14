<!DOCTYPE html>
<html lang="fr">

<!-- Navbar -->
<ul id="slide-out" class="side-nav grey lighten-4">
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
            echo '<a href="PageAmis.php"><i class="material-icons blue-text" >contacts</i>Amis</a>';
        ?>
        </li>
		<li>
                <a href="pageMur.html" >
                    <i class="material-icons red-text" >public</i>Accueil</a>
            </li>
        <li>
            <a href="#" id="groupeButton">
				<i class="material-icons green-text">group</i>Groupes</a>
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
                <i class="material-icons orange-text">exit_to_app</i>Logout</a>
        </li>
    </ul>
    <!-- Navbar -->

    <!-- Bouton Navbar -->
    <div id="btnSide">
        <a data-activates="slide-out" class="btn btn-large blue darken-3 white-text waves-effect button-collapse" >
			<i class="material-icons" >chevron_right</i>
		</a>
    </div>
    <!-- Bouton Navbar -->

</html>