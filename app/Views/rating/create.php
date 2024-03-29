<?= $this->extend('templates/layout') ?>
<?= $this->section('content') ?>
<div class="container" style="max-width: 540px;">

    <?= form_open_multipart('ingridient/store'); ?>
    <div class="form-group">
        <label for="name">Наименование</label>
        <input type="text" class="form-control <?= ($validation->hasError('Наименование')) ? 'is-invalid' : ''; ?>" name="Наименование"
               value="<?= old('Наименование'); ?>">
        <div class="invalid-feedback">
            <?= $validation->getError('Наименование') ?>
        </div>

    </div>

    </div>
    <div class="form-group">
        <label class="form-check-label">Единицы измерения</label>
        <div class="form-check ">
            <input class="form-check-input" type="radio" name="Единицы измерения" value="0" <?= old('Единицы измерения')=='0' ? 'checked': '' ?> >
            <label class="form-check-label">
                <small class="form-text text-muted">Литры</small>
            </label>
        </div>
        <div class="form-check ">
            <input class="form-check-input" type="radio" name="Единицы измерения" value="1" <?= old('Единицы измерения')=='1' ? 'checked': '' ?> >
            <label class="form-check-label">
                <small class="form-text text-muted">Граммы</small>
            </label>

        </div>
        <div class="invalid-feedback" style="display: block">
            <?= $validation->getError('Единицы измерения') ?>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="submit">Создать</button>
    </div>
    </form>


</div>
<?= $this->endSection() ?>
