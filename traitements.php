<?php

//envoies les infos API mypivit


	$ch = curl_init(); 

	curl_setopt($ch, CURLOPT_POST, 1); 

	curl_setopt($ch, CURLOPT_URL,"https://mypvit.com/pvit-secure-full-api.kk"); 
	 
	curl_setopt($ch, CURLOPT_POSTFIELDS, 

		"tel_marchand=077565805 

		&montant=150 

		&ref=ABUA2X 

		&tel_client=074897117  

		&token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.YXNoaHFjNWIyMy9PU0VrYVNteU9LcklLZy9iVVZzK2MzdWNJUzJWSXBlUlJYUXZUKzJDZXdDYW1xcjFzd2NLZ2lBUEdVaGQ3QnloWGpwSmUrbEdxYXVHbGdSMzhPd2VXcUhWMkVHQms1SEZJaGxISmNzdzZKc2wvcnhXV0ZuNjRESUQzRDZQeS9KeDExanVQbU94Y2k1YXREMll3anRGY0I3dzZrWTU2ZXdtMHQ5ZDlaUkh6YzJwTmxxeVVYQ25COjpkaUxJamJqblJPcnNHVDF3NXRWREJRPT0=.sZD+zA3UISSpy/DwVWOT8clUM2G5vOuVPbScD6s/skA=

		&action=1 

		&service=WEB 

		&operateur=AM

		&redirect=https://flemardapp.herokuapp.com/resultat_transaction.php 

		&agent=caisse3"); 

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

	$resultat = curl_exec($ch);

	curl_close($ch);
