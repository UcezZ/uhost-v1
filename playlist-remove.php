<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/playlist.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

$currentuser = User::getUser();
if (!isset($currentuser)) {
    header('Location: ./');
    exit;
}

if (isset($_POST['p']) && $pls = Playlist::get($_POST['p'])) {

    if (isset($_POST['v']) && $video = Video::getByAlias($_POST['v'])) {
        switch ($code = $pls->removeVideo($video)) {
            case 0:
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './playlist.php');
                break;
            case 1:
                $errorMessage = Locale::getValue('playlist.error.entry.remove.access.message');
                break;
            default:
                $errorMessage = Locale::getValue('common.error.other.message') . $code;
                break;
        }
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('common.error.edit');
        }
    } else {
        switch ($code = $pls->delete()) {
            case 0:
                header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './playlist.php');
                break;
            case 1:
                $errorMessage = Locale::getValue('playlist.error.remove.access.message');
                break;
            default:
                $errorMessage = Locale::getValue('common.error.other.message') . $code;
                break;
        }
        if (isset($errorMessage)) {
            $errorCaption = Locale::getValue('common.error.remove.message');
        }
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './');
    exit;
}

require __DIR__ . '/private/views/playlist-remove.php';
