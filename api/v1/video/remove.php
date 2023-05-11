<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['v'])) {
                $video = Video::getByAlias($_POST['v']);
                if ($video) {
                    switch ($video->delete($currentuser)) {
                        case 0:
                            ResponseHelper::successResponse();
                        case 1:
                            $errorMessage = Locale::getValue('sql.error.message') . htmlspecialchars(SQL::getErrors());
                            break;
                        case 2:
                            $errorMessage = Locale::getValue('video.error.delete');
                            break;
                    }
                } else {
                    $errorMessage = Locale::getValue('video.error.notfound.message');
                }
            }
            if (isset($errorMessage)) {
                ResponseHelper::errorMessage($errorMessage, Locale::getValue('common.error.remove.message'));
            }
        default:
            ResponseHelper::errorMessage(message: Locale::getValue('common.error.notfound'), httpCode: 404);
            break;
    }

    ResponseHelper::errorResponse();
} else {
    ResponseHelper::errorMessage(message: Locale::getValue('common.error.unauthorized'), httpCode: 401);
}
