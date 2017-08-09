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
        <section class="create hidden">
            <form>
                <label>Наименование таблицы: <input type="text" name="tabname"></label>
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
                        <!--шаблонная строка, которую копируем в таблицу, убирая при этом класс:-->
                        <tr class="template">
                            <td>
                                <input type="text" name="fldname[]" required value="field1">
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
                <input type="submit" value="Создать таблицу" name="create_submit">
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
                        let myData = JSON.parse(data_res);
                        myData.forEach(function (item) {

                        });
                    });
                break;
        }
    });

    // плюс - добваить колонку (строку в таблице)
    $('.addcol').click(function(event) {
        $('.template').clone().appendTo('tbody').removeClass('template');
    });

    // минус - удалить колонку (строку в таблице)
    $('tbody').click(function(event) {
        if (! $(event.target).hasClass('delcol')) {return; }
        $(event.target).parentsUntil('tbody').last().remove();
    });

    // добавление таблицы - запрос:
    $('input[type=submit]').click(function(event) {
        event.preventDefault();
        const formData = new FormData('');

    });
</script>
</body>
</html>

