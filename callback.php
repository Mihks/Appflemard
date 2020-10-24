<?php
$data_received = file_get_contents("php://input");
$data = explode('&',$data_received);

$ref_received = explode('=',$data[0]);
$reference_received = $ref_received[1];

$stat_received = explode('=',$data[1]);
$statut_received = $stat_received[1];


// $data_received=file_get_contents("php://input");
// $data_received_xml=new SimpleXMLElement($data_received);
// $ligne_response=$data_received_xml[0];
// $interface_received=$ligne_response->INTERFACEID;
// $reference_received=$ligne_response->REF;
// $type_received=$ligne_response->TYPE;
// $statut_received=$ligne_response->STATUT;
// $operateur_received=$ligne_response->OPERATEUR;
// $client_received=$ligne_response->TEL_CLIENT;
// $message_received=$ligne_response->MESSAGE;
// $token_received=$ligne_response->TOKEN;
// $agent_received=$ligne_response->AGENT;

