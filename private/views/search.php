<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title><?= Locale::getValue('app.name') ?> - <?= Locale::getValue('page.search') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="./css/page-video.css">
    <link rel="stylesheet" type="text/css" href="./css/form-search.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
    <link rel="icon" type="image/icon" href="./favicon.ico">
</head>

<body>
    <?php
    require __DIR__ . '/../docs/header.php';
    require __DIR__ . '/../docs/block-search.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorCaption) && isset($errorMessage)) {
            require __DIR__ . '/../docs/card-error.php';
        } else        if (sizeof($videoCollection)) {
            require __DIR__ . '/../docs/block-videolist.php';
            require __DIR__ . '/../docs/block-searchnavi.php';
        }
        ?>
    </div>
</body>