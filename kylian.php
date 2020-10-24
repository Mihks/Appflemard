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

$pvitCurl = '$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/pvit-secure-full-api.kk");
curl_setopt($ch, CURLOPT_POSTFIELDS,
"tel_marchand=077565805
&montant=100
&ref='.$ref.'&tel_client=074872120
&token='.$token.'&action=2
&service=REST
&operateur=AM
&agent=caisse3");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resultat = curl_exec($ch)';


// echo(phpinfo());

// echo('<!DOCTYPE html>

// <html>
// <head>
// 	<title>Redistribution</title>
// </head>
// <body>


// <div>
// 	<h1>Redistribution</h1>
// </div>

// <div>

// <form id="pvitform" method="POST" action="https://mypvit.com/pvit-secure-full-api.kk" >

// Tel Marchand
// <select name="tel_marchand" >
//  		<option value="077565805">Airtel Money</option>
//  		<option value="062691284">Mobi Cash</option>
//  	</select>
	
// 	Montant
// 	<input type="text" name="montant" value="100" />	
	
// 	<input type="hidden" name="ref" value="'.$ref.'" />
	
// 	<input type="hidden" name="action" value="2" />
	
// 	<input type="hidden" name="service" value="REST" />
	
// 	Agence
// 	<select name="tel_client" >
//  		<option value="074872120">Mihky</option>
//  	</select>
	
// 	Operateur
// 	<select>
// 		<option value="AM">Airtel Money</option>
//  		<option value="MC">Mobi Cash</option>
//  	</select>

//  <input type="hidden" name="token" value="'.$donnees['token'].'" />	
//  	<input type="submit" value="payer" />	
//  </form>
// </div></body>
// </html>
// ');
