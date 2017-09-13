<?php
namespace koboshi\test;

require __DIR__ . "/../src/koboshi/tool/HttpClient.php";

use koboshi\tool\HttpClient;

$httpClient = new HttpClient();
$content = $httpClient->request('https://www.jd.com/');
var_dump($content);
var_dump($httpClient->lastErrno);
var_dump($httpClient->lastHttpCode);