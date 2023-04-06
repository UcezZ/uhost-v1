<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

$currentuser = User::getUser();
if (!isset($currentuser)) {
    header('Location: ./');
    exit;
}

if (isset($_POST['v']) && isset($_POST['name'])) {
    $video = Video::getByAlias($_POST['v']);
    if ($video) {
        if (strlen($_POST['name'])) {
            switch ($video->edit($_POST['name'], isset($_POST['pub']))) {
                case 0:
                    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './video.php?v=' . $_POST['v']);
                    exit;
                case 1:
                    $errorMessage = Locale::getValue('sql.error.message') . htmlspecialchars(SQL::getErrors());
                    break;
                case 2:
                    $errorMessage = Locale::getValue('video.error.edit');
                    break;
            }
        } else {
            $errorMessage = Locale::getValue('video.error.edit.caption.message');
        }
    } else {
        $errorMessage = Locale::getValue('video.error.notfound.message');
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './');
    exit;
}

require __DIR__ . '/private/views/video-edit.php';
