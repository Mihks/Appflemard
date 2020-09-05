<?php

session_name('flemadmin');

session_start();

	include_once 'fonction.php';


if (isset($_SESSION['agence']) && isset($_POST['ancien_mdp']) && isset($_POST['nouveau_mdp']) && isset($_POST['confirm_mdp']) ) {
	



function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

$ancien_mdp = filtre($_POST['ancien_mdp']);

$nouveau_mdp = filtre($_POST['nouveau_mdp']);

$confirm_mdp = filtre($_POST['confirm_mdp']);


if ($_SESSION['membre']=="administrateur") {


	$reponse = $bdd->prepare("SELECT `mdp_admin_general` AS mdp FROM `agence` WHERE nom_agence = ? ");

	$reponse->execute(array($_SESSION['agence']));


	$donnee = $reponse->fetch();
	

} else {
	
	$reponse = $bdd->prepare("SELECT `mdp` FROM `users` WHERE nom_agence = ? AND region = ? ");

	$reponse->execute(array($_SESSION['agence'],$_SESSION['region']));


	$donnee = $reponse->fetch();
}





if (sha1($ancien_mdp) == $donnee['mdp'] ) {
	
	if (isset($nouveau_mdp) && !empty($nouveau_mdp) && strlen($nouveau_mdp) <= 30 && strlen($nouveau_mdp) >= 4 && $nouveau_mdp == $confirm_mdp ) {


		if ($nouveau_mdp == $ancien_mdp && $nouveau_mdp == $confirm_mdp) {


			echo "Aucun changement a été effectué !";
			

		}else{
		
			if ($_SESSION['membre']=='administrateur') {
				# code...
				
				$nouveau_mdp = sha1($nouveau_mdp);

				$reponse = $bdd->prepare(" UPDATE `agence`  SET `mdp_admin_general` = ? WHERE nom_agence = ? ");

				$reponse->execute(array($nouveau_mdp,$_SESSION['agence']));

			} else {
				# code...
						
				$nouveau_mdp = sha1($nouveau_mdp);

				$reponse = $bdd->prepare(" UPDATE `users`  SET `mdp` = ? WHERE nom_agence = ? AND region = ? ");

				$reponse->execute(array($nouveau_mdp,$_SESSION['agence'],$_SESSION['region']));


				}


			echo "Opération effectuée...!";

		}

	}else{

		echo "Le nouveau mot de passe et la confirmation du mot de passe doivent être identiques et comporter au moins 4 caractères ,veuillez recommencer !";
	}


}else{

	echo "Le mot de passe saisie est incorrect !";

}


}else{

	echo "Veuillez vous reconnecter...";
}