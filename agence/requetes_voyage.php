<?php

session_name('flemadmin');

session_start();


if (isset($_SESSION['agence']) && isset($_POST['trajet']) && isset($_POST['horaire'])) {



	include_once 'fonction.php';

	 



	$trajet = $_POST['trajet'];

	$horaire = $_POST['horaire'];





	


	$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");



		$rep =  $bdd->prepare("SELECT IF(reservation.type_reservation='Aller_simple','Unique','') AS type , reservation.statut_voyage_1 AS statut, CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.nombre_place AS place,reservation.trajet,client.id_client,reservation.id_reservation FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1 = 'Valide' AND reservation.etat_voyage_2 IS NULL AND reservation.heure_depart = ? AND reservation.date_depart = CURRENT_DATE AND reservation.trajet = ?

		UNION

		SELECT IF(reservation.type_reservation='Aller_retour','Aller','') AS type, reservation.statut_voyage_1 AS statut, CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.nombre_place AS place,reservation.trajet,client.id_client,reservation.id_reservation FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour'  AND reservation.etat_voyage_1 = 'Valide' AND reservation.heure_depart = ? AND reservation.date_depart = CURRENT_DATE AND reservation.trajet = ?

		UNION
		SELECT IF(reservation.type_reservation='Aller_retour','Retour','') AS type, reservation.statut_voyage_2 AS statut, CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.nombre_place AS place,reservation.trajet_retour,client.id_client,reservation.id_reservation FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.etat_voyage_2 ='Valide' AND reservation.type_reservation ='Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = CURRENT_DATE AND reservation.trajet_retour = ? ;
		 ");


		$rep->execute(array($_SESSION['agence'],$horaire,$trajet,$_SESSION['agence'],$horaire,$trajet,$_SESSION['agence'],$horaire,$trajet));

			echo "<table id='tab_voy'>

				

					<thead>
					<tr>
					<th>Enrégistrement</th>
					<th>Etat de voyage</th>
					<th>Identifiant</th>
					<th>Nom</th>
					<th>Contact</th>
					<th>Nombre de place</th>
					</tr></thead><tr>";
			
					// $_SESSION['id_client'] = array();
					// $_SESSION['id_reservation'] = array();
					// $_SESSION['nombre_place'] = array();

					while ($donnees = $rep->fetch()) {

						echo "<td><select   name='choix' id='".$donnees['id_reservation']."' class='".$donnees['type']."'>

						<option value='Effectue'>Effectué</option>
						<option value='Non-Effectue'>Non-Effectué</option>

							</select></td>";


							$color = ($donnees['statut']=='Non-Effectue') ? 'red' : 'green' ;

						echo "<td style='color:".$color.";font-weight:bolder;'>".$donnees['statut']."</td>"	

							."<td>".$donnees['id']."</td>"
							."<td>".$donnees['nom']."</td>"
							."<td>".$donnees['num_tel']."</td>"
							."<td>".$donnees['place']."</td>".'</tr>';

						// array_push($_SESSION['id_client'], $donnees['id_client']);
						// array_push($_SESSION['id_reservation'], $donnees['id_reservation']);
						// $_SESSION['heure'] = $donnees['heure'];

							 

						
					}



					echo "</table>";


					echo "<button id='sceller' style='position:absolute;top:116px;right:90px;' name='send' value='send'>Valider</button>";
					// echo "<span style='position:absolute;top:500px;right:200px;'><label>Tout cocher</label><input id='toutcocher'name='toutcocher' value='ton cul'  type='checkbox' /></span>";


}else{

	include_once 'fonction.php';

	demandeReconnexion();
}



					

?>

<div id="inserer" hidden>Voulez-vous <b>vraiment</b> effectuer cette Opération ? </div>


<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
		

	<script >
				
		$(function(){


		
			      	

			


			$("#sceller").on('click',function(){

				// event.preventDefault();


				var choix = new Array();

				var id_reservation = new Array();

				var type = new Array();


			    $("select[name='choix']").each(function(){

			      	choix.push(this.value);
			      	id_reservation.push(this.id);
			      	
			      	type.push($(this).attr('class'));

			      	});


				$("#inserer").dialog({      
						modal: true,title:'Confirmer',      
						buttons: {        
							"Oui": function() {      
								 
								$.post("statut_voyage.php",{choix:choix,id_reservation:id_reservation,type:type},

									function(data){

										$('#inserer').html(data);

										$('#inserer').dialog({modal:true,title:'Enrégistrement',buttons:{

											"Fermer": function(){

												location.reload();
											}
										}});

								}); 

								$(this).dialog("close");
								    
							},        
							"Non": function() {          
								$(this).dialog("close");     
							}   
						}    
					}); 




			



			});
			




		});


	</script>

