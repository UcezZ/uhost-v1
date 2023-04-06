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

if (isset($_POST['name'])) {
    switch ($code = Playlist::create($_POST['name'])) {
        case 0:
            header('Location: ./playlist.php');
            exit;
        case 1:
            $errorMessage = Locale::getValue('playlist.error.create.exist.message');
            break;
        default:
            $errorMessage = Locale::getValue('playlist.error.other.message') . $code;
            break;
    }
    if (isset($errorMessage)) {
        $errorCaption = Locale::getValue('playlist.error.create');
    }
} else if (isset($_POST['p']) && isset($_POST['v'])) {
    if ($pls = Playlist::get($_POST['p'])) {
        if ($video = Video::getByAlias($_POST['v'])) {
            if ($pls->indexOfEntry($video->getAlias()) == -1) {
                switch ($code = $pls->addVideo($video)) {
                    case 0:
                        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? './video.php');
                        exit;
                    case 1:
                        $errorMessage = Locale::getValue('playlist.error.entry.add.access.message');
                        break;
                    default:
                        $errorMessage = Locale::getValue('playlist.error.other.message') . $code;
                        break;
                }
            } else {
                $errorMessage = Locale::getValue('playlist.error.entry.add.alreadyexists.message');
            }
        } else {
            $errorMessage = Locale::getValue('video.error.notfound.message');
        }
    } else {
        $errorMessage = Locale::getValue('playlist.error.entry.add.access.message');
    }

    if (isset($errorMessage)) {
        $errorCaption = Locale::getValue('playlist.error.entry.add');
    }
}

require __DIR__ . '/private/views/playlist-add.php';
