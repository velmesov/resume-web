<!DOCTYPE html>
<html lang="<?= LANG_NAME ?>">

<head>
    <? require ROOT . '/public/pages/main/head.php' ?>
</head>

<body>
    <? require ROOT . '/public/pages/' . $page . '/header.php' ?>
    <? require ROOT . '/public/pages/' . $page . '/main.php' ?>
    <? require ROOT . '/public/pages/' . $page . '/footer.php' ?>
    <? require ROOT . '/public/pages/main/initJS.php' ?>
    <script src="<?= SITE ?>public/js/<?= $page ?>.js<?= CACHE ?>"></script>
</body>

</html>