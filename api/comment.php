<?php
include_once __DIR__ . '/../private/comment.php';
include_once __DIR__ . '/../private/user.php';
include_once __DIR__ . '/../private/sql.php';
include_once __DIR__ . '/../private/tokenhandler.php';
include_once __DIR__ . '/../private/locale.php';

$currentuser = User::getUser();

if (isset($_GET['m'])) {
    switch ($_GET['m']) {
        case 'all':
            if (isset($_GET['v'])) {
                if ($stmt = SQL::runQuery(
                    "EXECUTE W_GetCommentsByVideoAlias @alias = ?",
                    [$_GET['v']]
                )) {
                    if (($rows = SQL::sqlResultToArray($stmt)) && sizeof($rows)) {
                        foreach ($rows as $row) {
                            $comment = new Comment($row);
                            require __DIR__ . '/../private/docs/item-comment.php';
                        }
                    } else {
                        print Locale::getValue('comment.nocomments');
                    }
                    exit;
                }
                http_response_code(500);
                print(SQL::getErrors());
            }
            break;
    }
    http_response_code(400);
    exit;
}

if (!isset($currentuser)) {
    http_response_code(403);
    exit;
}

if (isset($_POST['m']) && isset($currentuser)) {
    switch ($_POST['m']) {
        case 'add':
            if (isset($_POST['v']) && isset($_POST['t'])) {
                if ($stmt = SQL::runQuery(
                    "EXECUTE W_AddComment @userid = ?, @alias = ?, @text= ?",
                    [$currentuser->getId(), $_POST['v'], $_POST['t']]
                )) {
                    if ($row = SQL::sqlResultFirstRow($stmt)) {
                        if (isset($row['ERROR'])) {
                            if ($row['ERROR'] == 0) {
                                http_response_code(200);
                                exit;
                            } else {
                                http_response_code(403);
                                exit;
                            }
                        }
                    }
                }
                http_response_code(500);
                print(SQL::getErrors());
            }
            break;
        case 'delete':
            if (isset($_POST['i'])) {
                if ($stmt = SQL::runQuery(
                    "EXECUTE W_RemoveComment @id = ?, @userid = ?",
                    [$_POST['i'], $currentuser->getId()]
                )) {
                    if ($row = SQL::sqlResultFirstRow($stmt)) {
                        if (isset($row['ERROR'])) {
                            if ($row['ERROR'] == 0) {
                                http_response_code(200);
                                exit;
                            } else {
                                http_response_code(404);
                                exit;
                            }
                        }
                    }
                }
                http_response_code(500);
                print(SQL::getErrors());
            }
            break;
    }
}

http_response_code(400);
exit;
