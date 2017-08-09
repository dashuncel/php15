<?php

require_once __DIR__.'/lib.php';

// get - на список таблиц и на список полей в таблицах
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $tablist = json_encode(prepareTable("Show tables"));
    echo $tablist;
}
elseif ($_SERVER["REQUEST_METHOD"] == 'POST') {
    var_dump($_POST);
}