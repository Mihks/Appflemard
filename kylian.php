<!-- // 	<label>Gain agence</label><input type="text" value="300000" />
// 	<label>Com. Flemard</label><input type="text" value="100000" />
// 	<label>Gain Total</label><input type="text" value="400000" />
 -->
<?php

include_once('fonction.php');

$reponse = $bdd->query(" SELECT token FROM compte_marchand LIMIT 1 ");		
$donnees = $reponse->fetch();
$token = $donnees['token'];
$ref = uniqid();

$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/pvit-secure-full-api.kk");
curl_setopt($ch, CURLOPT_POSTFIELDS,
"tel_marchand=077565805
&montant=100
&ref=".$ref."&tel_client=074872120
&token=".$token."&action=2
&service=REST
&operateur=AM
&agent=caisse3");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resultat = curl_exec($ch);
