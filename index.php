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
    include ('framework/pages.php');
    $pages = new pages;
    if (!isset( $_GET['page']))
    {
        $_GET['page'] = NULL;
    }
    $pages->router($_GET['page']);