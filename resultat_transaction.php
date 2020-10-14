
<?php

session_name("flemard");

session_start(); 

include_once 'fonction.php';
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>resultat</title>

	<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />


	<link rel="stylesheet" href="agence/css/style.css" />
	<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.structure.min.css">
	<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.theme.min.css">


</head>
<body>

	<?php 


	if (!isset($_SESSION['code_statut'])) {
		
		header("Location:index.php");
		
	
	}else{



		if ($_SESSION['code_statut']==200) {
				
			echo '<header>
			
				<div class="log"><img src="agence/images/yaga.png" alt="logo" width="53" height="53"></div >
				<p class="slogan"></p>
				<span id="heure"></span>
				

				<button class="btn btn-navbar" id="btnMenu">    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span> 
				</button> 


				<nav id="nav">

					
					<div>
						
						<ul>

							<li><a href="index.php" class="">Accueil</a></li>
							<li><a href="index.php#reserve" id="lien-reserve">Reservation</a></li>
							<li><a href="index.php#a_propos" >A propos de</a></li>
							<li><a href="index.php#contact">Contact</a></li>

						
						</ul>
					</div>

				</nav>	

				<div id="heure"></div>

			</header>
			
			<br/><br/><br/><br/>';
		
		
	$reponse = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id
		FROM `reservation`,`client`,`transaction`,`paiement` 
		WHERE reservation.id_reservation = transaction.id_reservation AND 
		paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? 
		
		AND paiement.ref_trans = ? ");

		$reponse->execute(array($_SESSION['_agence'],$_SESSION['ref_trans']));
		
		$donnees = $reponse->fetch();

		echo "		
		<div id='succes'  class='centre-text'>
			<p>votre paiement a été effectué <b>".$_SESSION["nom"]."</b>, merci et a bientot!</p>

			<p style='font-weight: bolder;'>
			Votre identifiant unique lié à votre réservation est le suivant  
			<span style='font-size:15px;color:red;'>".$donnees['id']."</span>
			veuillez présenter ce code à l'agence , ne le divulguez à personne
			</p>
			
		</div>";

		include('agence/includes/footer.php');
			
			

		}else{

			echo '<header>
			
				<div class="log"><img src="images/yaga.png" alt="logo" width="53" height="53"></div >
				<p class="slogan"></p>
				<span id="heure"></span>
				

				<button class="btn btn-navbar" id="btnMenu">    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span> 
				</button> 


				<nav id="nav">

					
					<div>
						
						<ul>

							<li><a href="index.php" class="">Accueil</a></li>
							<li><a href="index.php#reserve" id="lien-reserve">Reservation</a></li>
							<li><a href="index.php#a_propos" >A propos de</a></li>
							<li><a href="index.php#contact">Contact</a></li>

						
						</ul>
					</div>

				</nav>	

				<div id="heure"></div>

			</header>
			
			<br/><br/><br/><br/>';

			echo "<div id='echoue'>

			<p class='centre-text'>votre paiement n'a pas été effectué</p>'

		</div>";

		include('agence/includes/footer.php');


		
// Suppression des variables de session et de la session 
		$_SESSION = array();
		session_destroy();

		}	

	}
?>
		
	
</body>

<script src="agence/js/jquery.min.js"></script>
<script src="agence/js/jquery-ui.min.js"></script>
<script src="agence/js/interfaceClient.js"></script>
</html>




