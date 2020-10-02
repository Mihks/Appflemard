<?php
$ch = curl_init('https://webtopdf.expeditedaddons.com/?api_key='.getenv('WEBTOPDF_API_KEY').'&content=http%3A%2F%2Fwww.wikipedia.org&html_width=1024&margin=10&title=My+PDF+Title');
$response = curl_exec($ch);
curl_close($ch);
var_dump($response);
?>
