<div class="d-flex mb-5">
    <h2 class="marker">
        <span class="marker_h2">
            Редактирование задачи
        </span>
    </h2>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-12">
        <form class="row" id="form" method="post">

            <input type="hidden" name="id" value="<?=$item['id']?>">

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input autofocus class="form-control" id="text" maxlength="250" name="text"
                           placeholder="Текст задачи" type="text" value="<?=$item['text']?>">
                    <label for="text">Текст задачи</label>
                </div>
            </div>

            <div class="col-12 mb-3">
                Дата создания: <?=$item['created_at']?>
                <?php if ($item['created_at'] !== $item['updated_at']) : ?>
                    <br>
                    Дата редактирования: <?=$item['updated_at']?>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary me-2" href="/">Назад</a>
                <button class="btn btn-success btn__save" type="button">Сохранить</button>
            </div>

        </form>
    </div>
</div>