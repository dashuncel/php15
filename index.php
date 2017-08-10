<?php
require_once __DIR__.'/lib.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Управление таблицами БД</title>
    <link rel="stylesheet" href="index.css">
    <meta charset="utf-8">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
</head>
<body>
<ul class="main">
    <li>
        <a href="#" class="mainMenu">Создание таблицы в БД</a>
        <section class="create">
            <form class="mainform" method="POST" enctype="application/x-www-form-urlencoded" action="query.php">
                <input type="hidden" name="typeQuery" value="create">
                <label>Наименование таблицы:<br /> <input type="text" name="tabname" value="table1"></label>
                <table>
                    <caption>Список полей:</caption>
                    <thead>
                        <tr>
                            <td>Наименование поля</td>
                            <td>Тип поля</td>
                            <td title="Входит в состав первичного ключа">PK</td>
                            <td title="Автоинкремент">AI</td>
                            <td title="Нулевые значения не допустимы">NN</td>
                            <td title="Значение по умолчанию">DEF</td>
                            <td class="addcol">
                                <a href="#">
                                    <img src="./img/plus.png" title="Добавить колонку">
                                </a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="template">
                            <td>
                                <input type="text" name="fldname[]" required value="field0">
                            </td>
                            <td>
                                <select name="fldtype[]">
                                    <option>INT</option>
                                    <option>VARCHAR</option>
                                    <option>DECIMAL</option>
                                    <option>DATETIME</option>
                                </select>
                            </td>
                            <td><input type="checkbox" name="pk[]"></td>
                            <td><input type="checkbox" name="ai[]"></td>
                            <td><input type="checkbox" name="nn[]"></td>
                            <td><input type="text" name="default[]"></td>
                            <td class="delcol">
                                <a href="#" class="delcol">
                                    <img src="./img/minus.png" title="Удалить колонку" class="delcol">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="submit" value="Создать таблицу" name="createsubmit">
            </form>
        </section>
    </li>
    <li>
        <a href="#" class="mainMenu">Список таблиц БД</a>
        <section class="list hidden">
            <ul class="tablist">

            </ul>
        </section>
    </li>
</ul>
<script>
    'use strict';
    let counter = 1; // счетчик добавленных полей
    $('.mainMenu').click(function(event) {
        $(this).next('section').toggleClass('hidden');
        if ($(this).hasClass('hidden')) {
            return;
        }
        switch ($(this).next('section').attr('class')) {
            case 'create':
                break;
            case 'list':
                $.get('query.php',
                    '', function (data_res, request) {
                        let strAdd = '';
                        $('.tablist').html('Таблицы базы данных ' + "<?php echo $database ?>");
                        let myData = JSON.parse(data_res);
                        myData.forEach(function (item) {
                            strAdd += `<li>${item.Tables_in_global}<table><tbody class=''>`;
                            myData.fld.forEach(function(item){
                                strAdd += $('.template').clone();
                            });
                            strAdd += '</tbody></table></li>';
                        });
                        $('.tablist').append(strAdd);
                    });
                break;
        }
    });

    // плюс - добваить колонку (строку в таблице)
    $('.addcol').click(function(event) {
        $('.template').clone().appendTo('tbody').removeClass('template').attr('id','tab1_' + counter);
        $('#tab1_' + counter + ' input[name^="fldname"]').attr('value', 'field' + counter);
        counter++;
    });

    // минус - удалить колонку (строку в таблице)
    $('tbody').click(function(event) {
        if (! $(event.target).hasClass('delcol')) {return; }
        $(event.target).parentsUntil('tbody').last().remove();
    });

</script>
</body>
</html>

