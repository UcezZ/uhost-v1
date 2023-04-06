<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF8">
    <title><?= Locale::getValue('app.name') ?> - <?= Locale::getValue('page.register') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./fonts/productsans.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
    <link rel="stylesheet" type="text/css" href="./css/card.css">
    <link rel="stylesheet" type="text/css" href="./css/form.css">
    <link rel="stylesheet" type="text/css" href="./css/card-state.css">
    <link rel="stylesheet" type="text/css" href="<?= Theme::getLink() ?>">
    <link rel="icon" type="image/icon" href="./favicon.ico">
</head>

<body>
    <?php
    include __DIR__ . '/../docs/header.php';
    ?>
    <div class="main">
        <?php
        if (isset($errorCaption) && isset($errorMessage)) {
            require __DIR__ . '/../docs/card-error.php';
        }
        if (isset($successCaption) && isset($successMessage)) {
            require __DIR__ . '/../docs/card-success.php';
            exit;
        } else {
            include __DIR__ . '/../docs/form-register.php';
        }
        ?>
    </div>
</body>