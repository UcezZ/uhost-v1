<?php

include_once __DIR__ . '/../responsehelper.php';
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';

$currentuser = User::getUser();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
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
                    ResponseHelper::successMessage(Locale::getValue('user.password.success.message'), Locale::getValue('user.password.success'));
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
            ResponseHelper::errorMessage($errorMessage, Locale::getValue('user.password.error'), 400);
        }
        break;
    default:
        break;
}
