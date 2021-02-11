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
            <a class="navbar-brand">СразуБанк</a>
            <div id="my-nav" class="collapse navbar-collapse d-flex justify-content-between">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?page=index">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=get_credit" tabindex="-1">Заявка на кредит</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=get_deposit" tabindex="-1">Заявка на вклад</a>
                    </li>
                </ul>
            </div>
        </nav>
