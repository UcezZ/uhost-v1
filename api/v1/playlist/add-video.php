<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/playlist.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['p']) && filter_input(INPUT_POST, 'p', FILTER_VALIDATE_INT) && isset($_POST['v'])) {
                if ($pls = Playlist::get($_POST['p'])) {
                    if ($video = Video::getByAlias($_POST['v'])) {
                        if ($pls->indexOfEntry($video->getAlias()) == -1) {
                            switch ($code = $pls->addVideo($video)) {
                                case 0:
                                    ResponseHelper::successMessage(Locale::getValue('playlist.add.video.ok.message'));
                                case 1:
                                    $errorMessage = Locale::getValue('playlist.error.entry.add.access.message');
                                    break;
                                default:
                                    $errorMessage = Locale::getValue('playlist.error.other.message') . $code;
                                    break;
                            }
                        } else {
                            $errorMessage = Locale::getValue('playlist.error.entry.add.alreadyexists.message');
                        }
                    } else {
                        $errorMessage = Locale::getValue('video.error.notfound.message');
                    }
                } else {
                    $errorMessage = Locale::getValue('playlist.error.entry.add.access.message');
                }

                if (isset($errorMessage)) {
                    ResponseHelper::errorMessage($errorMessage, Locale::getValue('playlist.error.entry.add'));
                }
            }

            ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
            break;
    }
    ResponseHelper::errorResponse();
}

ResponseHelper::errorMessage(message: Locale::getValue('common.error.unauthorized'), httpCode: 401);
