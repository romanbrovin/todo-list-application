<div class="d-flex mb-5">
    <h2 class="marker">
        <span class="marker_h2">
            Добавление новой задачи
        </span>
    </h2>
</div>

<div class="row">
    <div class="col-xl-7 col-lg-12">
        <form class="row" id="form" method="post">

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input autofocus class="form-control" id="name" maxlength="250" name="name"
                           placeholder="Имя пользователя" type="text">
                    <label for="name">Имя пользователя</label>
                    <div class="invalid-feedback">Введите имя пользователя</div>
                    <div class="feedback-short d-none">имя пользователя</div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="email" maxlength="250" name="email"
                           placeholder="Email" type="email">
                    <label for="email">Email</label>
                    <div class="invalid-feedback">Введите ваш email</div>
                    <div class="feedback-short d-none">email не валиден</div>
                </div>
            </div>


            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="text" maxlength="250" name="text"
                           placeholder="Текст задачи" type="text">
                    <label for="text">Текст задачи</label>
                    <div class="invalid-feedback">Введите текст задачи</div>
                    <div class="feedback-short d-none">текст задачи</div>
                </div>
            </div>

            <div class="mt-4">
                <a class="btn btn-secondary me-2" href="/">Назад</a>
                <button class="btn btn-success btn__create" type="button">Добавить</button>
            </div>

        </form>
    </div>
</div>