<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>
    <div class="container main">
        <?php use CodeIgniter\I18n\Time; ?>
        <?php if (!empty($ingridient)) : ?>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row">
                    <div class="col-md-4 d-flex align-items-center">
                        <?php if (ingridient['Единицы измерения'] == 0) : ?>
                            <img height="150" src="https://www.flaticon.com/svg/static/icons/svg/2829/2829841.svg" class="card-img" alt="<?= esc($ingridient['Наименование']); ?>">
                        <?php else:?>
                            <img height="150" src="https://www.flaticon.com/svg/static/icons/svg/163/163801.svg" class="card-img" alt="<?= esc($ingridient['Наименование']); ?>">
                        <?php endif ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($ingridient['Наименование']); ?></h5>
                            <div class="d-flex justify-content-between">
                                <div class="my-0">Единицы измерения:</div>
                                <?php if ($ingridient['Единицы измерения'] == 0) : ?>
                                    <div class="text-muted">Литры</div>
                                <?php else:?>
                                    <div class="text-muted">Граммы</div>
                                <?php endif ?>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="my-0">Справочник создан:</div>
                                <div class="text-muted"><?= esc(Time::parse($ingridient['created_at'])->toDateString() ); ?></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="my-0">Текущее блюдо:</div>
                                <span class="badge badge-info">199</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <p>Блюдо не найдено.</p>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>