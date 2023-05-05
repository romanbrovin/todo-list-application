<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/css/default.min.css">

    <title><?=$meta['title']?></title>
</head>
<body>

<?php $_SESSION['token1'] = hash('md5', mt_rand()); ?>

<input id="token2" type="hidden" value="<?=$_SESSION['token1']?>">

<div class="loader">
    <div class="loader loader__background"></div>
    <div class="loader loader__pulse">
        <div class="spinner-border text-secondary"></div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div class="toast align-items-center border-0">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" type="button"></button>
        </div>
    </div>
</div>

<div class="container wrapper">
    <input type="hidden" id="uri" value="<?=$uri?>">
    <?=$content?>
</div>

<script src="/js/default.min.js"></script>

</body>
</html>