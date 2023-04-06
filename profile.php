<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/playlist.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

if (TokenHandler::check()) {
    $currentuser = User::getUser();
    $roles = User::getRoles();

    if (isset($_POST['u']) && isset($_POST['name']) && isset($_POST['info']) && isset($_POST['theme']) && isset($_POST['locale'])) {
        if ($currentuser->getId() == $_POST['u'] || $currentuser->isAdmin()) {
            $user = User::getUser($_POST['u']);
            switch ($user->edit($_POST['name'], $_POST['info'], $_POST['theme'], $_POST['locale'])) {
                case 0:
                    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './profile.php');
                    exit;
                case 1:
                    $errorMessage = Locale::getValue('user.edit.error.message');
                    break;
                case 2:
                    $errorMessage = Locale::getValue('sql.error.message') . SQL::getErrors();
                    break;
            }
        } else {
            $errorMessage = Locale::getValue('user.edit.error.message');
        }

        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('common.error.edit');
        }
    }
} else {
    header('Location: ./');
    exit;
}

require __DIR__ . '/private/views/profile.php';
