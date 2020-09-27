<?php

session_name("flemard");


session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>traitement</title>

	<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />

	<link rel="stylesheet" href="agence/css/style.css" />
</head>
<body>

<?php


include_once 'fonction.php';


$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");

$_SESSION['ref_trans'] = base_convert(uniqid(true), 16, 36);

$_SESSION['type'] = $_POST['type_billet']; // une session de type de billet

$_SESSION['_agence'] = $_POST['agence']; // une session de agence



// 	if (!preg_match("#^(074|077|066|062|060|065|)[0-9]{6}$#", $_POST['tel_client'])) {


// 		// Suppression des variables de session et de la session 
// 		$_SESSION = array();
// 		session_destroy();


// 		echo("<br><br><div style='font-size: 24px ;font-weight:bolder;text-align: center;'>Désolé le numéro n'est pas valide<a href='index.php#reserve' style='font-weight:bolder;text-align: center;text-decoration:none;font-size: 24px;' >retour</a></div><br>");

// 		include('agence/includes/footer.php');

// 		exit;

// 	}
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
	
		&& preg_match('#major|hitu|akewa|transporteur|excellence_transport#', $_POST['agence'])) && (isset($_POST['depart'])
		
			&& !empty($_POST['depart']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['depart']) && ($_POST['depart'] == $jourValide[0] OR $_POST['depart'] == $jourValide[1] OR $_POST['depart'] == $jourValide[2]))
		
			&& (isset($_POST['heure_depart']) && !empty($_POST['heure_depart'])) && preg_match('#^airtel$|^gabontelecom$#', $_POST['moyen_paiement']) ) OR ( (isset($_POST['nom']) && !empty($_POST['nom']) && preg_match("#^[A-Za-z -]+$#", $_POST['nom']) && strlen($_POST['nom'])<=20 )
			
				&& (isset($_POST['type_billet']) && !empty($_POST['type_billet']) 
				
					&& preg_match('#^Aller_retour$#', $_POST['type_billet'])
				
					&& isset($_POST['nombre_billet']) && !empty($_POST['nombre_billet']) 
				
					&& $_POST['nombre_billet']>0 
				
					&& $_POST['nombre_billet']<=10 && filter_var($_POST['nombre_billet'],FILTER_SANITIZE_NUMBER_INT) )
			
				&& (isset($_POST['agence']) && !empty($_POST['agence']) 
				
					&& preg_match('#major|hitu|akewa|transporteur|excellence_transport#', $_POST['agence'])) && (isset($_POST['depart'])
					
						&& !empty($_POST['depart']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['depart']) && ($_POST['depart'] == $jourValide[0] OR $_POST['depart'] == $jourValide[1] OR $_POST['depart'] == $jourValide[2]))
					
						&& (isset($_POST['heure_depart']) && !empty($_POST['heure_depart'])) &&  (isset($_POST['retour']) && !empty($_POST['retour']) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $_POST['retour']) && ($_POST['retour'] == $jourValide[1] OR $_POST['retour'] == $jourValide[2] OR $_POST['retour'] == $jourValide[3]) ) && (isset($_POST['heure_retour']) && !empty($_POST['heure_retour'])) && ($_POST['depart'] < $_POST['retour'] && $_POST['depart'] != $_POST['retour'])&& preg_match('#^Aller_retour$#', $_POST['type_billet']) && preg_match('#^airtel$|^gabontelecom$#', $_POST['moyen_paiement']) ) ) {


$_POST['nom'] =	trim($_POST['nom']);

$_POST['nom'] = stripslashes($_POST['nom']);

$_POST['nom'] = strip_tags($_POST['nom']);
 //filtrage du nom et le stoké dans une variable

$_SESSION['nom'] = $_POST['nom']; ///////


	$reponse = $bdd->prepare(" SELECT nombre_place_dispo FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

	$reponse->execute(array($_POST["agence"],$_POST['depart'],$_POST['trajet'],$_POST['heure_depart']));

	$donnees = $reponse->fetch();

	$place_aller_dispo = $donnees['nombre_place_dispo'];

	$reponse->closeCursor();


	if (preg_match('#Aller_retour#', $_POST['type_billet'])) {
		

		$retour = explode('-',$_POST['trajet']);

		$trajet_retour = $retour[1] + $retour[0];

		$reponse = $bdd->prepare(" SELECT nombre_place_dispo FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

		$reponse->execute(array($_POST["agence"],$_POST['retour'],$trajet_retour,$_POST['heure_retour']));

		$donnees = $reponse->fetch();
		
		$place_retour_dispo = $donnees['nombre_place_dispo'];
	
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
				
			
			echo '<p class="centre-text">Vous souhaitez réserver <span style="color:red;font-weight:bold;">'.$_POST['nombre_billet'].'</span>  place(s) par voyage . <b>Cependant</b>, Il y a <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_aller_dispo.'</span> '.$place_aller.'</span> pour le '.$dateDepart.' à  '.$_POST['heure_depart'].' et <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_retour_dispo.'</span> '.$place_retour.' pour le '.$dateRetour.' à '.$_POST['heure_retour'].'  !<p/>';



			include('agence/includes/footer.php');

		
		}else{

		
				echo "<p class='centre-text'>La date du retour doit toujours être supérieur à l'aller !<p/>";

			include('agence/includes/footer.php');
		}

		
	}else{

		$reponse = $bdd->prepare(" SELECT DATE_FORMAT(?,'%W, %e %M %Y') AS depart ;");

		$reponse->execute(array($_POST['depart']));

		$donnee = $reponse->fetch();

		$dateDepart = $donnee['depart'];


		echo '<p class="centre-text">Vous souhaitez réserver <span style="color:red;font-weight:bold;">'.$_POST['nombre_billet'].'</span> place(s) . <b>Cependant</b>, Il y a <span style="color:rgb(0,128,128);font-weight:bold;">'.$place_aller_dispo.'</span> '.$place_aller.' pour le '.$dateDepart.' à  '.$_POST['heure_depart'].' !<p/>';

		include('agence/includes/footer.php');
	}
	

	
} else{




/////////////////////////////////calcul du montant
	

	/////Prix unitaire...///////////////
	$reponse = $bdd->prepare(" SELECT prix_trajet FROM trajets WHERE nom_trajet = ? AND nom_agence = ?"); 
							
	$reponse->execute(array($_POST['trajet'] ,$_POST['agence'])) or die(print_r($bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		
	$donnees = $reponse->fetch(); 

		
	$prixUnitaire = $donnees['prix_trajet'];

	$reponse->closeCursor();


	///////////////////////////////////////////////////::::///////////////



////////////////////remise......//////////////


// je recupere dans la bdd les infos de l'agence: le numero de tel et sa remise en cas d'aller retour
	$reponse = $bdd->prepare(" SELECT  `remise` FROM `agence` WHERE nom_agence = ? ");  
	
	$reponse->execute(array($_POST['agence'])) or die(print_r($bdd->errorInfo())); //renvoie une erreur en cas d'erreur

	$donnees = $reponse->fetch(); 

	$remise = $donnees['remise'];
			
	$reponse->closeCursor();



////////////////////////////////////:::

	// if ( $_POST['type_billet'] == "Aller_simple"){
			
	// 	$montant = $prixUnitaire*$_POST['nombre_billet'];


	// }elseif ( $_POST['type_billet'] == "Aller_retour") {
			
	// 	$montant = $prixUnitaire*$_POST['nombre_billet']*( 2 - $remise);

		
	// }

	$montant = ($_POST['type_billet'] == "Aller_simple") ? $prixUnitaire*$_POST['nombre_billet'] : $prixUnitaire*$_POST['nombre_billet']*( 2 - $remise);


	//////////////////////////////////////////insertion////////////////


		$_SESSION['montant'] = $montant;


		if ( $_SESSION['montant'] < 100 || $_SESSION['montant'] > 490000  ) {

			$montant = $_SESSION['montant'];

			// Suppression des variables de session et de la session 
			$_SESSION = array();
			session_destroy();


			echo("<br><br><div style='font-size: 24px ;font-weight:bolder;text-align: center;'>Désolé le prix de votre billet s'élève à ".$montant." fcfa , <br>le montant d'une transaction est limité à  490 000 fcfa!<br><br><a href='index.php#reserve' style='font-weight:bolder;text-align: center;text-decoration:none;font-size: 24px;' >retour</a></div><br>");

			include('agence/includes/footer.php');

			exit;

		}

		 
		ini_set('display_errors',1);

		$tab = explode('-', $_POST['trajet'] ,2);

		$villeClient = $tab[0];

		$villedestination = $tab[1];


		if (preg_match('#^Aller_simple$#', $_POST['type_billet'] )) {

			/////insertion dans la table reservation
		
			$requete = $bdd->prepare('INSERT INTO reservation (nom_agence,date_depart,heure_depart,trajet,nombre_place,type_reservation ) VALUES(?,?,?,?,?,?)');
			
			$requete->execute(array($_POST['agence'],$_POST['depart'] ,$_POST['heure_depart'],$_POST['trajet']
				,$_POST['nombre_billet'],$_POST['type_billet']));
		

		}elseif (preg_match('#^Aller_retour$#', $_POST['type_billet'] )) {
			
			/////insertion dans la table reservation
		
			$requete = $bdd->prepare('INSERT INTO reservation (nom_agence,date_depart,heure_depart,trajet,nombre_place,type_reservation,trajet_retour,heure_retour,date_retour ) VALUES(?,?,?,?,?,?,?,?,?)');

			$requete->execute(array($_POST['agence'],$_POST['depart'],$_POST['heure_depart'],$_POST['trajet'] 

				,$_POST['nombre_billet'] ,$_POST['type_billet'],$trajet_retour,$_POST['heure_retour'] ,$_POST['retour'] ));
		}



		//insertion dans la table paiement

		$requete1 = $bdd->prepare('INSERT INTO paiement (ref_trans,nom_paiement,code_statut,montant_debite,date_paiement,id_reservation ) VALUES(?,?,?,?, NOW(),LAST_INSERT_ID())');
							
		$requete1->execute(array($_SESSION['ref_trans'],NULL,NULL,$_SESSION['montant']));



		////////// insertion dans la table client .....					//introduction des villes
		$requete2 = $bdd->prepare('INSERT INTO client (nom,ville_client ,ville_destination_client) VALUES(upper(?),?,?)'); 

		$requete2->execute(array($_SESSION['nom'],$villeClient,$villedestination));


////////////////////////////////////////://////////////::

	// recupere moi l'id du client qui est en train de senregistrer ainsi que son id_reservation
		$reponse = $bdd->prepare(" SELECT id_reservation FROM paiement WHERE paiement.ref_trans = ? "); 
		
		$reponse->execute(array($_SESSION['ref_trans'])) or die(print_r($bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 
		
		$id_reservation = $donnees['id_reservation'];

		$reponse->closeCursor();

		

		$_SESSION['id_reservation'] = $id_reservation;


		$requete = $bdd->prepare('INSERT INTO transaction (id_client,id_reservation,ref_trans,date_reservation,date_reservation_2) VALUES(LAST_INSERT_ID(),?,?,NOW(),NOW())');
							
		$requete->execute(array($_SESSION['id_reservation'],$_SESSION['ref_trans']));


		// recupere moi l'id du client qui est en train de senregistrer ainsi que son id_reservation
		$reponse = $bdd->prepare(" SELECT id_client FROM transaction WHERE transaction.ref_trans = ? "); 
		
		$reponse->execute(array($_SESSION['ref_trans'])) or die(print_r($bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 
		
		$id_client = $donnees['id_client'];

		$reponse->closeCursor();
		

		$_SESSION['id_client'] = $id_client;




///////////////////////////////////////////////////fin insertion/////////////////////////////////////////:
//envoies les infos API mypivit


	$reponse = $bdd->prepare(" SELECT CONCAT_WS(';',id_operateur,tel_marchand)  AS infos 

										FROM compte_marchand  WHERE nom_operateur = ? "); 

	$reponse->execute(array($_POST['moyen_paiement'])) or die(print_r($bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		
	$donnees = $reponse->fetch();

		
	$infos = $donnees['infos'];

	$info = explode(';', $infos);
	
	$pvitform = '<form id="pvitform" method="POST" action="https://mypvit.com/pvit-secure-full-api.kk" onload="this.submit();">
	<input type="hidden" name="tel_marchand" value="0'.$info[1].'">	
	<input type="hidden" name="montant" value="'.$_SESSION['montant'].'">	
	<input type="hidden" name="ref" value="'.$_SESSION['ref_trans'].'">	
	<input type="hidden" name="operateur" value="'.$info[0].'">	
	<input type="hidden" name="redirect" value="https://flemardapp.herokuapp.com/resultat_transaction.php">	
	<input type="submit" style="display: none;" value="payer">	
	</form>
	<script type="text/javascript">
		document.getElementById("pvitform").onload();
	</script>';
	echo($pvitform);
 
	/* $ch = curl_init(); 

	curl_setopt($ch, CURLOPT_POST, 1); 

	curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/pvit-secure-full-api.kk"); 
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, 
		"tel_marchand=077565805&montant=".$_SESSION['montant']." &ref=".$_SESSION['ref_trans']."&operateur=AM&redirect=https://flemardapp.herokuapp.com/resultat_transaction.php"); 
	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	$resultat = curl_exec($ch);
	var_dump($resultat);

	curl_close($ch); */
	
	//-----------------------------------------------------------------------------------------------------------------------------------e

	
			}	#la condition de verification de place prend fin ici#


			

}else{

	echo("<p class='centre-text'>Votre formulaire contient des incohérences, veuillez recommencer... !</p>");

	include('agence/includes/footer.php');


}




?>

