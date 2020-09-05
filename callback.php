

	
<?php
session_name("flemard");

session_start();


// $data_received = file_get_contents("php://input");  

// $data_received_xml = new SimpleXMLElement($data_received);  

// $ligne_response = $data_received_xml[0];  

// $interface_received = $ligne_response->INTERFACEID; 

// $reference_received = $ligne_response->REF; 

// $type_received = $ligne_response->TYPE; 

// $statut_received = $ligne_response->STATUT;

// $operateur_received = $ligne_response->OPERATEUR; 

// $client_received = $ligne_response->TEL_CLIENT; 

// $message_received = $ligne_response->MESSAGE;  

// $token_received = $ligne_response->TOKEN; 

// $agent_received = $ligne_response->AGENT;

	

// UPDATE ma_table set statut = $statut_received where ref_paiement=$reference_received



if (!isset($_SESSION['ref_trans']) AND empty($_SESSION['ref_trans']) ) {
	
	header("Location: index.php");


	}else{


		include_once 'fonction.php';




		


		$code_statut = 200;//mt_rand(199,200);

		$_SESSION['code_statut'] = $code_statut;

		$tel = '074'.mt_rand(200040,241743);


		$statut = ($code_statut==200) ? "Succes" : "Echoue" ;

		if ($code_statut==200) { // $statut_received

			$message = 'Paiement effectué avec succès';
			
			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?, montant_debite = ? , message = ? WHERE ref_trans = ? ');									
			$req->execute(array($code_statut,$_SESSION['montant'],$message,$_SESSION['ref_trans'])); // $message_received $statut_received $reference_received

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? '); 
									
			$req2->execute(array($statut,$_SESSION['ref_trans'])); //  $reference_received

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($tel,$_SESSION['id_client'])); // $client_received


			// $reponse = $bdd->prepare(" UPDATE compte_marchand SET token = ? WHERE id_operateur = ? "); 
							
			// $reponse->execute(array($token_received,$operateur_received));

		} else {


			if ( $code_statut==0 ) {
				
				$message = 'Echec d’initialisation de la transaction';
			
			}


			if ($code_statut==001) {
				
				$message = "Paramètres incorrectes";
			}
			

			if ($code_statut==002) {
				

				$message = 'Erreur montant';

			}



			if ($code_statut==003) {
				
				$message = 'Marchand inconnu';

			}

			if ($code_statut==004) {
				
				$message = 'Erreur de barème des commissions';

			}


			if ($code_statut==005) {
				
				$message = 'Le marchand a une tache en cours';

			}


			if ($code_statut==006) {
				
				$message = 'Erreur N° Téléphone du client ';

			}


			if ($code_statut==007) {
				
				$message = 'Erreur Token, Token invalide ';

			}


			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?,montant_debite = ?, message = ? WHERE ref_trans = ? ');
									
			$req->execute(array($code_statut,$_SESSION['montant'],$message,$_SESSION['ref_trans']));

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ? WHERE ref_trans = ? ');
									
			$req2->execute(array($statut,$_SESSION['ref_trans']));

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($tel,$_SESSION['id_client']));
			

			
		}


		header("Location: resultat_transaction.php");

	}

 


	
