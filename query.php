<?php

require_once __DIR__.'/lib.php';

// get - на список таблиц и на список полей в таблицах
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $tablist = prepareTable("Show tables");
    $tabcopy = $tablist;
    foreach ($tablist as $key => $tab) {
        $tabcopy[$key]['fld'] = prepareTable("Describe {$tab['Tables_in_global']}");
    }
    $result = json_encode($tabcopy);
    echo $result;
}
elseif ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $query = '';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    if (! isset($_POST['typeQuery'])) {
        exit;
    }

    $typeQuery = $_POST['typeQuery'];
    switch ($typeQuery) {
        case 'create' :
            $query = "create table `{$_POST['tabname']}`";
            /*foreach () {

            }*/
            break;
        case 'update' :
            $query = "alert table `{$_POST['tabname']}`";
            break;
    }
}