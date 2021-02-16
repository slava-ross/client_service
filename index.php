<?php
    /**
    *   -A- Автор - Ягодаров Ярослав Владимирович
    *   -D- WEB-приложение "Клиентский сервис (Банк)"
    *   -D- Состав приложения: Файлы классов: pages.php - page-controller;
    *   -D- header.tpl, footer.tpl - шаблоны представлений;
    *   -D- Файл CSS-оформления: style.css;
    *   -Date- 05.02.2021
    */
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    /**
     * -D- Подключение к базе данных
     *
     */
    include_once('classes/db.php');
    $db = new db;
    $dbResult = $db->connect(
        'localhost',
        'root',
        '',
        //'q1Q!w2W@e3E#',
        'client_service'
    );
    if (!$dbResult['success']) {
        foreach ($dbResult['errors'] as $errMessage) {
            print('<p class="message error">' . $errMessage . '</p>');
        }
        exit();
    }
    include_once('classes/pages.php');
    $pages = new pages($db);
    if (!isset($_GET['page']))
    {
        $_GET['page'] = NULL;
    }
    $pages->router($_GET['page']);
