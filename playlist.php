<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/playlist.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';


if (TokenHandler::check()) {
    $currentuser = User::getUser();
    $playlistCollection = Playlist::getAll();
} else {
    header('Location: ./');
    exit;
}

if (isset($_GET['u']) && ($user = User::getUser($_GET['u']))) {
    $playlistCollection = Playlist::getAll($user->getId());
}

if (!isset($playlistCollection) || !sizeof($playlistCollection)) {
    $errorCaption = Locale::getValue('playlist.error.noplaylists');
    $errorMessage = Locale::getValue('playlist.error.noplaylists.message');
}

require __DIR__ . '/private/views/playlist.php';
