<?php 

session_name('flemadmin');

session_start();

include_once 'fonction.php';



$new_heure = $_POST['select_heure'].'h'.$_POST['select_min'].'min';



if (  preg_match('#^trajet_confondu$#', $_POST['trajet']) ) {


	if ($_POST['action']=='ajouter_heure_defaut') {
		# code...
	
		$reponse = $bdd->prepare(" SELECT DISTINCT trajet FROM horaire WHERE nom_agence = ? ");

		$reponse->execute(array($_SESSION["agence"]));


		$trajet = array();

		while ($donnees = $reponse->fetch()) {


			array_push($trajet,$donnees['trajet']);
		
		}

		$reponse->closeCursor();


		$requete = $bdd->prepare(" INSERT INTO horaire (heure,nom_agence,trajet) VALUES(?,?,?)");


		foreach ($trajet as  $value) { 
			# code...		

			$requete->execute(array($new_heure,$_SESSION["agence"],$value));

		}
	

	

	} elseif ($_POST['action']=='changer_heure_defaut') {
		# code...

		$requete = $bdd->prepare(" UPDATE horaire SET heure = ? WHERE nom_agence = ? AND heure = ?");

		$requete->execute(array($new_heure,$_SESSION["agence"],$_POST['ancien_heure']));


	}


	echo "Opération effectuée !";



}else{
	

	if ($_POST['action']=='ajouter_heure_defaut') {


	
		$reponse = $bdd->prepare(" INSERT INTO horaire (heure,nom_agence,trajet) VALUES (?,?,?) ");

		$reponse->execute( array($new_heure,$_SESSION["agence"],$_POST["trajet"]));



	}elseif ($_POST['action']=="changer_heure_defaut") {
		# code...

		$reponse = $bdd->prepare(" UPDATE horaire SET heure = ? WHERE nom_agence = ? AND trajet = ? AND heure = ? ");

		$reponse->execute( array($new_heure,$_SESSION["agence"],$_POST["trajet"],$_POST['ancien_heure']));

	}


	echo "Opération effectuée !";


}


