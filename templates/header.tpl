<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title><?php print $vars['title']; ?></title>
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link href="../images/favicon.ico" rel="shortcut icon" type="image/x-icon">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
            <div class="container collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="navbar-brand">КД-Банк</a>
                    </li>
                    <li class="nav-item offset-1">
                        <a class="nav-link" href="index.php?page=main" tabindex="-1">Главная</a>
                    </li>
                    <li class="nav-item offset-1">
                        <a class="nav-link" href="index.php?page=credit" tabindex="-1">Заявка на кредит</a>
                    </li>
                    <li class="nav-item offset-1">
                        <a class="nav-link" href="index.php?page=deposit" tabindex="-1">Заявка на вклад</a>
                    </li>
                    <li class="nav-item offset-1">
                        <a class="nav-link" href="index.php?page=report" tabindex="-1">Отчёт</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container container-main">
