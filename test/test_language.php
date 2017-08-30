<?php
namespace koboshi\test;

require __DIR__ . "/../src/koboshi/Tool/Language.php";

use koboshi\Tool\Language;

$flag = Language::isChinese('低洼udhaowd');
var_dump($flag);

$flag = Language::isChinese('udhaowd');
var_dump($flag);

$flag = Language::isChinese('低洼udhaowd', true);
var_dump($flag);

$flag = Language::isChinese('低洼', true);
var_dump($flag);

$flag = Language::isJapanese('アルスラーン戦記dwaafe');
var_dump($flag);

$flag = Language::isJapanese('dfsdwa');
var_dump($flag);

$flag = Language::isJapanese('アルスラーン戦記2342dawd', true);
var_dump($flag);

$flag = Language::isJapanese('アルスラーン', true);
var_dump($flag);

$flag = Language::isKorean('地挖打我트럼프');
var_dump($flag);

$flag = Language::isKorean('大发达');
var_dump($flag);

$flag = Language::isKorean('地挖打我트럼프', true);
var_dump($flag);

$flag = Language::isKorean('트럼프', true);
var_dump($flag);

$pinyin = Language::zh2py('但据外电家啊');
var_dump($pinyin);

$pinyin = Language::zh2py('但据外电家啊', false);
var_dump($pinyin);

$pinyin = Language::zh2py('战记');
var_dump($pinyin);

$pinyin = Language::zh2py('戰記');
var_dump($pinyin);

$pinyin = Language::zh2py('战记', false);
var_dump($pinyin);

$pinyin = Language::zh2py('戰記', false);
var_dump($pinyin);

$res = Language::traditional2simplified('戰記');
var_dump(mb_convert_encoding($res, 'GBK', 'UTF-8'));

$res = Language::simplified2traditional('战记');
var_dump(mb_convert_encoding($res, 'GBK', 'UTF-8'));