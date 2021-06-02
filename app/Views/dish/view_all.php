<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>
    <div class="container main">
        <?php if (!empty($ingridient) && is_array($ingridient)) : ?>
            <h2>Все блюда:</h2>
            <div class="d-flex justify-content-between mb-2">
            <?= $pager->links('group1','my_page') ?>
                <?= form_open('rating/viewAllWithUsers', ['style' => 'display: flex']); ?>
                <select name="per_page" class="ml-3" aria-label="per_page">
                    <option value="2" <?php if($per_page == '2') echo("selected"); ?>>2</option>
                    <option value="5"  <?php if($per_page == '5') echo("selected"); ?>>5</option>
                    <option value="10" <?php if($per_page == '10') echo("selected"); ?>>10</option>
                    <option value="20" <?php if($per_page == '20') echo("selected"); ?>>20</option>
                </select>
                <button class="btn btn-outline-success" type="submit" class="btn btn-primary">На странице</button>
                </form>
                <?= form_open('ingridient/viewAllWithUsers',['style' => 'display: flex']); ?>
                <input type="text" class="form-control ml-3" name="search" placeholder="Имя или описание" aria-label="Search"
                       value="<?= $search; ?>">
                <button class="btn btn-outline-success" type="submit" class="btn btn-primary">Найти</button>
                </form>

            </div>

            </div>
            <table class="table table-striped">
                <thead>
                <th scope="col">Аватар</th>
                <th scope="col">Ингридиент</th>
                <th scope="col">Email</th>
                <th scope="col">Наименование</th>
                <th scope="col">Управление</th>
                </thead>
                <tbody>
                <?php foreach ($ingridient as $item): ?>
                    <tr>
                        <td>
                            <?php if (is_null($item['picture_url'])) : ?>
                                <?php if ($item['Единицы измерения'] == 0) : ?>
                                    <img height="50" src="https://www.flaticon.com/svg/static/icons/svg/2829/2829841.svg"alt="<?= esc($item['Наименование']); ?>">
                                <?php else:?>
                                    <img height="50" src="https://www.flaticon.com/svg/static/icons/svg/163/163801.svg" alt="<?= esc($item['Наименование']); ?>">
                                <?php endif ?>
                            <?php else:?>
                                <img height="50" src="<?= esc($item['picture_url']); ?>" alt="<?= esc($item['Наименование']); ?>">
                            <?php endif ?>
                        </td>
                        <td><?= esc($item['Наименование']); ?></td>
                        <td><?= esc($item['email']); ?></td>
                        <td>
                            <a href="<?= base_url()?>/ingridient/view/<?= esc($item['id']); ?>" class="btn btn-primary btn-sm">Просмотреть</a>
                            <a href="<?= base_url()?>/ingridient/edit/<?= esc($item['id']); ?>" class="btn btn-warning btn-sm">Редактировать</a>
                            <a href="<?= base_url()?>/ingridient/delete/<?= esc($item['id']); ?>" class="btn btn-danger btn-sm">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php else : ?>
            <div class="text-center">
                <p>Блюда не найдены </p>
                <a class="btn btn-primary btn-lg" href="<?= base_url()?>/ingridient/create"><span class="fas fa-tachometer-alt" style="color:white"></span>&nbsp;&nbsp;Создать блюдо</a>
            </div>
        <?php endif ?>
    </div>
<?= $this->endSection() ?>