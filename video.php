<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/playlist.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';


$currentuser = User::getUser();

if (!isset($currentuser) && isset($_GET['tk'])) {
    $currentuser = User::getUser(token: $_GET['tk']);
}

$displayMode = 0;

if (isset($_GET['v']) && strlen($_GET['v']) < 9) {
    $video = Video::getByAlias($_GET['v'], $currentuser ? $currentuser->getId() : 0);

    if ($video) {
        if (isset($_GET['q'])) {
            switch ($_GET['q']) {
                case 'thumbnail':
                    $video->sendThumbnailStream();
                    exit;
                case 'video':
                    $video->sendVideoStream();
                    exit;
                case 'download':
                    $video->sendVideoStream(true);
                    exit;
            }
        }
        $displayMode = 1;
    } else {
        $displayMode = -2;
        header('HTTP/1.1 404 Not Found');
        $errorCaption = Locale::getValue('common.error.notfound');
        $errorMessage = Locale::getValue('video.error.notfound.message');
    }
}

if (!isset($currentuser) && !$displayMode) {
    header('Location: ./');
    exit;
}

if (!$displayMode) {
    if (sizeof($videoCollection = Video::getAllByUserId($_GET['u'] ?? $currentuser->getId()))) {
        $displayMode = 2;
    } else {
        $displayMode = -1;
        $errorCaption = Locale::getValue('video.error.novideos');
        $errorMessage = isset($_GET['u']) && $currentuser->getId() != $_GET['u'] ? Locale::getValue('video.error.novideos.user.message') : Locale::getValue('video.error.novideos.message');
    }
}

require __DIR__ . '/private/views/video.php';
