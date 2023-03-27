<?php 
$q = $_REQUEST["q"];
$url = "https://api.indexa.do/api/rnc?rnc=".$q;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "x-access-token: 35a139bf-f0d0-4ea0-adc6-0b7307a25da2",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
echo ($resp);
 
?>