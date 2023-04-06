<?php
include_once __DIR__ . '/../private/comment.php';
include_once __DIR__ . '/../private/user.php';
include_once __DIR__ . '/../private/playlist.php';
include_once __DIR__ . '/../private/sql.php';
include_once __DIR__ . '/../private/tokenhandler.php';
include_once __DIR__ . '/../private/locale.php';

$currentuser = User::getUser();

$queue = [];

if (isset($_GET['p']) && $pls = Playlist::get($_GET['p'])) {
    if (isset($_GET['v'])) {
        $idx = $pls->indexOfEntry($_GET['v']);
    }

    if (!isset($idx) || $idx < 0) {
        $idx = 0;
    }

    if ($sz = sizeof($pls->getEntries())) {
        $idx++;
        for ($i = 0; $i < 8 && $idx < $sz; $i++, $idx++) {
            array_push($queue, $pls->getEntries()[$idx]);
        }
    }
}

if (!($usepls = (bool)sizeof($queue))) {
    $queue = Video::getRandom();
    if (isset($_GET['v'])) {
        $tmp = [];
        foreach ($queue as $video) {
            if (strcmp($_GET['v'], $video->getAlias())) {
                array_push($tmp, $video);
            }
        }
        unset($queue);
        $queue = $tmp;
    }
}

if (sizeof($queue)) {
    foreach ($queue as $video) {
        require __DIR__ . '/../private/docs/card-videoq.php';
    }
} else {
    http_response_code(404);
    print Locale::getValue('video.queue.empty');
}
exit;
