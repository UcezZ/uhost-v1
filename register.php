<?php
require __DIR__ . '/private/tokenhandler.php';
require __DIR__ . '/private/user.php';
require __DIR__ . '/private/locale.php';
require __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    header('Location: ./');
    exit;
}
if (sizeof($_POST)) {

    function checkPost()
    {
        if (!isset($_POST['name']) || !strlen($_POST['name'])) {
            return Locale::getValue('register.error.message0');
        }
        if (!isset($_POST['login']) || !strlen($_POST['login'])) {
            return Locale::getValue('register.error.message1');
        } else {
            preg_match('/[a-zA-Z0-9_]{5,32}/', $_POST['login'], $matches);
            if (sizeof($matches) != 1 || $matches[0] != $_POST['login']) {
                return Locale::getValue('register.error.message2');
            }
        }
        if (!isset($_POST['password']) || !strlen($_POST['password'])) {
            return  Locale::getValue('register.error.message3');
        }
        if (!isset($_POST['passwordConfirm']) || !strlen($_POST['passwordConfirm'])) {
            return  Locale::getValue('register.error.message4');
        }
        if (strcmp($_POST['password'], $_POST['passwordConfirm'])) {
            return  Locale::getValue('register.error.message5');
        }
        if (strtolower($_POST['login']) == strtolower($_POST['password'])) {
            return  Locale::getValue('register.error.message6');
        }
        return null;
    }

    if (!$errorMessage = checkPost()) {
        if (User::register($_POST['login'], $_POST['password'], $_POST['name'])) {
            $successCaption = Locale::getValue('register.success');
            $successMessage = Locale::getValue('register.success.message');
        } else {
            $errorMessage =  Locale::getValue('register.error.message7');
        }
    }
    if ($errorMessage) {
        $errorCaption = Locale::getValue('register.error');
    }
}

require __DIR__ . '/private/views/register.php';
