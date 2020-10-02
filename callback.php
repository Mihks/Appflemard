<?php

session_name("flemard");

session_start();


if (!isset($_SESSION['ref_trans']) OR empty($_SESSION['ref_trans']) ) {
	
	header("Location: index.php");

	
	}else{

		
		include('agence/fonction.php');

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

 ?>


	
