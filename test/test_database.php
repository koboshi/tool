<?php
namespace koboshi\test;

require __DIR__ . "/../src/koboshi/Tool/Database.php";

use koboshi\Tool\Database;

$db = new Database('127.0.0.1', 'root', '', 3306, 'plus');
$db->selectDatabase('forge');

//查询
$sql = "SELECT * FROM `all_electric_scid` WHERE scid < :scid LIMIT 5;";
$output = $db->query($sql, array(':scid' => '11275'));
var_dump($output);
var_dump($db->lastSql());

//查询1行
$sql = "SELECT * FROM `all_electric_scid` WHERE scid < :scid LIMIT 5;";
$output = $db->queryOne($sql, array(':scid' => '11275'));
var_dump($output);
var_dump($db->lastSql());

//更新
$data = array();
$data['author_name'] = 'koboshi';
$data['audio_name'] = 'misha';
$whereStr = "audio_out_id = 139774";
$rows = $db->update($data, $whereStr, 'out_163_light_search');
var_dump($rows);

//转义
$str = "mis'ha";
var_dump($db->escape($str));

//新增
$data = array();
$data['audio_out_id'] = 999999;
$data['author_name'] = 'koboshi1';
$data['audio_name'] = 'misha1';
$newId = $db->insert($data, 'out_163_light_search');
var_dump($newId);

//忽略新增
$data = array();
$data['audio_out_id'] = 999999;
$data['author_name'] = 'koboshi1';
$data['audio_name'] = 'misha1';
$newId = $db->ignore($data, 'out_163_light_search');
var_dump($newId);

//忽略新增
$data = array();
$data['audio_out_id'] = 999999;
$data['author_name'] = 'koboshi1';
$data['audio_name'] = 'misha1';
$newId = $db->replace($data, 'out_163_light_search');
var_dump($newId);

//事务
$db->begin();
//$db->begin();
$data = array();
$data['author_name'] = 'koboshi22';
$data['audio_name'] = 'misha22';
$whereStr = "audio_out_id = 999999";
$rows = $db->update($data, $whereStr, 'out_163_light_search');
var_dump($rows);
$db->rollback();

//自增id
$data = array();
$data['name'] = "mis'h大大挖a";
$newId = $db->insert($data, 'all_electric_scid');
var_dump($newId);