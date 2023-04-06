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

if (isset($_POST['v'])) {
    $video = Video::getByAlias($_POST['v']);
    if ($video) {
        switch ($video->delete()) {
            case 0:
                header('Location: ./video.php');
                exit;
            case 1:
                $errorMessage = Locale::getValue('sql.error.message') . htmlspecialchars(SQL::getErrors());
                break;
            case 2:
                $errorMessage = Locale::getValue('video.error.delete');
                break;
        }
    } else {
        $errorMessage = Locale::getValue('video.error.notfound.message');
    }
}

require __DIR__ . '/private/views/video-remove.php';
