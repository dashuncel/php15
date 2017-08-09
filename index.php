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
        <a href="#">Создание таблицы в БД</a>
        <section class="create hidden">
            <form>
                <label>Название таблицы: <input type="text" name="tabname"></label>
                <div class="fld">

                </div>
            </form>
        </section>
    </li>
    <li>
        <a href="#">Список таблиц БД</a>
        <section class="list hidden">

        </section>
    </li>
</ul>
<script>
    'use strict';
    $('a').click(function(event) {
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

</script>
</body>
</html>

