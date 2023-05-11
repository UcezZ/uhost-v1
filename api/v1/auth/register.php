<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../private/responsehelper.php';

if (TokenHandler::check()) {
    ResponseHelper::errorMessage(Locale::getValue('login.error.alreadyauthorized'));
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
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
                    ResponseHelper::successMessage(Locale::getValue('register.success.message'), Locale::getValue('register.success'));
                } else {
                    $errorMessage =  Locale::getValue('register.error.message7');
                }
            }
            if ($errorMessage) {
                ResponseHelper::errorMessage($errorMessage, Locale::getValue('register.error'));
            }
        } else {
            ResponseHelper::errorMessage(Locale::getValue('login.error.message'), Locale::getValue('login.error'), 401);
        }
        break;
}

ResponseHelper::errorResponse();
