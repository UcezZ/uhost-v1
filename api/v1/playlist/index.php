<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/playlist.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $userId = isset($_GET['u']) && filter_input(INPUT_GET, 'u', FILTER_VALIDATE_INT) ? $_GET['u'] : $currentuser->getId();
            $playlistCollection = Playlist::getAll($userId);

            if (isset($playlistCollection) && sizeof($playlistCollection)) {
                ResponseHelper::successResponse($playlistCollection);
            } else {
                ResponseHelper::errorMessage(Locale::getValue($currentuser->getId() == $userId ? 'playlist.error.noplaylists.message' : 'playlist.error.noplaylists.user.message'), Locale::getValue('playlist.error.noplaylists'));
            }
            break;
        case 'POST':
            if (isset($_POST['name'])) {
                switch ($code = Playlist::create($_POST['name'], $currentuser)) {
                    case 0:
                        ResponseHelper::successResponse();
                    case 1:
                        $errorMessage = Locale::getValue('playlist.error.create.exist.message');
                        break;
                    default:
                        $errorMessage = Locale::getValue('playlist.error.other.message') . $code;
                        break;
                }
                if (isset($errorMessage)) {
                    ResponseHelper::errorMessage($errorMessage, Locale::getValue('playlist.error.create'));
                }
                ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
            }
            break;
    }
    ResponseHelper::errorResponse();
}

ResponseHelper::errorMessage(message: Locale::getValue('common.error.unauthorized'), httpCode: 401);
