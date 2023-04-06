<?php
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/comment.php';

$currentuser = User::getUser();

require __DIR__ . '/private/views/index.php';
