<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>
    <div class="jumbotron text-center">
        <img class="mb-4" src="https://www.flaticon.com/svg/static/icons/svg/1379/1379505.svg" alt="" width="72" height="72"><h1 class="display-4">CURating</h1>
        <p class="lead">Это приложение поможет создавать расписание активностей и вести учет индивидуальных достижений (рейтинг) детей дошкольного и школьного возраста.</p>
        <a class="btn btn-primary btn-lg" href="auth/login" role="button">Войти</a>
    </div>
<?= $this->endSection() ?>
