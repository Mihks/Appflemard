<?php 

session_name('flemadmin');

session_start(); 


if(isset($_SESSION['region'])){


	if ($_SESSION['region']=='administrateur') {


		echo date('d/m/Y H:i:s').' Compte administrateur';
		
	} else {


		echo date('d/m/Y H:i:s').' . Agence de '.$_SESSION['region'];
		
	}
	

}else
	
	echo "...";



?>