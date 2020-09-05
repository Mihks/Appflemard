<?php


session_name('flemadmin');

session_start();

 
header('Content-Type: text/html; charset=utf-8');


if (isset($_SESSION['agence']) && is_string($_POST['trajetStat']) && isset($_POST['trajetStat']) && isset($_POST['anneeStat']) ) {
	

$_POST['trajetStat'] = ($_POST['trajetStat']=='') ? 'trajet_confondu' : $_POST['trajetStat'] ;


	include_once 'fonction.php';


$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");


		// $rep =  $bdd->query("SELECT AVG(reservation.nombre_place) AS nbre,count(*) AS nbre_reservation, SUM(reservation.nombre_place) AS sum FROM reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND transaction.statut ='Succes' AND reservation.nom_agence= '".$_SESSION['agence']."' ");

		

		// echo "<h1 style='text-align:center;'>Les Differents Statistiques</h1>";

		// echo "<h3 style='margin:10px;float:right'>Les Differents Statistiques</h3>";

		// echo "<h3 style='text-align:left;margin:10px;'>Les Differents Statistiques</h3>";

		
		// while ( $donnee = $rep->fetch()) {
			
		// 	echo "En moyenne le  nombre de place vendu est de ".number_format($donnee['nbre'],2,',',' ').'<br/>';
		// 	echo "le nombre de reservation  ".$donnee['nbre_reservation'].'<br/>';
		// 	echo "le nombre de place reservees  ".$donnee['sum'];
		// }

		

		if (preg_match('#^trajet_confondu$#', $_POST['trajetStat'])) {



		$rep =  $bdd->prepare("SELECT UPPER(DATE_FORMAT(paiement.date_paiement, '%M')) AS MOIS,SUM(paiement.montant_debite) AS recette, IF(reservation.type_reservation = 'Aller_simple',SUM(reservation.nombre_place),SUM(reservation.nombre_place)*2) AS sum,COUNT(*) AS nbre_reservation,AVG(reservation.nombre_place) AS moyenne FROM reservation,transaction,paiement WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND transaction.statut ='Succes' AND reservation.nom_agence= ? AND DATE_FORMAT(paiement.date_paiement, '%Y') = ? GROUP BY MOIS ORDER BY MOIS ");

			$rep->execute(array($_SESSION['agence'],$_POST['anneeStat']));
			
		}else{


			$rep =  $bdd->prepare("SELECT UPPER(DATE_FORMAT(paiement.date_paiement, '%M')) AS MOIS,SUM(paiement.montant_debite) AS recette, IF(reservation.type_reservation = 'Aller_simple',SUM(reservation.nombre_place),SUM(reservation.nombre_place)*2) AS sum, COUNT(*) AS nbre_reservation,AVG(reservation.nombre_place) AS moyenne FROM reservation,transaction,paiement WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND transaction.statut ='Succes' AND reservation.nom_agence= ? AND reservation.trajet = ? AND  DATE_FORMAT(paiement.date_paiement, '%Y') = ? GROUP BY MOIS ORDER BY CONCAT('JANVIER','FÉVRIER','MARS','AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOÛT', 'SEPTEMBRE','OCTOBRE', 'NOVEMBRE', 'DÉCEMBRE') ");

			$rep->execute(array($_SESSION['agence'],$_POST['trajetStat'],$_POST['anneeStat']));

		}



	echo "<br/><div id='tabstat'  align='center' style='margin:5px;'><caption ><b>Recette mensuelle de l'année ".$_POST['anneeStat']."</b> (".$_POST['trajetStat'].")</caption>

			<table class='table_gest_place' align='center'>
				<thead>
					<tr>
					<th>Mois</th>
					<th>Nombre de réservation</th>
					<th>Nombre de place vendu</th>
					<th>Recette (XAF)</th>
					<th>Moyenne</th></tr>
			 </thead><tr>";


		

		try
		{
			
		$recette = array();
		$sum = array();
		$nbre_reservation = array();
		$moyenne = array();

		$mois = array(); 

		while ($donnees = $rep->fetch()) {
			
			echo "<td>".$donnees['MOIS']."</td>"
				."<td>".$donnees['nbre_reservation']."</td>"
				 ."<td>".$donnees['sum']."</td>"				 
				 ."<td>".$donnees['recette']."</td>"
				  ."<td>".number_format($donnees['moyenne'],2,',',' ')."</td></tr>";

			array_push($recette,( $donnees['sum']=='') ? 0 : $donnees['recette']);

			array_push($sum,( $donnees['sum']=='') ? 0 : $donnees['sum']);

			array_push($nbre_reservation,($donnees['nbre_reservation']=='') ? 0 : $donnees['nbre_reservation']);

			array_push($moyenne,($donnees['moyenne']=='') ? 0 : $donnees['moyenne']);

			array_push($mois, ($donnees['MOIS']=='')? 0 : $donnees['MOIS']);
		}

		echo "<tfoot>
					<tr>
					<td style='color:skyblue;'>Total :</td>
					<td>".array_sum($nbre_reservation)."</td>
					<td>".array_sum($sum)."</td>
					<td>".array_sum($recette)."</td>";
				
				if (count($mois)==0) { throw new Exception(" ", 1); }
				
				else {echo "<td>".number_format(array_sum($moyenne)/count($mois),2,',',' ')."</td></tr>
			 </tfoot></table></div>";}


		
		}
	catch (Exception $e)
		{
			die(' ' . $e->getMessage());

		}





}else{

	
	if (!isset($_SESSION['agence'])) {echo 'Veuillez-vous reconnecter !'; }

	echo " Erreur !";
}