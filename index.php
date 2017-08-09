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
                            <td>
                                <a href="#" class="addcol">
                                    <img src="./img/plus.png" title="Добавить колонку">
                                </a>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="template">  <!--шаблонная строка, которую копируем в таблицу, убирая при этом класс-->
                            <td>
                                <input type="text" name="fldname[]" required>
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
                            <td>
                                <a href="#" class="delcol">
                                    <img src="./img/minus.png" title="Удалить колонку">
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </section>
    </li>
    <li>
        <a href="#" class="mainMenu">Список таблиц БД</a>
        <section class="list hidden">

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
        switch ($(this).attr('class')) {
            case 'create':
                break;
            case 'list':
                break;
        }
    });

    $('.addcol').click(function(event) {
        $('.template').clone().appendTo('tbody').removeClass('template');
    });

    $('.delcol').click(function(event) {
        console.log(event);
        console.log($(this).parentUntil('tbody'));
    });


</script>
</body>
</html>

