<?php 
session_name('flemadmin');

session_start();

include_once 'fonction.php';


if (isset($_SESSION['agence'])) {
	# code...


	if (isset($_POST['remise']) AND intval($_POST['remise']) >= 0 AND Intval($_POST['remise']) <= 100 AND !is_null($_POST['remise']) AND $_POST['remise'] !='') {
		

		$_POST['remise'] = $_POST['remise']/100;

		$reponse = $bdd->prepare(' UPDATE agence SET remise = ?  WHERE nom_agence = ? ');

		$reponse->execute(array($_POST['remise'],$_SESSION['agence']));


		$_POST['remise'] = $_POST['remise']*100;


		echo "Opération réussie la nouvelle remise est de <b>".$_POST['remise']."% </b> ! <img src='images/accept.png' />";



	

	} else {

		echo "Echec, la saisie n'est pas valide ! <img src='images/s_error.png' />";
	}
	

} else {
	
	echo "Veuillez vous connecter...SVP !";
}