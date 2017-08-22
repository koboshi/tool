<?php
namespace koboshi\test;

require __DIR__ . "/../src/koboshi/Tool/HttpClient.php";

use koboshi\Tool\HttpClient;

$httpClient = new HttpClient();
$content = $httpClient->request('https://www.jd.com/');
var_dump($content);
var_dump($httpClient->lastErrno);
var_dump($httpClient->lastHttpCode);