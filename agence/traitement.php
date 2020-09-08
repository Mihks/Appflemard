<?php

session_name('flemadmin');

session_start();

include_once 'fonction.php';
 

?>
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php


function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

$_REQUEST['agence'] = filtre($_REQUEST['agence']);

$_REQUEST['login'] = filtre($_REQUEST['login']); // identifiant de l'user

$_REQUEST['mdp'] = filtre($_REQUEST['mdp']); // Mot De Passe

$_REQUEST['region'] = filtre($_REQUEST['region']);

$_REQUEST['membre'] = filtre($_REQUEST['membre']);



$_REQUEST['region'] = ($_REQUEST['membre']=='administrateur') ? 'administrateur' : $_REQUEST['region'] ;



if (isset($_REQUEST['agence']) && !empty($_REQUEST['agence']) 

	&& preg_match("#^major$|^hitu$|^akewa$|^transporteur$#",$_REQUEST['agence']) 

	&& isset($_REQUEST['region']) && !empty($_REQUEST['region']) 

	&& preg_match('#^administrateur$|^Libreville$|^Oyem$|^Bitam$|^Mouila$|^Fougamou$|^Port-gentil$#', $_REQUEST['region'])

	&& isset($_REQUEST['membre']) && !empty($_REQUEST['membre']) && preg_match("#^administrateur$|^gerant$#", $_REQUEST['membre'])

	&& isset($_REQUEST['login']) && !empty($_REQUEST['login'] && strlen($_REQUEST['login'])<= 10 )

	&& isset($_REQUEST['mdp']) && !empty($_REQUEST['mdp']) && strlen($_REQUEST['mdp'])<= 30 && strlen($_REQUEST['mdp']) >= 4 ) {





		$reponse = $bdd->prepare(" SELECT `type_agence` FROM `agence` WHERE nom_agence = ? ");

		$reponse->execute(array($_REQUEST['agence']));

		$donnees = $reponse->fetch();

		$type_agence = $donnees['type_agence'];
		
		$reponse->closeCursor();


	if ($_REQUEST['membre']=='administrateur') {
		
		$reponse = $bdd->prepare(" SELECT `login_admin_general`, `mdp_admin_general` FROM `agence` WHERE nom_agence = ? ");

		$reponse->execute(array($_REQUEST['agence']));

		$donnees = $reponse->fetch();

		$logBdd = $donnees['login_admin_general'];
		
		$mdpBdd = $donnees['mdp_admin_general'];

		$reponse->closeCursor();
	
		$_SESSION['logo_agence'] = 'images/ga.png';
		

	}elseif($_REQUEST['membre']=='gerant'){


		$reponse = $bdd->prepare(" SELECT `login`, `mdp`, `logo_agence`, `region` FROM `users` WHERE nom_agence = ? AND region = ?  ");

		$reponse->execute(array($_REQUEST['agence'],$_REQUEST['region']));
			
		
		$donnees = $reponse->fetch();

		$logBdd = $donnees['login'];
		$mdpBdd = $donnees['mdp'];
		
		$_SESSION['logo_agence'] = $donnees['logo_agence'];
		
		$_REQUEST['region'] = $donnees['region'];

				
		$reponse->closeCursor();
			
		
	}
	


	if ( $_REQUEST['login'] == $logBdd && sha1($_REQUEST['mdp']) == $mdpBdd ) {
					
		
		$_SESSION['agence'] = $_REQUEST['agence'];

		$_SESSION['login'] = $_REQUEST['login']; // identifiant de l'user

		$_SESSION['mdp'] = $_REQUEST['mdp']; // Mot De Passe
	
		$_SESSION['region'] = $_REQUEST['region'];

		$_SESSION['membre'] = $_REQUEST['membre'];

		$_SESSION['type_agence'] = $type_agence;

		header("Location:home.php");
				
	}else{
				
		header("Location:connexion.php");

	}


}else
	header("Location:connexion.php");
