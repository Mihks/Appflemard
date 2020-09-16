<?php

session_name("flemard");


session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>traitement</title>

	<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />

	<link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php

include_once('classe.aller_simple.php');

include_once 'fonction.php';


$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");

$_SESSION['ref_trans'] = base_convert(uniqid(true), 16, 36);

$_SESSION['type'] = $_POST['type_billet']; // une session de type de billet

$_SESSION['_agence'] = $_POST['agence']; // une session de agence







function _header()
{
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
}



//la validité des jours de reservation

$reponse = $bdd->query(" SELECT CURRENT_DATE + interval 1 DAY AS jour_1 ,CURRENT_DATE + interval 2 DAY AS jour_2, CURRENT_DATE + interval 3 DAY jour_3, CURRENT_DATE + interval 4 DAY AS jour_4  ;");


$jourValide = array();

$donnees = $reponse->fetch();

array_push($jourValide, $donnees['jour_1'],$donnees['jour_2'],$donnees['jour_3'],$donnees['jour_4']);




if (( (isset($_POST['nom']) && !empty($_POST['nom']) && preg_match("#^[A-Za-z -]+$#", $_POST['nom']) && strlen($_POST['nom'])<=20 )

	&& (isset($_POST['type_billet']) && !empty($_POST['type_billet']) 
	
		&& preg_match('#^Aller_simple$#', $_POST['type_billet'])
	
		&& isset($_POST['nombre_billet']) && !empty($_POST['nombre_billet']) 
	
		&& $_POST['nombre_billet']>0 
	
		&& $_POST['nombre_billet']<=10 && filter_var($_POST['nombre_billet'],FILTER_SANITIZE_NUMBER_INT) )

	&& (isset($_POST['agence']) && !empty($_POST['agence']) 
	
		&& preg_match('#major|hitu|akewa|transporteur#', $_POST['agence'])) && (isset($_POST['depart'])
		
			&& !empty($_POST['depart']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['depart']) && ($_POST['depart'] == $jourValide[0] OR $_POST['depart'] == $jourValide[1] OR $_POST['depart'] == $jourValide[2]))
		
			&& (isset($_POST['heure_depart']) && !empty($_POST['heure_depart'])) ) OR ( (isset($_POST['nom']) && !empty($_POST['nom']) && preg_match("#^[A-Za-z -]+$#", $_POST['nom']) && strlen($_POST['nom'])<=20 )
			
				&& (isset($_POST['type_billet']) && !empty($_POST['type_billet']) 
				
					&& preg_match('#^Aller_retour$#', $_POST['type_billet'])
				
					&& isset($_POST['nombre_billet']) && !empty($_POST['nombre_billet']) 
				
					&& $_POST['nombre_billet']>0 
				
					&& $_POST['nombre_billet']<=10 && filter_var($_POST['nombre_billet'],FILTER_SANITIZE_NUMBER_INT) )
			
				&& (isset($_POST['agence']) && !empty($_POST['agence']) 
				
					&& preg_match('#major|hitu|akewa|transporteur#', $_POST['agence'])) && (isset($_POST['depart'])
					
						&& !empty($_POST['depart']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['depart']) && ($_POST['depart'] == $jourValide[0] OR $_POST['depart'] == $jourValide[1] OR $_POST['depart'] == $jourValide[2]))
					
						&& (isset($_POST['heure_depart']) && !empty($_POST['heure_depart'])) &&  (isset($_POST['retour']) && !empty($_POST['retour']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['retour']) && ($_POST['retour'] == $jourValide[1] OR $_POST['retour'] == $jourValide[2] OR $_POST['retour'] == $jourValide[3]) ) && (isset($_POST['heure_retour']) && !empty($_POST['heure_retour'])) && ($_POST['depart'] < $_POST['retour'] && $_POST['depart'] != $_POST['retour'])&& preg_match('#^Aller_retour$#', $_POST['type_billet'])) ) {


	

	$nom = $_POST['nom']; //filtrage du nom et le stoké dans une variable

	$_SESSION['nom'] = $nom;

	
	if (preg_match('#major#', $_POST['agence'])) {
		
		$trajet = $_POST['lieu_dep_maj'];
	

	}elseif (preg_match('#hitu#', $_POST['agence'])) {
		
		$trajet = $_POST['lieu_depart'];
	

	}elseif (preg_match('#transporteur#', $_POST['agence'])) {
		
		$trajet = $_POST['lieu_dep_transp'];
	}



$voyage = new Reservation($bdd,$trajet,$_POST['type_billet'],$nom,$_POST['depart'],$_POST['nombre_billet'],$_POST['heure_depart']);



	if (preg_match('#Aller_simple#', $_POST['type_billet'])) {
		

		$place_aller_dispo = $voyage->getPlaceDispo($_POST['type_billet']);

		$place_retour_dispo = 0;

		

	
	}elseif (preg_match('#Aller_retour#', $_POST['type_billet'])) {

		$voyage->setheureRetour($_POST['heure_retour']);

		$voyage->setdateRetour($_POST['retour']);
		
		$Aller_simple = 'Aller_simple';
		
		$place_aller_dispo = $voyage->getPlaceDispo($Aller_simple);


		$place_retour_dispo = $voyage->getPlaceDispo($_POST['type_billet']);

		
	}
	

if ( ( preg_match("#Aller_retour#", $_POST['type_billet']) && $place_aller_dispo < $_POST['nombre_billet'] && $place_retour_dispo < $_POST['nombre_billet'] ) 
	OR ( preg_match("#Aller_retour#", $_POST['type_billet']) && $place_aller_dispo < $_POST['nombre_billet'] && $place_retour_dispo > $_POST['nombre_billet'] ) 
	OR ( preg_match("#Aller_retour#", $_POST['type_billet']) && $place_aller_dispo > $_POST['nombre_billet'] && $place_retour_dispo < $_POST['nombre_billet'] ) 
	OR ( preg_match("#Aller_simple#", $_POST['type_billet']) && $place_aller_dispo < $_POST['nombre_billet'] ) ) {
	
	
	


	$place_aller = ($place_aller_dispo <= 1 )? '<b>place disponible</b>': '<b>places disponibles</b>';
	
	

	if ( preg_match("#Aller_retour#", $_POST['type_billet']) ) {



		$reponse = $bdd->prepare(" SELECT DATE_FORMAT(?,'%W, %e %M %Y') AS depart, DATE_FORMAT(?,'%W, %e %M %Y') AS retour ;");

		$reponse->execute(array($_POST['depart'],$_POST['retour']));

		$donnee = $reponse->fetch();

		$dateDepart = $donnee['depart'];

		$dateRetour = $donnee['retour'];

		$place_retour = ($place_retour_dispo <= 1 )? '<b>place disponible</b>': '<b>places disponibles</b>';

		if ($_POST['depart'] < $_POST['retour'] && $_POST['depart'] != $_POST['retour']) {
				
			_header();
			
			echo '<p class="centre-text">Vous souhaitez réserver <span style="color:red;font-weight:bold;">'.$_POST['nombre_billet'].'</span>  place(s) par voyage . <b>Cependant</b>, Il y a <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_aller_dispo.'</span> '.$place_aller.'</span> pour le '.$dateDepart.' à  '.$_POST['heure_depart'].' et <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_retour_dispo.'</span> '.$place_retour.' pour le '.$dateRetour.' à '.$_POST['heure_retour'].'  !<p/>';



			include('agence/includes/footer.php');

		
		}else{

			_header();

				echo "<p class='centre-text'>La date du retour doit toujours être supérieur à l'aller !<p/>";

			include('agence/includes/footer.php');
		}

		
	}else{

		$reponse = $bdd->prepare(" SELECT DATE_FORMAT(?,'%W, %e %M %Y') AS depart ;");

		$reponse->execute(array($_POST['depart']));

		$donnee = $reponse->fetch();

		$dateDepart = $donnee['depart'];


		_header();

		echo '<p class="centre-text">Vous souhaitez réserver <span style="color:red;font-weight:bold;">'.$_POST['nombre_billet'].'</span> place(s) . <b>Cependant</b>, Il y a <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_aller_dispo.'</span> '.$place_aller.' pour le '.$dateDepart.' à  '.$_POST['heure_depart'].' !<p/>';

		include('agence/includes/footer.php');
	}
	

	
} else{


	if (!preg_match("#^(074|077)[0-9]{6}$#", $_POST['tel_client'])) {


		// Suppression des variables de session et de la session 
		$_SESSION = array();
		session_destroy();


		echo("<br><br><div style='font-size: 24px ;font-weight:bolder;text-align: center;'>Désolé le numéro n'est pas valide<a href='index.php#reserve' style='font-weight:bolder;text-align: center;text-decoration:none;font-size: 24px;' >retour</a></div><br>");

		include('agence/includes/footer.php');

		exit;

	}


	$voyage->insertion();


//envoies les infos API mypivit

	$infos = $voyage->getinfoCompte();

	$info = explode(';', $infos);

	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_POST, 1); 

	curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/pvit-secure-full-api.kk"); 
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, 

		"tel_marchand=077565805 

		&montant=".$_SESSION['montant']." 

		&ref=".$_SESSION['ref_trans']." 

		&tel_client=".$_POST['tel_client']."  

		&token=".$info[0]." 

		&action=1 

		&service=WEB 

		&operateur=".$info[1]."


		&redirect=https://flemardapp.herokuapp.com/resultat_transaction.php 

		&agent=caisse3"); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	$resultat = curl_exec($ch);

	curl_close($ch);
	
	//-----------------------------------------------------------------------------------------------------------------------------------e


			}	#la condition de verification de place prend fin ici#


			

}else{

	_header();
	
	echo("<p class='centre-text'>Votre formulaire contient des incohérences, veuillez recommencer... !</p>");

	include('agence/includes/footer.php');


}




?>



	<script src="Espace client/js/jquery.min.js"></script>
	<script src="Espace client/js/jquery-ui.min.js"></script>


	<!-- <script src="js/interfaceClient.js"></script> -->
			
	<script type="text/javascript">
		
		$(function () {



				//AFFICHE LHEURE
//----------------------------------------------------------------------------------------

			function horloge(){

				var date = new Date();
				var h = date.getHours()+ ":"+ date.getMinutes()+ ":"+ date.getSeconds();
				$("#heure").text(h).css("color",'rgb(0,128,128)');
			}

			setInterval(horloge,1000);


			$(".slogan").html("Donner un Sens à votre Flemme !").css("font-size","small").css("color","rgb(0,128,128)").css("text-decoration","underline").css("text-decoration-color","orange");




			$('#btnMenu').on('click touch', function(){            

				$('#nav').slideToggle();    

				});





		});
	</script>		
