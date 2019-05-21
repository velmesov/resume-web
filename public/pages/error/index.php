<!DOCTYPE html>
<html lang="<?= LANG ?>">

<head>
    <? require ROOT . '/public/pages/main/head.php' ?>
</head>

<body>
    <? require ROOT . '/public/pages/' . $page . '/header.php' ?>
    <h1><?= $title ?></h1>
    <div id="main">
        <div class="content"></div>
    </div>
    <? require ROOT . '/public/pages/' . $page . '/footer.php' ?>
    <? require ROOT . '/public/pages/main/initJS.php' ?>
    <script src="<?= SITE ?>public/js<?= $page ?>.js<?= CACHE ?>"></script>
</body>

</html>