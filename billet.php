<?php 
session_name("flemard");
session_start();
include_once('fonction.php');

include_once('agence/phpqrcode/qrlib.php');

header ("Content-type: image/jpeg");

$reference_received = $_SESSION['ref'];

if(isset($reference_received ) && !empty($reference_received ) ){


$destination = imagecreatefromjpeg("agence/images/billet.jpg");
	
	
 $reponse =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation,reservation.nombre_place,reservation.trajet,DATE_FORMAT(reservation.date_depart, '%W, %e %M %Y') AS depart,reservation.heure_depart,CONCAT(paiement.montant_debite,'FCFA') AS montant,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.nom_agence,paiement.ref_trans AS ref FROM client,paiement,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND client.id_client = transaction.id_client AND paiement.ref_trans = ?");

            $reponse->execute(array($reference_received));

            $donnees = $reponse->fetch();

            $nom_agence = $donnees['nom_agence'];

            $id = $donnees['id'];

            $depart = $donnees['depart'];

            $heure = $donnees['heure_depart'];

            $trajet = $donnees['trajet'];

            $ref = $donnees['ref'];
	
	    $nom = $donnees['nom'];

            $type = $donnees['type_reservation'];

            $date_reserve = $donnees['date_reserve'];

            $reponse->closeCursor();



QRcode::png($id,'codeqr.png','M',4,2);

$noir = imagecolorallocate($destination, 0, 0, 0);
    
$red = imagecolorallocate($destination, 128, 0, 0);

            



 if (!file_exists("codeqr.png")){
                   echo '<h2>Erreur création du fichier QRcode</h2>';
                    exit; // pas les droits en écriture ?
                    }


 $source = imagecreatefrompng('codeqr.png');

 imagestring($destination, 4, 210,31,$nom_agence, $noir); // Agence

 imagestring($destination, 4, 510, 31,$id, $red); // ID Unique

 imagestring($destination, 4, 215, 123,$depart, $noir); // Date voyage

  imagestring($destination, 4, 215, 155,$heure, $noir); // heure

    imagestring($destination, 4, 215, 188,$trajet, $noir); // Trajet
        
    imagestring($destination, 4, 245, 221,$reference_received, $noir); // ref trans

     imagestring($destination, 4, 510, 350,$type, $noir); // type reservation

     imagestring($destination, 4, 195, 350,$nom, $noir); // nom


 imagecopymerge($destination,$source, 900, 152, 0, 0, 100, 100, 60); //PERMET DE FUSIONER LES IMAGES



imagejpeg($destination);

}
