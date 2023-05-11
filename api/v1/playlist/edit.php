<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/playlist.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['p']) && filter_input(INPUT_POST, 'p', FILTER_VALIDATE_INT) && isset($_POST['name']) && $pls = Playlist::get($_POST['p'])) {
                switch ($code = $pls->edit($_POST['name'], $currentuser)) {
                    case 0:
                        ResponseHelper::successResponse(Playlist::get($pls->getId()));
                        break;
                    case 1:
                        $errorMessage = Locale::getValue('playlist.error.remove.access.message');
                        break;
                    default:
                        $errorMessage = Locale::getValue('common.error.other.message') . $code;
                        break;
                }
                if (isset($errorMessage)) {
                    ResponseHelper::errorMessage($errorMessage, Locale::getValue('common.error.remove.message'));
                }
            }

            ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
            break;
    }
    ResponseHelper::errorResponse();
}

ResponseHelper::errorMessage(message: Locale::getValue('common.error.unauthorized'), httpCode: 401);
