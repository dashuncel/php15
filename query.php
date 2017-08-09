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
    var_dump($_POST);
    switch ($_POST['type']) {
        case 'create' :
            break;
        case 'getinfo' :

            break;
    }
}