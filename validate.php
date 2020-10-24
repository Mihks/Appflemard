<?php 
session_name("flemard");
session_start();
include_once('fonction.php');

$reference_received = $_SESSION['ref'];

if(isset($reference_received ) && !empty($reference_received ) ){
	
	echo '
<!DOCTYPE html>
<html>
	<head>
		<title>Voyage</title>
		<meta charset="utf-8"/>

		<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />
		<meta name="description" content="" />
		<meta name="keywords" content="voyage GABON" />
		<meta name="author" content="Klein Mihks" />
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 
		
		<link rel="stylesheet" type="text/css" href="agence/css/style.css">
		<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.structure.css">
		<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.theme.min.css">
		

	
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="shortcut icon" href="agence/images/flemard.jpg" />
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,300" rel="stylesheet" type="text/css" />
</head>

<body>
			
	<br/><br/>';
		
		
	$reponse = $bdd->prepare("SELECT client.nom, CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id
		FROM reservation,client,transaction,paiement 
		WHERE reservation.id_reservation = transaction.id_reservation AND 
		paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND paiement.ref_trans = ? ");

		$reponse->execute(array($reference_received));
		
		$donnees = $reponse->fetch();
		$id = $donnees['id'];
		$nom = $donnees['nom'];
		
	echo "		
		<div class='centre-text'>
			<p>votre paiement a été effectué <b>".$nom."</b>, merci et a bientot!</p>

			<p style='font-weight: bolder;'>
			Votre identifiant unique lié à votre réservation est le suivant  
			<span style='font-size:15px;color:red;'>".$id."</span>
			veuillez présenter ce code à l'agence , ne le divulguez à personne il contient tous les coordonnées de votre voyage <a href='index.php'>Retour</a>.
			</p>
			
		</div></body></html>";

		include('agence/includes/footer.php');
}
