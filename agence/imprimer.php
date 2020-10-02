<?php
header('Content-Type: text/html; charset=utf-8');
$src = 'https://www.flemard.ga';
$ch = curl_init('https://webtopdf.expeditedaddons.com?api_key='.getenv('WEBTOPDF_API_KEY').'&content='.$src.'&html_width=1024&margin=10&title=klein_mihks');
$response = curl_exec($ch);
curl_close($ch);
var_dump($response);
?>
