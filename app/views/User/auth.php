<div class="d-flex mb-5">
    <h2 class="marker">
        <span class="marker_h2">
            Авторизация
        </span>
    </h2>
</div>

<div class="row">
    <div class="col-lg-4 col-md-6 col-12">
        <form class="row" id="form">

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input autofocus id="name" class="form-control" name="name" placeholder="Имя пользователя" type="text">
                    <label for="name">Имя пользователя</label>
                    <div class="invalid-feedback">Введите имя пользователя</div>
                    <div class="feedback-short d-none">имя пользователя</div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="form-floating">
                    <input class="form-control" id="password" name="password" placeholder="Пароль" type="password">
                    <label for="password">Пароль</label>
                    <div class="invalid-feedback">Введите пароль</div>
                    <div class="feedback-short d-none">пароль</div>
                </div>
            </div>

            <div class="col-12">
                <a class="btn btn-secondary me-2" href="/">Назад</a>
                <button class="btn btn-success btn__login" type="button">Войти</button>
            </div>

        </form>
    </div>
</div>