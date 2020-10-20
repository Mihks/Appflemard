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
		<meta charset="utf-8" />
		<title></title>

		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.structure.min.css">
		<link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css">
	<style type="text/css">
		#chargement,#aucunResultat{

			font-family: 'chiller';
			font-size: 60px;
			color: rgb(0,128,128);
			position: relative;
			width: 500px;
			text-shadow: 1px 1px 30px black;
			top: 100px;
			left: 430px;


	</style>
	</head>



<body>

	<div id='donnee'>
<?php




	include_once 'fonction.php';



	function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");


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
	
	if ($_SESSION['membre']=='administrateur') {
		# code...

			if (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) {

					$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_simple','Unique','Aller-retour') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_depart,'%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs , reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?
				UNION

					SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs , reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?

				UNION


				  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,reservation.id_reservation,(reservation.statut_voyage_2) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_retour AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs, reservation.trajet_retour AS trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ORDER BY ref_trans ASC; ");



				$rep->execute(array($date_limit,$_SESSION['agence'],$id,$date_limit,$_SESSION['agence'],$id,$date_limit,$_SESSION['agence'],$id));


				echo "<table id='tab'>
						<thead>
						<tr>
						<th></th>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Type de réservation</th>
						<th>Nombre de place</th>
						<th>Trajet</th>
						<th>Date de depart</th>
						<th>Heure de depart</th>
						<th>Etat de voyage</th>
						<th>Date de paiement</th>
						<th>Validité du billet</th>
						<th>Reference</th>
						</thead></tr>";




			while ($donnees = $rep->fetch()) {

			// $jr_sing_plur = '';

			// $nbre_jrs = ( $donnees['nbre_jrs'] >= 0 ) ?  $donnees['nbre_jrs']. $jr_sing_plur = ($donnees['nbre_jrs'] > 1) ? ' jours' : ' jour' : "Expiré";

			if ($donnees['nbre_jrs']==0) {
				
				$nbre_jrs = 'moins de 24h';
				

			}elseif ( $donnees['nbre_jrs'] > 1) {

				$nbre_jrs =  $donnees['nbre_jrs'].' jours';
			
			}elseif ( $donnees['nbre_jrs'] == 1) {
				
				$nbre_jrs = $donnees['nbre_jrs'].' jour';
			
			}else{
				
				$nbre_jrs = "Expiré";
			}





			// $nbre_jrs = ($donnees['nbre_jrs'] == 0)? "moins de 24h" : $donnees['nbre_jrs'].$jr_sing_plur;

			$nbre_jrs = ($donnees['etat']=='Effectue') ? "Consommé" : $nbre_jrs ;




			echo "<tr><td><button title='".$donnees['trajet']."' value='".$donnees['id_reservation']."' id='".$donnees['type']."' class='".$donnees['date_voyage']."'>Modifier</button></td>
				  <td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td >".$donnees['trajet']."</td>"
				 ."<td><span>".$donnees['depart']."</span></td>"
				 ."<td><span>".$donnees['heure']."</span></td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['paie']."</td>"
				 ."<td style='color:red;'>".$nbre_jrs."</td>"
				 ."<td>".$donnees['ref_trans']."</td></tr>";

	
			 }


	 		echo '</table>';



		}else{

			echo "<div id='aucunResultat'>Aucun resultat...</div>";


		}


	} else {
		# code...autres membres

	
	
	if (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) {
		

		$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_depart,'%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs , reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?

		UNION
			SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs , reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?
		UNION
		  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,reservation.id_reservation,(reservation.statut_voyage_2) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_retour AS date_voyage, DATEDIFF( paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs, reservation.trajet_retour AS trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_destination_client = ? ORDER BY ref_trans ASC; ");

		$rep->execute(array($date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$ville_dest));

		



		echo "<table id='tab'>
						<thead>
						<tr>
						<th></th>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Type de réservation</th>
						<th>Nombre de place</th>
						<th>Trajet</th>
						<th>Date de depart</th>
						<th>Heure de depart</th>
						<th>Etat de voyage</th>
						<th>Date de paiement</th>
						<th>Validité du billet</th>
						<th>Reference</th>
						</thead></tr>";

		while ($donnees = $rep->fetch()) {

			// $jr_sing_plur = '';

			// $nbre_jrs = ( $donnees['nbre_jrs'] >= 0 ) ?  $donnees['nbre_jrs']. $jr_sing_plur = ($donnees['nbre_jrs'] > 1) ? ' jours' : ' jour' : "Expiré";

			if ($donnees['nbre_jrs']==0) {
				
				$nbre_jrs = 'moins de 24h';
				

			}elseif ( $donnees['nbre_jrs'] > 1) {

				$nbre_jrs =  $donnees['nbre_jrs'].' jours';
			
			}elseif ( $donnees['nbre_jrs'] == 1) {
				
				$nbre_jrs = $donnees['nbre_jrs'].' jour';
			
			}else{
				
				$nbre_jrs = "Expiré";
			}

			// $nbre_jrs = ($donnees['nbre_jrs'] == 0)? "moins de 24h" : $donnees['nbre_jrs'].$jr_sing_plur;

			$nbre_jrs = ($donnees['etat']=='Effectue') ? "Consommé" : $nbre_jrs ;




			echo "<tr><td><button title='".$donnees['trajet']."' value='".$donnees['id_reservation']."' id='".$donnees['type']."' class='".$donnees['date_voyage']."'>Modifier</button></td>
				  <td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td >".$donnees['trajet']."</td>"
				 ."<td><span>".$donnees['depart']."</span></td>"
				 ."<td><span>".$donnees['heure']."</span></td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['paie']."</td>"
				 ."<td style='color:red;'>".$nbre_jrs."</td>"
				 ."<td>".$donnees['ref_trans']."</td></tr>";

				 

		}

		
		echo '</table>';
		

		

				
	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat...</div>";
	}



		}

}elseif (preg_match('#^maritime$#', $_SESSION['type_agence'])) {
	

	if (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) {
		

		$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs, reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?

		UNION
			SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,reservation.id_reservation,(reservation.statut_voyage_1) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_depart AS date_voyage, DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs, reservation.trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_client = ?
		UNION
		  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,reservation.id_reservation,(reservation.statut_voyage_2) AS etat,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS paie,paiement.ref_trans,reservation.date_retour AS date_voyage, DATEDIFF(paiement.date_paiement + interval ? DAY,CURRENT_DATE) AS nbre_jrs, reservation.trajet_retour AS trajet FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 ='Non-Effectue' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? AND client.ville_destination_client = ? ORDER BY ref_trans ASC; ");

	$rep->execute(array($date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$_SESSION['region'],$date_limit,$_SESSION['agence'],$id,$ville_dest));

		
		echo "<table id='tab'>
						<thead>
						<tr>
						<th></th>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Type de réservation</th>
						<th>Nombre de place</th>
						<th>Trajet</th>
						<th>Categorie</th>
						<th>Classe</th>
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

			// $nbre_jrs = ($donnees['nbre_jrs'] == 0)? "moins de 24h" : $donnees['nbre_jrs'].$jr_sing_plur;

			$nbre_jrs = ($donnees['etat']=='Effectue') ? "Consommé" : $nbre_jrs ;

			echo "<td><button title='".$donnees['trajet']."' value='".$donnees['id_reservation']."' id='".$donnees['type']."' class='".$donnees['date_voyage']."'>Modifier</button></td>
				  <td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td>".$donnees['trajet']."</td>"
				 ."<td>".$donnees['seuil']."</td>"
				 ."<td>".$donnees['classe']."</td>"
				 ."<td><span>".$donnees['depart']."</span></td>"
				 ."<td><span>".$donnees['heure']."</span></td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['paie']."</td>"
				 ."<td style='color:red;'>".$nbre_jrs."</td>"
				 ."<td>".$donnees['ref_trans']."</td></tr>";

				 

		}

		
		echo '</table>';
		

		

				
	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat</div>";
	}

}

	  
?>
</div>

<!-- <div id="message" hidden >Voulez-vous vraiment valider cette operation ?</div>
<div id="impossible" hidden>Vous ne pouvez plus effectuer cette operation cordialement !</div> -->

<div id="dial_reprog" hidden> 
	
	<?php 


		$reponse = $bdd->query(" SELECT CURRENT_DATE AS jour,
										CURRENT_DATE + interval 1 DAY AS jour_1,
										CURRENT_DATE + interval 2 DAY AS jour_2,
										CURRENT_DATE + interval 3 DAY AS jour_3,
										CURRENT_DATE + interval 4 DAY AS jour_4 ");

		
		$donnees = $reponse->fetch();

		$jours_reprog = array();

		array_push($jours_reprog,$donnees['jour'],$donnees['jour_1'],$donnees['jour_2'],$donnees['jour_3'],$donnees['jour_4']); 

		$reponse->closeCursor();

		 echo "Date :<select id='choix_date_reprog' style='margin:15px;'>";

		 foreach ($jours_reprog as $value) {


		 	echo "<option value='".$value."'>".$value."</option>";

	
		 }

		 echo "</select><br/>";
		?>

	Heure : <select id="heure_reprog">
		 
	</select>

</div>

	
</body>

	<script src="../js/jquery.min.js"></script>
	<script src="../js/jquery-ui.min.js"></script>

		

	<script >
				
		$(function(){

			$('#choix_date_reprog').change(function(){

				$.post('horaire.php',{date: $('#choix_date_reprog').val(),trajet:title},function(data){

					$('#heure_reprog').html(data);
				});
			});




			$('td button').click(function(){



				window['id'] = $(this).val();

				window['title'] = $(this).attr('title');

				window['type_reservation'] = $(this).attr('id');

				window['depart'] = $(this).attr('class');

				$.post('horaire.php',{date: $('#choix_date_reprog').val(),trajet:title},function(data){

					$('#heure_reprog').html(data);
				});
				$("#dial_reprog").dialog({modal:true,
										 

					 title:'Changer de date de voyage',
					 buttons:{
					  	'Valider': function(){

					  	$(this).dialog('close');

				 		var date = $('#choix_date_reprog').val();
						
						var heure = $('#heure_reprog').val();

				  		$.post('reprogramer_voyage_1.php',{'id':id,'date':date,'heure':heure,'type':type_reservation,'depart':depart} ,            
		 		           
		 		 			function(data) {


					   			$("#dial_reprog").html(data);

		 		 	   			$('#dial_reprog').dialog({modal:true,title:'Changer de date de voyage',

								open: function(){

										$(".ui-dialog-titlebar-close").hide();
														
										},buttons :{
															
											'Fermer': function(){

												$(this).dialog('close');

												location.reload();

																	}
																}
																	});
		 									

		 			
		 		});

										  	}
										  }});


			});

		


			

	


	




	});

	</script >

</html>

<?php 
}
	
