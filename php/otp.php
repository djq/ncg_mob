<?php

error_reporting(E_ALL);

$url = 'http://www.cityscale.ie/otp/opentripplanner-webapp/index.html#/submit&fromPlace=53.353116,-6.70&toPlace=53.341132,-6.260531&mode=TRANSIT,WALK&time=4:09pm&date=12/18/2012';

/*
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL,$url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch,CURLOPT_POST,count($fields));
//curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

$response = curl_exec ($curl);
curl_close ($curl);
echo $response;
$rxml = simplexml_load_string($response);
echo $rxml->title; */

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);

curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

$data=curl_exec($ch);
echo $data;
curl_close($ch);

?>