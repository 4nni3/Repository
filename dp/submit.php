<?php

//Sileo用 動作報告

$url = "https://docs.google.com/forms/u/1/d/e/1FAIpQLSchaB-HrJ0HYRuKROVKjkQjVAlNO6bSo8AmHikZz-2_MKXkvw/formResponse";

$p = $_GET['p'];
$pv = $_GET['v'];
$c = boolval($_GET['c'])?"動いた":"動かない";

$agent = strtolower(isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:"");
$ios = 0;
if(preg_match('/ip(hone|od|ad)/', $agent)){
  preg_match('/os (.+) like/', $agent,  $matches);
  $ios = floatval(str_replace('_', '.', $matches[1]));
}

$dat =[
    'entry.390043528'=>$p,
    'entry.1049998279'=>$pv,
    'entry.178135634'=>$ios,
    'entry.1748641038'=>$c,
    'entry.391198144'=>'From Sileo'
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dat);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_exec($ch);

curl_close($ch);

?>
<h1>Done! Thank you.</h1>
