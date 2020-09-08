

	
<?php
session_name("flemard");

session_start();
include_once 'fonction.php';


$data_received = file_get_contents("php://input");  

$data_received_xml = new SimpleXMLElement($data_received);  

$ligne_response = $data_received_xml[0];  

$interface_received = $ligne_response->INTERFACEID; 

$reference_received = $ligne_response->REF; 

$type_received = $ligne_response->TYPE; 

$statut_received = $ligne_response->STATUT;

$operateur_received = $ligne_response->OPERATEUR; 

$client_received = $ligne_response->TEL_CLIENT; 

$message_received = $ligne_response->MESSAGE;  

$token_received = $ligne_response->TOKEN; 

$agent_received = $ligne_response->AGENT;

	

// UPDATE ma_table set statut = $statut_received where ref_paiement=$reference_received



if (isset($reference_received) AND !empty($reference_received) ) {


		//$code_statut = 200;//mt_rand(199,200);

		//$_SESSION['code_statut'] = $code_statut;

		//$tel = '074'.mt_rand(200040,241743);


		$statut = ($code_statut==200) ? "Succes" : "Echoue" ;

		if ($statut_received==200) { // $statut_received

			
			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?, montant_debite = ? , message = ? WHERE ref_trans = ? ');									
			$req->execute(array($statut_received,$_SESSION['montant'],$message_received,$reference_received)); // $message_received $statut_received $reference_received

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? '); 
									
			$req2->execute(array($statut,$reference_received)); //  $reference_received

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($client_received,$_SESSION['id_client'])); // $client_received


			$reponse = $bdd->prepare(" UPDATE compte_marchand SET token = ? WHERE id_operateur = ? "); 
							
			$reponse->execute(array($token_received,$operateur_received));

		} else {


			
			$req = $bdd->prepare('UPDATE paiement SET code_statut = ?,montant_debite = ?, message = ? WHERE ref_trans = ? ');
									
			$req->execute(array($statut_received,$_SESSION['montant'],$message_received,$reference_received));

			$req2 = $bdd->prepare('UPDATE transaction SET statut = ? WHERE ref_trans = ? ');
									
			$req2->execute(array($statut,$reference_received));

			$req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

			$req3->execute(array($client_received,$_SESSION['id_client']));
			

			
		}


		
	}

 


	
