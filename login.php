<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    header('Location: ./');
    exit;
}
if (isset($_POST['login']) && isset($_POST['password'])) {
    if (User::login($_POST['login'], $_POST['password'])) {
        header('Location: ./');
    } else {
        $errorCaption = Locale::getValue('login.error');
        $errorMessage = Locale::getValue('login.error.message');
    }
}

require __DIR__ . '/private/views/login.php';
