<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

$currentuser = User::getUser();
if (!isset($currentuser)) {
    header('Location: ./');
    exit;
}

if (sizeof($_POST)) {
    function checkPost()
    {
        if (!isset($_POST['oldpassword']) || !strlen($_POST['oldpassword'])) {
            return Locale::getValue('user.password.error.message0');
        }
        if (!isset($_POST['password']) || !strlen($_POST['password'])) {
            return Locale::getValue('user.password.error.message1');
        }
        if (!isset($_POST['passwordConfirm']) || !strlen($_POST['passwordConfirm'])) {
            return Locale::getValue('user.password.error.message2');
        }
        if (strcmp($_POST['password'], $_POST['passwordConfirm'])) {
            return Locale::getValue('user.password.error.message3');
        }
        if (strtolower($_POST['oldpassword']) == strtolower($_POST['password'])) {
            return Locale::getValue('user.password.error.message4');
        }
        return null;
    }

    if (!$errorMessage = checkPost()) {
        switch ($currentuser->changePassword($_POST['oldpassword'], $_POST['password'])) {
            case 0:
                $successCaption = Locale::getValue('user.password.success');
                $successMessage = Locale::getValue('user.password.success.message');
                break;
            case 1:
                $errorMessage = Locale::getValue('user.password.error.message5');
                break;
            case 2:
                $errorMessage = Locale::getValue('sql.error.message') . SQL::getErrors();
                break;
        }
    }
    if ($errorMessage) {
        $errorCaption = Locale::getValue('user.password.error');
    }
}

require __DIR__ . '/private/views/password.php';
