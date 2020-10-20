<?php 
session_name("flemard");
session_start();
include_once 'fonction.php';

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
			veuillez présenter ce code à l'agence , ne le divulguez à personne il contient tous les coordonnées de votre voyage .
			</p>
			
		</div>";

		include('agence/includes/footer.php');
    