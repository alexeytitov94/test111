<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

header("Content-Type: text/html; charset=utf-8");


const DB_HOST = '';
const DB_NAME = '';
const DB_USER = '';
const DB_PASS = '';

function sqlconnect() {
    $dbh = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Не могу соединиться с MySQL.");
    mysql_select_db(DB_NAME) or die("Не могу подключиться к базе.");
    return true;
}


function sqlselectSearch($str, $start, $next) {
    $query = "SELECT * FROM `test` WHERE PART_NUMBER LIKE '%$str%' LIMIT $start, $next";
    $res = mysql_query($query);
    //Запись выборки в массив
    $dbtasks = array();
    while($row = mysql_fetch_array($res))
    {
        array_push($dbtasks, array(
            'title' => $row['PART_NUMBER'],
            'count' => $row['COUNT'],
            'price' => $row['PRICE'],
            'date_post' => $row['DATE'],
        ));
    }

    return $dbtasks;
}

function sqlSelectAll($start, $next) {
    $query = "SELECT * FROM `test` LIMIT $start, $next";
    $res = mysql_query($query);
    //Запись выборки в массив
    $dbtasks = array();
    while($row = mysql_fetch_array($res))
    {
        array_push($dbtasks, array(
            'title' => $row['PART_NUMBER'],
            'count' => $row['COUNT'],
            'price' => $row['PRICE'],
            'date_post' => $row['DATE'],
        ));
    }

    return $dbtasks;
}


function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
    return true;
}