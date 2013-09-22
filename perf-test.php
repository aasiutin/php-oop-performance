<?php

require_once('RemoteIP.php');

$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$iterationsNumber = 10000000;

$start = microtime(true);
for ($i = 0; $i < $iterationsNumber; $i++) {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
        $str_parts = explode(", ", $_SERVER['HTTP_FORWARDED']);
        $parts_num = count($str_parts);
        $str = $str_parts[$parts_num - 1];
        $str = substr($str, 5, -1);
        list($ip,) = explode(":", $str);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
}
$pureStatementsTime = microtime(true) - $start;

$start = microtime(true);
for ($i = 0; $i < $iterationsNumber; $i++) {
    $ip = getIP();
}
$functionTime = microtime(true) - $start;

$start = microtime(true);
for ($i = 0; $i < $iterationsNumber; $i++) {
    $ip = RemoteIP::get();
}
$staticMethodTime = microtime(true) - $start;

$remoteIP = new RemoteIP();
$start = microtime(true);
for ($i = 0; $i < $iterationsNumber; $i++) {
    $remoteIP = new RemoteIP();
    $ip = $remoteIP->getIP();
}
$objectMethodTime = microtime(true) - $start;


echo 'statements ', $pureStatementsTime, PHP_EOL;
echo 'function   ', $functionTime, PHP_EOL;
echo 'static m   ', $staticMethodTime, PHP_EOL;
echo 'object m   ', $objectMethodTime, PHP_EOL;

$purePercentage = 100;
$functionPercentage = number_format($functionTime/$pureStatementsTime*100, 2);
$staticMethodPercentage = number_format($staticMethodTime/$pureStatementsTime*100, 2);
$objectMethodPercentage = number_format($objectMethodTime/$pureStatementsTime*100, 2);

echo 'statements ', $purePercentage, '%', PHP_EOL;
echo 'function   ', $functionPercentage, '%', PHP_EOL;
echo 'static m   ', $staticMethodPercentage, '%', PHP_EOL;
echo 'object m   ', $objectMethodPercentage, '%', PHP_EOL;

function getIP() {
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_FORWARDED'])) {
        $str_parts = explode(", ", $_SERVER['HTTP_FORWARDED']);
        $parts_num = count($str_parts);
        $str = $str_parts[$parts_num - 1];
        $str = substr($str, 5, -1);
        list($ip,) = explode(":", $str);
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}