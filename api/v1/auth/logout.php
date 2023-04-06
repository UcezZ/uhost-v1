<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../responsehelper.php';

User::logout();
ResponseHelper::successMessage(Locale::getValue('logout.ok'));
