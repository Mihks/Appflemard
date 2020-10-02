

	
<?php
session_name("flemard");

session_start();

include_once('fonction.php');
// $data_received=file_get_contents("php://input");  
	// $data_received_xml= new SimpleXMLElement($data_received);  
	// $ligne_response=$data_received_xml[0];  
	// $reference_received=$ligne_response->REF; 
	// $statut_received=$ligne_response->STATUT;  
	// $num_client=$ligne_response->TEL_CLIENT


	// UPDATE ma_table set statut = $statut_received where ref_paiement=$reference_received



if (!isset($_SESSION['ref_trans']) AND empty($_SESSION['ref_trans']) ) {
	
	header("Location: index.php");


	}else{


		$code_statut = 200;//mt_rand(199,200);

		$_SESSION['code_statut'] = $code_statut;

		$tel = '074'.mt_rand(200040,241743);


		$statut = ($code_statut==200) ? "Succes" : "Echoue" ;

		if ($code_statut==200) {
			
			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?,net = ? WHERE ref_trans = ? ');
									
			$req->execute(array($code_statut,$_SESSION['montant'],$_SESSION['ref_trans']));

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? ');
									
			$req2->execute(array($statut,$_SESSION['ref_trans']));

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($tel,$_SESSION['id_client']));


		} else {
			
			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?,net = ? WHERE ref_trans = ? ');
									
			$req->execute(array($code_statut,$_SESSION['montant'],$_SESSION['ref_trans']));

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ? WHERE ref_trans = ? ');
									
			$req2->execute(array($statut,$_SESSION['ref_trans']));

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($tel,$_SESSION['id_client']));
			

			
		}


		header("Location: resultat_transaction.php");

	}

 


	
