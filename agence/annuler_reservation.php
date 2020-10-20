<?php
session_name('flemadmin');
session_start();


if (!isset($_SESSION['agence'])) {

	include_once 'fonction.php';

	demandeReconnexion();

}else{

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Annuler</title>
	</head>



<body>

	<div id='un'>
<?php

include_once 'fonction.php';


	$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");
	function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

	$id = filtre($_POST['id']);

$rep =  $bdd->prepare(" SELECT  Duree_validite_billet AS duree FROM agence WHERE nom_agence = ? ");

$rep->execute(array($_SESSION['agence']));

$data = $rep->fetch() ;


$date_limit = $data['duree'];

$rep->closeCursor() ;


$reponse = $bdd->prepare('SELECT ville_destination_client AS ville_dest FROM client,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ');


$reponse->execute(array($_SESSION['agence'],$id));


$donnee = $reponse->fetch();

$ville_dest = $donnee['ville_dest']; 

$reponse->closeCursor();



if (preg_match('#^terrestre$#', $_SESSION['type_agence'])) {
	


	if (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) { 
		# code...

		$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.nombre_place,reservation.date_depart,DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = 'Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?  AND client.ville_client = ?

		UNION
			SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.nombre_place,reservation.date_depart,DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = 'Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?  AND client.ville_client = ?
		UNION
		  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,reservation.id_reservation,(reservation.statut_voyage_2) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.nombre_place,reservation.date_retour,DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 = 'Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?  AND client.ville_destination_client = ? ORDER BY ref_trans ASC; ");

		$rep->execute(array($date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$ville_dest));

		
		echo "<table id='tab'>
						<thead>
						<tr>
						<th></th>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Type de reservation</th>
						<th>Nombre de place</th>
						<th>Date de depart</th>
						<th>Heure de depart</th>
						<th>Etat de voyage</th>
						<th>Date de paiement</th>
						<th>Validité du billet</th>
						<th>Reference</th>
						</thead><tr>";

		while ($donnees = $rep->fetch()) {


			if ($donnees['nbre_jrs']==0) {

				$nbre_jrs = 'moins de 24h';


			}elseif ( $donnees['nbre_jrs'] > 1) {

				$nbre_jrs =  $donnees['nbre_jrs'].' jours';


			}elseif ( $donnees['nbre_jrs'] == 1) {


				$nbre_jrs = $donnees['nbre_jrs'].' jour';

			}else{

				$nbre_jrs = "Expiré";

			}


			$nbre_jrs = ($donnees['etat']=='Effectue') ? "Consommé" : $nbre_jrs ;



			echo "<td><button class='".$donnees['date_depart']."' value='".$donnees['id_reservation']."' id='".$donnees['type']."' >Annuler</button></td>";
			
			echo "<td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td>".$donnees['depart']."</td>"
				 ."<td>".$donnees['heure']."</td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['paie']."</td>"
				 ."<td style='color:red;'>".$nbre_jrs."</td>"
				 ."<td>".$donnees['ref_trans']."</td></tr>";
				 

				 

		}

		
		echo '</table>';
		

		

				
	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat</div>";
	}



}elseif (preg_match('#^maritime$#', $_SESSION['type_agence'])) {
	


	if (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) { 
		# code...

		$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS reserve,paiement.ref_trans,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,reservation.date_depart FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = 'Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?

		UNION
			SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS reserve,paiement.ref_trans,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,reservation.date_depart FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = 'Non-Effectue'  AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?
		UNION
		  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,reservation.id_reservation,(reservation.statut_voyage_2) AS etat,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS reserve,paiement.ref_trans,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,reservation.date_retour FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 = 'Non-Effectue'  AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_destination_client  = ? ORDER BY ref_trans ASC; ");

		$rep->execute(array($_SESSION['agence'],$id,$_SESSION['region'],$_SESSION['agence'],$id,$_SESSION['region'],$_SESSION['agence'],$id,$ville_dest));

		
		echo "<table id='tab'>
						<thead>
						<tr>
						<th></th>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Type de reservation</th>
						<th>Nombre de place</th>
						<th>Categorie</th>
						<th>Classe</th>
						<th>Date de depart</th>
						<th>Heure de depart</th>
						<th>Etat de reservation</th>
						<th>Date de voyage</th>
						<th>Reference</th>
						</thead><tr>";

		while ($donnees = $rep->fetch()) {


			echo "<td><button class='".$donnees['date_depart']."' value='".$donnees['id_reservation']."' id='".$donnees['type']."' >Annuler</button></td>";
			
			echo "<td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td>".$donnees['seuil']."</td>"
				 ."<td>".$donnees['classe']."</td>"
				 ."<td>".$donnees['depart']."</td>"
				 ."<td>".$donnees['heure']."</td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['reserve']."</td>"
				 ."<td>".$donnees['ref_trans']."</td></tr>";
				 

				 

		}

		
		echo '</table>';
		

		

				
	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat</div>";
	}



}
	  
?>
</div>

 <div id="deux" hidden>Voulez-vous vraiment annuler ce voyage ? <img src='images/s_attention.png' /></div>

 <div id="impossible" hidden>Vous ne pouvez plus annuler ce voyage cordialement ! <img src='images/s_error.png' /></div>
 
	
</body>

	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
		

	<script >
				
		$(function(){


			$.post('recup_variablephp.php',            
		 		           
		 		    function(data) {              
		 			
		 			window['today'] = data;

		 			
		 		});
			

			$('table button').click(function(){

				var depart = $(this).attr('class');

				var mois_fr = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

				var jour_fr = new Array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
				var date = new Date();
				// var today = date.getFullYear()+'-'+mois_fr[date.getMonth()]+'-'+jour_fr[date.getDate()];

				
				
				if (depart < today ) {

					$("#impossible").dialog({modal:true,title:'Impossible',buttons:{
						'Fermer': function(){

							$(this).dialog("close");
						}
					}

					});
				}else{

				var id = $(this).val();

				var choixId = $(this).attr('id');
 
				if (choixId =='Aller' || choixId =='Unique' ){
				
						$("#deux").dialog({      
						modal: true,title:'Annuler',      
						buttons: {        
							"Oui": function() { 

								      
								$.post('annuler.php',{id:id},function (donnee) {


									
									$("#deux").html(donnee).dialog({modal: true,title:'Annuler',open:function(){



										$(".ui-dialog-titlebar-close").hide();

									
									},buttons:{

									'Fermer':function(){

										location.reload();
									}}});
								});          
								$(this).dialog("close");
								    
							},        
							"Non": function() {          
								$(this).dialog("close");     
							}   
						}    
					}); 

					}else if (choixId =='Retour'){

						$("#deux").dialog({      
						modal: true,title:'Annuler',      
						buttons: {        
							"Oui": function() { 

								    
								$.post('annuler_1.php',{id:id},function(donnee){

									$(".ui-dialog-titlebar-close").hide();

									$("#deux").html(donnee).dialog({modal: true,title:'Annuler',buttons:{

									'Fermer':function(){

										location.reload();
									}}});

								});          
								$(this).dialog("close");
								    
							},        
							"Non": function() {          
								$(this).dialog("close");     
							}   
						}    
					}); 

					}

					}

		});


		});

	 </script >

</html>
<?php 
}


