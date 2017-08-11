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
                                    <option>INT(11)</option>
                                    <option>VARCHAR(20)</option>
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
                <input type="submit" value="Создать таблицу" name="createsubmit" disabled>
            </form>
        </section>
    </li>
    <li>
        <a href="#" class="mainMenu">Список таблиц БД</a>
        <div class="hidden chgecol_form" id="editcol">
            <form class="subform" method="POST" enctype="application/x-www-form-urlencoded" action="query.php">
                <fieldset>
                    <legend>Редактирование элемента</legend>
                    <label>Название<input type="text" id="newcol" name="newcol" required></label><br/>
                    <label>Тип
                        <select id="newtype" name="newtype" required>
                        <option>INT(1)</option>
                        <option>VARCHAR(40)</option>
                        <option>DECIMAL</option>
                        <option>DATETIME</option>
                        </select>
                    </label><br/>
                    <input type="submit" value="Сохранить изменения" name="changesubmit">
                </fieldset>
            </form>
        </div>
        <section class="list hidden">
            <ul class="tablist">

            </ul>
        </section>
    </li>
    <li>
        <a href="#" class="mainMenu">Результат работы</a>
        <section class="result">
            <output></output>
        </section>
    </li>
</ul>

<script>
    'use strict';
    let counter = 1; // счетчик добавленных полей
    let tabname;
    let colname;

    chkButton();
    $('.mainMenu').click(function(event) {
        $(this).nextAll('section').toggleClass('hidden');
        if ($(this).hasClass('hidden')) {
            return;
        }
        switch ($(this).nextAll('section').attr('class')) {
            case 'create':
                break;
            case 'list':
                getTableList();
                break;
        };
    });

    // плюс - добваить колонку (строку в новой таблице)
    $('.addcol').click(function(event) {
        $('.template').clone().appendTo('tbody').removeClass('template').attr('id','tab1_' + counter);
        $('#tab1_' + counter + ' input[name^="fldname"]').attr('value', 'field' + counter);
        counter++;
        chkButton();
    });

   // минус - удалить колонку (строку в новой таблице )
    $('tbody').click(function(event) {
        if (! $(event.target).hasClass('delcol')) {return; }
        $(event.target).parentsUntil('tbody').last().remove();
         chkButton();
    });

    $('input[name=createsubmit]').click(function(event) {
        event.preventDefault();
        $.post("query.php",
            $('.mainform').serialize(),
            function (data, result) {
                $('output').html(data);
                $('section.result').removeClass('hidden');
                $('section.list').addClass('hidden');
            });
    });

    //состояние кнопки ДОбавить таблицу:
    function chkButton() {
        if ($('tbody').children('tr').length <= 1) {
            $('input[name=createsubmit]').attr('disabled', true);
        } else {
            $('input[name=createsubmit]').removeAttr('disabled');
        }
    }

    // dropcol - удалить колонку в существующей таблице
    // chgecol - изменить колонку в существующей таблице
    $('.tablist').click(function(event) {
        if (event.target.tagName != 'IMG') { return; }
        tabname = $(event.target).parentsUntil('ul.tablist').last().attr('class');
        colname = $(event.target).parentsUntil('ul.' + tabname).last().attr('class');

        switch ($(event.target).attr('class')) {
            case 'dropcol':
                $.post("query.php",
                    {typeQuery: "dropcol", tab: tabname, col: colname},
                    function(data, result) {
                        $('output').html(data);
                        $('.result').show();
                        if (result == 'success') {
                            $(event.target).parentsUntil('ul.' + tabname).last().remove();
                        }
                    }
                );
                break;
            case 'chgecol': // в процессе реализации:
                $('#newcol').attr('value', colname);
                $('#newtype').attr('value', $(event.target).parentsUntil('ul.' + tabname).attr('data-type'));
                $('.chgecol_form').removeClass('hidden');
                break;
        }
    });

    $('input[ name=changesubmit]').click(function() {
        event.preventDefault();
        let newcol = $('#newcol').attr('value');
        let newtype = $('#newtype').attr('value');

        $.post("query.php",
            {typeQuery: "updatecol", tab: tabname, col: colname, newcol: newcol, newtype: newtype},
            function(data, result) {
                $('output').html(data);
                $('.result').show();
                $('.chgecol_form').addClass('hidden');
                getTableList();
            }
        )
    });

    function getTableList() {
        $.get('query.php',
            '',
            function (data_res, request) {
                let strFld = '';
                let myData = '';

                $('.tablist').html('Таблицы базы данных ' + "<?php echo $database ?>");
                try {
                    myData = JSON.parse(data_res);
                }
                catch (err) {
                    strFld = $('output').html();
                    $('output').html(strFld + "<br/>" + data_res + "<br/>" + err);
                }

                myData.forEach(function (item) {
                    let tab_name = item.Tables_in_<?=$database?>;
                    $('.tablist').append(`<li class="${tab_name}">Структура таблицы <strong>"${tab_name}"</strong>: <ul class="${tab_name}"></ul></li>`);
                    if (item.fld instanceof Array) {
                        strFld = '';
                        item.fld.forEach(function (fld) {
                            strFld += `<li class="${fld.Field}" data-type="${fld.Type}">${fld.Field} ${fld.Type}`;
                            // две кнопки на удаление и на изменение колонки:
                            strFld += '<img src="./img/drop.png" title="Удалить колонку" class="dropcol">';
                            strFld += '<a href="#editcol"><img src="./img/edit.png" title="Редактировать колонку" class="chgecol"></a>';
                            strFld +='</li>';
                        });
                        $('ul.' + tab_name).html(strFld);
                    }
                    else {
                        $('ul.' + tab_name).html(item.fld);
                    }
                });
            });
    }
</script>
</body>
</html>

