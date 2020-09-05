<?php

session_name('flemadmin');

session_start();


if ( isset($_SESSION['agence']) && isset($_POST['nouveau_trajet_tarif']) && isset($_POST['nom_trajet_tarif'])) {
	
include_once 'fonction.php';



function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}


$nouveau_trajet_tarif = intval($_POST['nouveau_trajet_tarif']); 
$nom_trajet_tarif = $_POST['nom_trajet_tarif'];


if (preg_match('#major|hitu|transporteur#', $_SESSION['agence'])) {



	$requete = $bdd->prepare(' SELECT prix_trajet FROM trajets WHERE nom_agence = ? AND nom_trajet = ? '); 

	$requete->execute(array($_SESSION['agence'],$nom_trajet_tarif));

	$donnee = $requete->fetch();

	$prix_trajet_bdd = $donnee["prix_trajet"];

	$requete->closeCursor();



	if ($nouveau_trajet_tarif < 200000 && $nouveau_trajet_tarif >= 10000 && !is_null($prix_trajet_bdd) ) {
		


	if ($nouveau_trajet_tarif <= 0 ) {

		
		echo "Veuillez saisir un montant correct ! <img src='images/s_error.png' />";

	}else{


		if ($nouveau_trajet_tarif == $prix_trajet_bdd ) {
			
			
			echo "Aucun changement a été effectué ! <img src='images/s_error.png' />";

		}else{


			$requete = $bdd->prepare(' UPDATE trajets SET prix_trajet = ? WHERE nom_agence = ? AND nom_trajet = ? '); 

			$requete->execute(array($nouveau_trajet_tarif,$_SESSION['agence'],$nom_trajet_tarif));


			echo "L'opération a été effectuée ".$nouveau_trajet_tarif." XAF est le nouveau tarif ! <img src='images/accept.png' />";


			}

		}

	}else{

		echo "impossible ! <img src='images/s_error.png' />";

	}

}elseif (preg_match('#akewa#', $_SESSION['agence'])) {



	$type_tarif = $_POST['type_prix_trajet_tarif'];


	if ($nouveau_trajet_tarif < 200000 && $nouveau_trajet_tarif >= 10000  ) {
	
	


		if (preg_match('#classe_eco_enfant#', $type_tarif)) {
			
			$requete = $bdd->prepare(' UPDATE trajets SET prix_trajet_classe_eco_enfant = ? WHERE nom_agence = ? AND nom_trajet = ? '); 

			$requete->execute(array($nouveau_trajet_tarif,$_SESSION['agence'],$nom_trajet_tarif));


			echo "L'opération a été effectuée ".$nouveau_trajet_tarif." XAF est le nouveau tarif ! <img src='images/accept.png' />";

		
		}elseif (preg_match('#classe_aff_enfant#', $type_tarif)) {


			$requete = $bdd->prepare(' UPDATE trajets SET prix_trajet_classe_aff_enfant = ? WHERE nom_agence = ? AND nom_trajet = ? '); 

			$requete->execute(array($nouveau_trajet_tarif,$_SESSION['agence'],$nom_trajet_tarif));


			echo "L'opération a été effectuée ".$nouveau_trajet_tarif." XAF est le nouveau tarif ! <img src='images/accept.png' />";

		
		}elseif (preg_match('#classe_eco_adulte#', $type_tarif)) {
			

			$requete = $bdd->prepare(' UPDATE trajets SET prix_trajet_classe_eco_adulte = ? WHERE nom_agence = ? AND nom_trajet = ? '); 

			$requete->execute(array($nouveau_trajet_tarif,$_SESSION['agence'],$nom_trajet_tarif));


			echo "L'opération a été effectuée ".$nouveau_trajet_tarif." XAF est le nouveau tarif ! <img src='images/accept.png' />";

		

		}elseif (preg_match('#classe_aff_adulte#', $type_tarif)) {
			

			$requete = $bdd->prepare(' UPDATE trajets SET prix_trajet_classe_aff_adulte = ? WHERE nom_agence = ? AND nom_trajet = ? '); 

			$requete->execute(array($nouveau_trajet_tarif,$_SESSION['agence'],$nom_trajet_tarif));


			echo "L'opération a été effectuée ".$nouveau_trajet_tarif." XAF est le nouveau tarif ! <img src='images/accept.png' />";

		

		}


	}else{


		echo "impossible ! <img src='images/s_error.png' />";


	}
}



}else{

	echo "Veuillez vous reconnecter...";
}