<?php

require_once __DIR__.'/lib.php';

// get - на список таблиц и на список полей в таблицах
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $tablist = prepareTable("Show tables");
    var_dump($tablist);

    $fldlist = prepareTable("Show tables");
}
