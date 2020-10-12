<?php

session_name("flemard");

session_start();

dl("php_gd2.dll");
// require('agence/fpdf/fpdf.php');

// require('agence/phpqrcode/qrlib.php');




// class PDF extends FPDF
// {



// // En-tête
// function Header()
// {
//     // Logo
//     $this->Image('images/yagaC.png',10,6,30);
//     // Police Arial gras 15
//     $this->SetFont('Arial','B',15);
//     // Décalage à droite
//     $this->Cell(60);
//     // Titre
//     $this->Cell(60,10,'Billet de Voyage',0,1,'C');
//     // Saut de ligne
//     $this->Ln(20);
// }

// // Pied de page
// function Footer()
// {
//     // Positionnement à 1,5 cm du bas
//     $this->SetY(-15);
//     // Police Arial italique 8
//     $this->SetFont('Arial','I',8);
//     // Numéro de page
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
// }

// // Tableau simple
// function BasicTable($tableau)
// {
//     // En-tête
//     foreach($tableau as $key=>$data){
//         $this->Cell(40);
//         $this->Cell(40,15,$key,0);
//         $this->Cell(10);
//         $this->Cell(40,15,$data,0,1);

//         }
    
// }


// function Img($source)
// {

//      $this->Image('dest.png');
  
// }


// }



include_once 'fonction.php';

$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");

if (isset($_SESSION['type']) AND isset($_SESSION['ref_trans']) ) {


    if ($_SESSION['type']=='Aller_simple') {


        $reponse =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation,reservation.nombre_place,reservation.trajet,DATE_FORMAT(reservation.date_depart, '%W, %e %M %Y') AS depart,reservation.heure_depart,CONCAT(paiement.montant_debite,'FCFA') AS montant,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.nom_agence,paiement.ref_trans AS ref FROM client,paiement,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND client.id_client = transaction.id_client AND paiement.ref_trans = ? ; ");

            $reponse->execute(array($_SESSION['ref_trans']));

            $donnees = $reponse->fetch();

            $nom_agence = $donnees['nom_agence'];

            $id = $donnees['id'];

            $depart = $donnees['depart'];

            $heure = $donnees['heure_depart'];

            $trajet = $donnees['trajet'];

            $ref = $donnees['ref'];

            $type = $donnees['type_reservation'];

            $date_reserve = $donnees['date_reserve'];

            $reponse->closeCursor();
            
            // QRcode::png($id,'codeqr.png','M',4,2);
           
             $destination = imagecreatefrompng("copie.png"); 

             // if (!file_exists("codeqr.png")){
             //       echo '<h2>Erreur création du fichier QRcode</h2>';
             //        exit; // pas les droits en écriture ?
             //        }

            // $source = imagecreatefrompng('codeqr.png');

//             $noir = imagecolorallocate($destination, 0, 0, 0);
    
//             $red = imagecolorallocate($destination, 128, 0, 0);

           // imagestring($source, 4, 0, 0, $lien, $noir);

//             imagestring($destination, 4, 210, 86, $nom_agence, $noir); // Agence

//             imagestring($destination, 4, 510, 85, $id, $red); // ID Unique

//             imagestring($destination, 4, 215, 144,$depart , $noir); // Date voyage

//             imagestring($destination, 4, 215, 179, $heure, $noir); // heure

//             imagestring($destination, 4, 215, 209,$trajet, $noir); // Trajet

//             imagestring($destination, 4, 245, 243, $ref, $noir); // ref trans

//             imagestring($destination, 4, 545, 300, $type, $noir); // type reservation

             // imagecopymerge($destination,$source, 540, 152, 0, 0, 100, 100, 60); //PERMET DE FUSIONER LES IMAGES

             // Affichage et libération de la mémoire
              header('Content-Type: image/png');
	           
  	       imagepng($destination);
		//   imagedestroy($destination);

            // if (!file_exists("dest.png")){

            //     echo '<h2>Erreur création du billet</h2>';
            //     exit; // pas les droits en écriture ?
            //         }

                    // imagedestroy($destination);
                    // imagedestroy($source);

              
        

     } //else{







    //      $reponse =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation,CONCAT_WS(' ',reservation.nombre_place,'place(s) par voyage') AS nbre_place,reservation.trajet,reservation.trajet_retour,DATE_FORMAT(reservation.date_retour, '%W, %e %M %Y') AS retour,DATE_FORMAT(reservation.date_depart, '%W, %e %M %Y') AS depart,reservation.heure_depart,reservation.heure_retour,CONCAT(paiement.montant_debite,'FCFA') AS montant,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.nom_agence,paiement.ref_trans AS ref FROM client,paiement,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND client.id_client = transaction.id_client AND paiement.ref_trans = ? ; ");

    //     $reponse->execute(array($_SESSION['ref_trans']));

    //     $donnees=$reponse->fetch();

    //         $nom_agence = $donnees['nom_agence'];

    //         $id = $donnees['id'];

    //         $depart = $donnees['depart'];

    //         $retour = $donnees['retour'];

    //         $heure = $donnees['heure_depart'];

    //         $heure_retour = $donnees['heure_retour'];

    //         $trajet = $donnees['trajet'];

    //         $trajet_retour = $donnees['trajet_retour'];

    //         $ref = $donnees['ref'];

    //         $type = $donnees['type_reservation'];

    //         $date_reserve = $donnees['date_reserve'];

    //         $reponse->closeCursor();
            

    //         QRcode::png($id,'codeqr.png','M',4,2);

           
    //         $destination = imagecreatefrompng("billet_retour.png"); 

    //          if (!file_exists("codeqr.png")){
    //                echo '<h2>Erreur création du fichier QRcode</h2>';
    //                 exit; // pas les droits en écriture ?
    //                 }

    //         $source = imagecreatefrompng('codeqr.png');

    //         $noir = imagecolorallocate($destination, 0, 0, 0);

    //         $red = imagecolorallocate($destination, 128, 0, 0);


    //        // imagestring($source, 4, 0, 0, $lien, $noir);

    //         imagestring($destination, 4, 210, 86, $nom_agence, $noir); // Agence

    //         imagestring($destination, 4, 515, 85, $id, $red); // ID Unique

    //         imagestring($destination, 4, 215, 125, $depart.' A', $noir); // Date voyage

    //         imagestring($destination, 4, 215, 144, $retour.' R', $noir); // Date voyage


    //         imagestring($destination, 4, 210, 179, $heure.' A /'.$heure_retour.' R', $noir); // heure

    //         imagestring($destination, 4, 215, 209, $trajet.' A', $noir); // Trajet

    //         imagestring($destination, 4, 215, 230, $trajet_retour.' R', $noir); // Trajet

    //         imagestring($destination, 4, 245, 255, $ref, $noir); // ref trans

    //         imagestring($destination, 4, 545, 300, $type, $noir); // type reservation


    //         imagecopymerge($destination,$source, 540, 152, 0, 0, 100, 100, 60); //PERMET DE FUSIONER LES IMAGES

    //          // Affichage et libération de la mémoire
    //                 // header('Content-Type: image/png');
    //                 imagepng($destination,'dest.png');


    //                   if (!file_exists("dest.png")){
    //                         echo '<h2>Erreur création du billet</h2>';
    //                         exit; // pas les droits en écriture ?
    //                 }

    //                 imagedestroy($destination);
    //                 imagedestroy($source);



            

    // }





// $pdf = new PDF();


// $pdf->SetFont('Arial','',14);
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->Cell(120);
// // $pdf->Cell(60,10,'Agence : '.$nom_agence,0,1,'C');
// $pdf->Ln();
// $pdf->Cell(35);
// $pdf->Cell(130,10,'Date de reservation: '.$date_reserve,1,1,'C');
// $pdf->Ln(10);
// $pdf->Img('dest.png');
// $pdf->Output();

  

}else{

    header('Location:index.php');
}
