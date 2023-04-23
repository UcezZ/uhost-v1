<?php
include_once __DIR__ . '/../../../private/sql.php';
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../private/responsehelper.php';

if (($currentuser = User::getUser()) && $currentuser->isAdmin()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            if (isset($_POST['id']) && filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)) {
                if (SQL::runQuery('EXECUTE W_AdminTerminateSession @id = ?', [$_POST['id']])) {
                    ResponseHelper::successResponse();
                } else {
                    ResponseHelper::errorResponse(SQL::getErrors(), httpCode: 500);
                }
            }
            break;
    }
}

ResponseHelper::errorResponse(httpCode: 403);
