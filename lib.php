<?php

require_once 'mydata.php';

$host='localhost';
$dbport=3306;

$user=LOGIN;
$password=PASSWD;
$database=LOGIN;
/*
$user='root';
$password='';
$database='global';
*/
$errors=[];

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false
];

try
{
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password, $opt);
}
catch (PDOException $e)
{
    $errors[] = 'Ошибка подключения к БД: ' . $e->getMessage() . '<br/>';
}

function prepareTable($query, $typeQuery)
{
    global $pdo;

    try {
        $statement = $pdo->prepare($query);
        $statement->execute();
    } catch (PDOException $e) {
        $errors = "Ошибка отправки запроса '$query' к БД: " . $e->getMessage() . '<br/>';
        return $errors;
    }

    if ($typeQuery == 'select') {
        try {
            $rows = $statement->fetchAll();
        } catch (Exception $e) {
            $rows = $e;
        }
    }
    else {
        $rows = '';
    }

    return $rows;
}


function getCountCol($tab) {
    global $pdo;
    try {
        $statement = $pdo->prepare('Describe ' . $tab);
        $statement->execute();
    } catch (PDOException $e) {
        $errors = "Ошибка отправки запроса получения кол-ва полей к БД: " . $e->getMessage() . '<br/>';
        return $errors;
    }

    try {
        $rows = $statement->fetchAll();
        return (count($rows));
    } catch (Exception $e) {
        return 0;
    }
}

function getTables()
{
    global $database;
    $tablist = prepareTable("Show tables", 'select');
    foreach ($tablist as $key => $tab) {
        $tablist[$key]['fld'] = getFields($tab['Tables_in_' . $database]);
    }
    return json_encode($tablist);
}

function getFields($tab) {
    $result = prepareTable("Describe $tab", 'select');
    return $result;
}
