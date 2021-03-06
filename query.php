<?php

require_once __DIR__.'/lib.php';

// get - на список таблиц и на список полей в таблицах
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $result = getTables();
    echo $result;
}
elseif ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $query = '';
    /*
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    */
    if (! isset($_POST['typeQuery'])) {
        exit;
    }

    $typeQuery = $_POST['typeQuery'];
    switch ($typeQuery) {
        case 'create' : // создание таблицы:
            $pk = []; // массив pk
            $fldnames = []; // массив полей для защиты от дублей

            $query = "create table `{$_POST['tabname']}` ( ";
            foreach ($_POST['fldname'] as $key => $fldname) {
                // это скрытый шаблон строки, его пропускаем:
                if ( $key === 0 ) {
                    continue;
                }

                // проверка дублирующих полей:
                if (in_array($fldname, $fldnames)) {
                    continue;
                }
                $fldnames[] = $fldname;

                // генерация запроса на добавление таблицы:
                $fldname = trim($fldname);
                $query .= " `{$fldname}` {$_POST['fldtype'][$key]} ";
                if (isset($_POST['nn'][$key])) {
                    $query .= " NOT NULL ";
                }
                if (isset($_POST['pk'][$key])) {
                    $pk[] = "`$fldname`";
                }
                if (isset($_POST['default'][$key]) && $_POST['default'][$key] != '') {
                    $query .= " DEFAULT  {$_POST['default'][$key]} ";
                }
                if ($key + 1 < count($_POST['fldname'])) {
                    $query .= ',';
                }
            }
            $strpk = implode(', ', $pk);
            if (isset($strpk) && $strpk != '') {
                $query .=  " PRIMARY KEY ( $strpk )";
            }
            $query .= ') ENGINE=InnoDB DEFAULT CHARSET = utf8';
            break;
        case 'updatecol' : // изменение полей в таблице:
            $query = "ALTER TABLE {$_POST['tab']} CHANGE {$_POST['col']} {$_POST['newcol']} {$_POST['newtype']}";
            break;
        case 'dropcol' : // удаление поля в таблице:
            if (getCountCol($_POST['tab']) <= 1) {
                $query = "DROP TABLE {$_POST['tab']}";
            }
            else {
                $query = "ALTER TABLE {$_POST['tab']} DROP COLUMN {$_POST['col']}";
            }
            break;
    }
    $result = prepareTable($query, $typeQuery);
    echo "Запрос $query<br />";

    if (count($result) == 0 || ($result == '')) {
        echo "Результат: успешно";
    } else {
        echo "Результат: json_encode($result)";
    }

}