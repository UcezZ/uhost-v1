<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/comment.php';
include_once __DIR__ . '/../responsehelper.php';

$currentuser = User::getUser();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['v'])) {
            if ($stmt = SQL::runQuery(
                "EXECUTE W_GetCommentsByVideoAlias @alias = ?",
                [$_GET['v']]
            )) {
                if (($rows = SQL::sqlResultToArray($stmt)) && sizeof($rows)) {
                    $comments = [];
                    foreach ($rows as $row) {
                        array_push($comments, new Comment($row));
                    }

                    ResponseHelper::successResponse($comments);
                } else {
                    ResponseHelper::errorMessage(httpCode: 404);
                }
            } else {
                ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
            }

            ResponseHelper::errorMessage(httpCode: 400);
        }

        if (!isset($currentuser)) {
            http_response_code(403);
            exit;
        }
        break;
    case 'POST':
        break;
}
