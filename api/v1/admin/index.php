<?php

include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/sql.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../../../private/common.php';
include_once __DIR__ . '/../private/responsehelper.php';

if (($currentUser = User::getUser()) && $currentUser->isAdmin()) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $perpage = isset($_GET['perpage']) && filter_input(INPUT_GET, 'perpage', FILTER_VALIDATE_INT) ? $_GET['perpage'] : 16;
            $page = isset($_GET['page']) && filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ? intval($_GET['page']) : 1;
            $total = 0;

            if (isset($_GET['q'])) {
                switch ($_GET['q']) {
                    case 'stats':
                        if ($stmt = SQL::runQuery('EXECUTE W_AdminGetStats')) {
                            $result = SQL::sqlResultFirstRow($stmt);
                        }
                        break;
                    case 'users':
                        if (($stmt = SQL::runQuery('EXECUTE W_AdminGetUsers @page = ?, @perpage = ?', [$page, $perpage])) && $result = SQL::sqlResultToArray($stmt)) {
                            $tmp = [];

                            foreach ($result as $item) {
                                $total = $item['Total'];
                                array_push($tmp, new User($item));
                            }
                            $result = [
                                'page' => $page,
                                'perpage' => $perpage,
                                'total' => $total,
                                'totalpages' => ceil($total / $perpage),
                                'data' => $tmp
                            ];
                        }
                        break;
                    case 'sessions':
                        if (($stmt = SQL::runQuery('EXECUTE W_AdminGetActiveSessions @page = ?, @perpage = ?', [$page, $perpage])) && $result = SQL::sqlResultToArray($stmt)) {
                            $tmp = [];

                            foreach ($result as $item) {
                                $total = $item['Total'];
                                array_push(
                                    $tmp,
                                    [
                                        'id' => $item['id'],
                                        'ip' => $item['ip'],
                                        'expires' => Common::getHumanTime($item['expires'], true),
                                        'userid' => $item['ID_User'],
                                        'user' => [
                                            'id' => $item['ID_User'],
                                            'login' => $item['Login']
                                        ]
                                    ]
                                );
                            }
                            $result = [
                                'page' => $page,
                                'perpage' => $perpage,
                                'total' => $total,
                                'totalpages' => ceil($total / $perpage),
                                'data' => $tmp
                            ];
                        }
                        break;
                    case 'log':
                        if (($stmt = SQL::runQuery('EXECUTE W_AdminGetLog @page = ?, @perpage = ?', [$page, $perpage])) && $result = SQL::sqlResultToArray($stmt)) {
                            $tmp = [];
                            //Time	Event.Id	User.Id	User.Login	Video.Alias	Video.Name	Comment.Id	Comment.Text	Playlist.Id	Playlist.Name
                            foreach ($result as $item) {
                                $total = $item['Total'];
                                array_push(
                                    $tmp,
                                    [
                                        'time' => Common::getHumanTime($item['Time'], true),
                                        'event' => [
                                            'id' => $item['Event.Id']
                                        ],
                                        'user' => [
                                            'id' => $item['User.Id'],
                                            'login' => $item['User.Login']
                                        ],
                                        'hasvideo' => isset($item['Video.Alias']) && isset($item['Video.Name']),
                                        'video' => isset($item['Video.Alias']) && isset($item['Video.Name']) ? [
                                            'id' => $item['Video.Id'],
                                            'alias' => $item['Video.Alias'],
                                            'name' => $item['Video.Name']
                                        ] : ['id' => $item['Video.Id'] ?? 0],
                                        'hascomment' => isset($item['Comment.Id']) && isset($item['Comment.Text']),
                                        'comment' => isset($item['Comment.Id']) && isset($item['Comment.Text']) ? [
                                            'id' => $item['Comment.Id'],
                                            'text' => $item['Comment.Text']
                                        ] : ['id' => $item['Comment.Id'] ?? 0],
                                        'hasplaylist' => isset($item['Playlist.Id']) && isset($item['Playlist.Name']),
                                        'playlist' => isset($item['Playlist.Id']) && isset($item['Playlist.Name']) ? [
                                            'id' => $item['Playlist.Id'],
                                            'name' => $item['Playlist.Name']
                                        ] : ['id' => $item['Playlist.Id'] ?? 0]
                                    ]
                                );
                            }
                            $result = [
                                'page' => $page,
                                'perpage' => $perpage,
                                'total' => $total,
                                'totalpages' => ceil($total / $perpage),
                                'data' => $tmp
                            ];
                        }
                        break;
                }
                if (isset($result)) {
                    ResponseHelper::successResponse($result);
                }
            }
            break;
    }

    ResponseHelper::errorResponse(httpCode: 400);
}

ResponseHelper::errorResponse(httpCode: 403);
