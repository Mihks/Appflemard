
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

			echo '		
		<div id="succes"  class="centre-text">
			<p>votre paiement a été effectué <b>'.$_SESSION["nom"].'</b>, merci et a bientot!</p>

			<p style="font-weight: bolder;">si le téléchargement de votre billet ne se déclence pas automatiquement <a id="telchBillet" style="font-weight: bolder;" href="billet.php" target="_blank" >Cliquer ici</a></p>
			
		</div>';

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




