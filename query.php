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
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    if (! isset($_POST['typeQuery'])) {
        exit;
    }

    $typeQuery = $_POST['typeQuery'];
    switch ($typeQuery) {
        case 'create' : // создание таблицы:
            $pk = []; // массив pk
            $fldnames = []; // массив полей для защиты от дублей

            $query = "create table `{$_POST['tabname']} `";
            foreach ($_POST['fldname'] as $key => $fldname) {
                // это скрытый шаблон строки, его пропускаем:
                if ( $key === 0 ) { continue; }

                // проверка дублирующих полей:
                

                $query .= " `{$fldname}` ` {$_POST['fldtype'][$key]}` ";
                if (isset($_POST['nn'][$key])) {
                    $query .= " NOT NULL ";
                }
                if (isset($_POST['pk'][$key])) {
                    $pk[] = "`$fldname`";
                }
                if (isset($_POST['default'][$key])) {
                    $query .= " DEFAULT  {$_POST['default'][$key]} ";
                }
                $query .= ',';
            }
            $strpk = implode(', ', $pk);
            if (isset($strpk)) {
                $query .=  " PRIMARY KEY ( $strpk ), ";
            }
            $query .= ' ENGINE=InnoDB DEFAULT CHARSET = utf8';
            break;
        case 'update' : // изменение полей в таблице:
            $query = "alert table `{$_POST['tabname']}`";
            break;
    }

    echo $query;
    $result = prepareTable($query);
}