<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/comment.php';
include_once __DIR__ . '/../private/responsehelper.php';

if ($currentuser = User::getUser()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (
                isset($_POST['id']) &&
                filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT) &&
                $stmt = SQL::runQuery(
                    "EXECUTE W_RemoveComment @id = ?, @userid = ?",
                    [$_POST['id'], $currentuser->getId()]
                )
            ) {
                if ($row = SQL::sqlResultFirstRow($stmt)) {
                    if (isset($row['ERROR'])) {
                        if ($row['ERROR'] == 0) {
                            ResponseHelper::successResponse();
                        } else {
                            ResponseHelper::errorResponse(httpCode: 404);
                        }
                    }
                }
            }

            ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
            break;
    }

    ResponseHelper::errorResponse();
}

ResponseHelper::errorMessage(message: Locale::getValue('common.error.unauthorized'), httpCode: 401);
