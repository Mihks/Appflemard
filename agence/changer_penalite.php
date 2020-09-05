<?php 

session_name('flemadmin');

session_start();

include_once 'fonction.php';



if (isset($_SESSION['agence'])) {
	# code...



	if (isset($_POST['penalite']) AND intval($_POST['penalite']) AND intval($_POST['penalite']) >= 0 AND intval($_POST['penalite'])<= 300000 AND !is_null($_POST['penalite']) AND !$_POST['penalite']=='') {
		


		$reponse = $bdd->prepare(' UPDATE agence SET penalite = ?  WHERE nom_agence = ? ');

		$reponse->execute(array($_POST['penalite'],$_SESSION['agence']));


		echo "Opération réussie le nouveau montant de penalité est de <b>".$_POST['penalite']." XAF</b> ! <img src='images/accept.png' />";



	

	} else {

		echo "Echec, la saisie n'est pas valide ! <img src='images/s_error.png' />";
	}
	

} else {
	
	echo "Veuillez vous connecter...SVP !";
}