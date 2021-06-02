<!DOCTYPE html>
<head>
    <title>Кулинарный справочник</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/6e9b058a28.js"></script>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
        main{
            margin-top: 90px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-primary fixed-top">
    <a class="navbar-brand fa fas fa-tachometer-alt fa-2x" style="color:white" href="<?= base_url()?>"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Вход
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="<?= base_url()?>/index.php/ingridient">Все блюда</a>
                    <a class="dropdown-item" href="<?= base_url()?>/ingridient/store">Создать блюдо</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle active" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Мой профиль</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Мое блюдо</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if (! $ionAuth->loggedIn()): ?>
                <div class="nav-item dropdown">
                    <a class="nav-link active" href="<?= base_url()?>/auth/login"><span class="fas fa fa-sign-in-alt" style="color:white"></span>&nbsp;&nbsp;Вход</a>
                </div>
            <?php else: ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" ><span class="fas fa fa-user-alt" style="color:white"></span>&nbsp;&nbsp;  <?php echo $ionAuth->user()->row()->email; ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="<?= base_url()?>/auth/logout"><span class="fas fa fa-sign-in-alt" style="color:white"></span>&nbsp;&nbsp;Выход</a>
                    </div>
                </li>
            <?php endif ?>
        </ul>
    </div>
</nav>
<main role="main">

    <?php if (session()->getFlashdata('message')) :?>
        <div class="alert alert-info" role="alert" style="max-width: 540px;">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif ?>

    <?= $this->renderSection('content') ?>
</main>
<footer class="text-center">
    <p>© Храмов Лев 2021 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url();?>/index.php/pages/view/agreement">Пользовательское соглашение</a></p>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>