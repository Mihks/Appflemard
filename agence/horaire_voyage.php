<?php 

session_name('flemadmin');

session_start();


	include_once 'fonction.php';





if (  preg_match('#^trajet_confondu$#', $_POST['trajet']) ) {



	$reponse = $bdd->prepare(" SELECT DISTINCT heure FROM horaire WHERE nom_agence = ? ");

	$reponse->execute( array($_SESSION["agence"]));

	while ($donnees = $reponse->fetch()) {
	

		echo "<option value='".$donnees['heure']."'>".$donnees['heure']."</option>";

	}

	$reponse->closeCursor();

}else{
	
	

	$reponse = $bdd->prepare(" SELECT heure FROM horaire WHERE nom_agence = ? AND trajet = ? ");

	$reponse->execute( array($_SESSION["agence"],$_POST["trajet"]));

	

	while ($donnees = $reponse->fetch()) {
	

		echo "<option value='".$donnees['heure']."'>".$donnees['heure']."</option>";

	}

	$reponse->closeCursor();
}


