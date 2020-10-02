<?php

$ch = curl_init('https://webtopdf.expeditedaddons.com/?api_key=56K8R0XSWEJD85VF2YZMO27G0C3Q9N37PABTI1H6L491U4&content=http://www.wikipedia.org&margin=10&html_width=1024&title=My PDF Title');

$response = curl_exec($ch);
curl_close($ch);

