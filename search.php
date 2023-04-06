<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';
include_once __DIR__ . '/private/searchparams.php';

$currentuser = User::getUser();

if (isset($_GET['q'])) {
    $searchParams = new SearchParams();

    if (isset($_GET['p'])) {
        $searchParams->setPage($_GET['p']);
    }

    if (isset($_GET['pp'])) {
        $searchParams->setPerPage($_GET['pp']);
    }

    if (isset($_GET['own'])) {
        $searchParams->setOwn($_GET['own']);
    }

    $videoCollection = Video::search($_GET['q'], $searchParams);
}
if (!isset($videoCollection) || $videoCollection == 1) {
    http_response_code(404);
    $errorCaption = Locale::getValue('search.error');
    $errorMessage = Locale::getValue('search.error.empty.message');
} else switch ($videoCollection) {
    case 2:
        http_response_code(404);
        $errorCaption = Locale::getValue('common.error.notfound');
        $errorMessage = Locale::getValue('search.error.notfound.message');
        break;
    case 3:
        http_response_code(404);
        $errorCaption = Locale::getValue('search.error');
        $errorMessage = Locale::getValue('search.error.shortquery.message');
        break;
    case 4:
        http_response_code(404);
        $errorCaption = Locale::getValue('search.error');
        $errorMessage = Locale::getValue('search.error.longquery.message');
        break;
}

require __DIR__ . '/private/views/search.php';
