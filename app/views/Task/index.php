<div class="d-flex mb-3">
    <h1 class="marker">
        <span class="marker_h1">
            <a href="/">ToDo App</a>
        </span>
    </h1>
</div>

<div class="">
    <a href="/add" class="btn btn-primary">Новая задача</a>
    <?php if (isAdmin()) : ?>
        <a href="/logout" class="btn btn-secondary">Выход</a>
    <?php else : ?>
        <a href="/auth" class="btn btn-success">Авторизация</a>
    <?php endif; ?>
</div>

<div class="d-flex row mt-3 mb-3">

    <div class="col-lg-8 col-md-12">
        <ul class="list-inline">
            <li class="list-inline-item text-secondary">
                Сортировать по:
            </li>
            <?php foreach ($sort['searchFields'] as $field) : ?>
                <li class="list-inline-item">
                    <a class="s_query" href="#" data-query="<?=$sort['query_' . $field['query']]?>">
                        <?=$field['name']?> <?=$sort['arrow_' . $field['query']]?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>

<input type="hidden" id="q" value="<?=$sort['sortQuery']?>">

<div class="row mt-3 mb-4">

    <table class="table">
        <thead>
        <tr>
            <th width="40">ID</th>
            <th width="200">Имя пользователя</th>
            <th width="200">Email</th>
            <th>Текст задачи</th>
            <th width="200">#</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr class="item" id="<?=$task['id']?>">
                <th><?=$task['id']?></th>
                <td><?=$task['name']?></td>
                <td><?=$task['email']?></td>
                <td><?=$task['text']?></td>
                <td>
                    <?php if (isAdmin()) : ?>
                        <div class="mb-2">
                            <button class="btn btn-primary btn-sm btn__edit">Редактировать</button>
                        </div>
                        <div class="form-check">
                            <input <?=((int)$task['is_done'] === 1) ? 'checked' : ''?>
                                class="form-check-input"
                                id="done_<?=$task['id']?>"
                                name="done"
                                type="checkbox">
                            <label class="form-check-label btn__done" for="done_<?=$task['id']?>">
                                Выполнено
                            </label>
                        </div>
                    <?php else : ?>
                        <?php if ((int)$task['is_done'] === 1): ?>
                            <span class="badge bg-success">
                                выполнено
                            </span>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ((int)$task['is_update'] === 1): ?>
                        <div class="mt-2">
                            <span class="badge bg-secondary">
                                отредактировано администратором
                            </span>
                        </div>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>

<?=($pagination->countPages > 1) ? $pagination : ''?>