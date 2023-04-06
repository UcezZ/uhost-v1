<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../responsehelper.php';

if (TokenHandler::check()) {
    ResponseHelper::errorMessage(Locale::getValue('login.error.alreadyauthorized'));
}

if (isset($_POST['login']) && isset($_POST['password'])) {
    if ($token = User::login($_POST['login'], $_POST['password'], false)) {
        ResponseHelper::successResponse([
            'token' => strtolower($token),
            'user' => User::getUser(token: $token)->toArray()
        ]);
    } else {
        ResponseHelper::errorMessage(Locale::getValue('login.error.message'), Locale::getValue('login.error'), 401);
    }
}
