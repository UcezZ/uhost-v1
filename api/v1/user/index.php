<?php
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../responsehelper.php';

$currentuser = User::getUser();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($currentuser)) {
            if (isset($_GET['id'])) {
                if (filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) && $user = User::getUser($_GET['id'])) {
                    ResponseHelper::successResponse($user);
                }

                ResponseHelper::errorMessage(Locale::getValue('user.error.notfound'), '', 404);
            }

            ResponseHelper::successResponse($currentuser);
        }

        ResponseHelper::errorMessage(Locale::getValue('auth.error.unauthorized'), '', 401);
        break;
    case 'POST':
        if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['info']) && isset($_POST['theme']) && isset($_POST['locale'])) {
            if ($currentuser->getId() == $_POST['id'] || $currentuser->isAdmin()) {
                $user = User::getUser($_POST['id']);
                switch ($user->edit($_POST['name'], $_POST['info'], $_POST['theme'], $_POST['locale'])) {
                    case 0:
                        ResponseHelper::successResponse(User::getUser($_POST['id']));
                    case 1:
                        ResponseHelper::errorMessage(Locale::getValue('user.edit.error.message'), Locale::getValue('common.error.edit'), 403);
                    case 2:
                        ResponseHelper::errorMessage(Locale::getValue('sql.error.message') . SQL::getErrors(), Locale::getValue('common.error.edit'), 500);
                }
            } else {
                ResponseHelper::errorMessage(Locale::getValue('user.edit.error.message'), Locale::getValue('common.error.edit'), 403);
            }
        }
        break;
    default:
        ResponseHelper::errorMessage(Locale::getValue('common.error.notfound'), '', 404);
        break;
}
