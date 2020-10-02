<?php


session_name("flemard");

session_start();

include_once 'fonction.php';

		
$code_statut = 200;

$_SESSION['code_statut'] = $code_statut;

$tel = '074'.mt_rand(200040,241743);


 $statut = ($code_statut==200) ? "Succes" : "Echoue" ;

		
$req = $bdd->prepare('UPDATE paiement SET code_statut = ? WHERE ref_trans = ? ');
									
$req->execute(array($code_statut,$_SESSION['ref_trans']));

// $req2 = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? ');
									
// $req2->execute(array($statut,$_SESSION['ref_trans']));

// $req3 = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

// $req3->execute(array($tel,$_SESSION['id_client']));


header("Location: resultat_transaction.php");
