<?php
$limit = -1;
$str = "地挖打我（dwad大wa（dwad大wa打我打我）打我打我）d大王（dwad大wa打我打我）wadwadwar";
$str = preg_match_all("/（(.*)）/is", $str, $match);
var_dump($match);