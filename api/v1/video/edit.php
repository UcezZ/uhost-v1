<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['v']) && isset($_POST['name'])) {
                $video = Video::getByAlias($_POST['v']);
                if ($video) {
                    if (strlen($_POST['name'])) {
                        switch ($video->edit($_POST['name'], isset($_POST['isPublic']), $currentuser)) {
                            case 0:
                                ResponseHelper::successResponse(Video::getByAlias($_POST['v']));
                            case 1:
                                $errorMessage = Locale::getValue('sql.error.message') . htmlspecialchars(SQL::getErrors());
                                break;
                            case 2:
                                $errorMessage = Locale::getValue('video.error.edit');
                                break;
                        }
                    } else {
                        $errorMessage = Locale::getValue('video.error.edit.caption.message');
                    }
                } else {
                    $errorMessage = Locale::getValue('video.error.notfound.message');
                }
                if (isset($errorMessage)) {
                    ResponseHelper::errorMessage($errorMessage, Locale::getValue('common.error.edit'));
                }
            }
        default:
            ResponseHelper::errorMessage(Locale::getValue('common.error.notfound'), '', 404);
            break;
    }

    ResponseHelper::errorMessage(httpCode: 400);
} else {
    ResponseHelper::errorMessage(Locale::getValue('common.error.unauthorized'), '', 401);
}
