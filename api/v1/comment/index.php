<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/comment.php';
include_once __DIR__ . '/../private/responsehelper.php';

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
        }


        break;
    case 'POST':
        if (!isset($currentuser)) {
            ResponseHelper::errorMessage(httpCode: 403);
        }

        if (isset($_POST['alias']) && isset($_POST['text'])) {
            if ($stmt = SQL::runQuery(
                "EXECUTE W_AddComment @userid = ?, @alias = ?, @text= ?",
                [$currentuser->getId(), $_POST['alias'], $_POST['text']]
            )) {
                if ($row = SQL::sqlResultFirstRow($stmt)) {
                    if (isset($row['ERROR'])) {
                        if ($row['ERROR'] == 0) {
                            ResponseHelper::successResponse();
                        } else {
                            ResponseHelper::errorResponse(httpCode: 403);
                        }
                    }
                }
            }

            ResponseHelper::errorMessage(message: SQL::getErrors(), httpCode: 500);
        }
        break;
}

ResponseHelper::errorMessage(httpCode: 400);
