<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title><?= Locale::getValue('app.name') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/form-search.css">
    <link rel="stylesheet" type="text/css" href="./css/page-video.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
    <link rel="icon" type="image/icon" href="./favicon.ico">
</head>

<body>
    <?php
    include __DIR__ . '/../docs/header.php';
    include __DIR__ . '/../docs/block-search.php'
    ?>
    <div class="main">
        <?php
        $videoCollection = Video::getRandom(16);
        require __DIR__ . '/../docs/block-videolist.php';
        ?>
    </div>
</body>