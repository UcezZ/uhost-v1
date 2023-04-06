<?php
include_once __DIR__ . '/../../../private/user.php';
include_once __DIR__ . '/../../../private/video.php';
include_once __DIR__ . '/../../../private/locale.php';
include_once __DIR__ . '/../responsehelper.php';

$currentuser = User::getUser();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['v']) && strlen($_GET['v']) < 9) {
            $video = Video::getByAlias($_GET['v']);
            if ($video) {
                ResponseHelper::successResponse($video);
            } else {
                ResponseHelper::errorMessage(Locale::getValue('video.error.notfound.message'), httpCode: 404);
            }
        }

        $perpage = isset($_GET['perpage']) && filter_input(INPUT_GET, 'perpage', FILTER_VALIDATE_INT) ? $_GET['perpage'] : 16;
        $page = isset($_GET['page']) && filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ? $_GET['page'] : 1;
        $userId = isset($_GET['u']) && filter_input(INPUT_GET, 'u', FILTER_VALIDATE_INT) && $_GET['u'] > 0 ? $_GET['u'] : 0;
        $currentUserId = isset($currentuser) ? $currentuser->getId() : 0;

        if ($userId) {
            $videoCollection = Video::getAllByUserId($userId, $currentUserId, $perpage, $page);
        } else {
            $videoCollection = Video::getRandom($perpage, $currentUserId);
        }

        if (sizeof($videoCollection)) {
            $total = Video::getAllByUserIdCount($userId, $currentUserId);
            $data = [];

            foreach ($videoCollection as $value) {
                array_push($data, $value->toArray());
            }

            ResponseHelper::successResponse([
                'page' => $page,
                'perpage' => $perpage,
                'total' => $total,
                'totalpages' => ceil($total / $perpage),
                'data' => $data
            ]);
        } else {
            ResponseHelper::errorMessage(
                isset($_GET['u']) && isset($currentuser) && $currentuser->getId() != $_GET['u'] ?
                    Locale::getValue('video.error.novideos.user.message') :
                    Locale::getValue('video.error.novideos.message'),
                404
            );
        }
        break;
    case 'POST':
        if (!isset($currentuser)) {
            ResponseHelper::errorMessage(Locale::getValue('common.error.unauthorized'), '', 401);
        }

        if (isset($_FILES['file'])) {
            if ($_FILES['file']['tmp_name']) {
                if (strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)) == 'mp4') {
                    do {
                        $alias = Video::newAlias();
                        $uploadfile = __DIR__ . '/../../../private/media/video/' . $alias . '.mp4';
                    } while (file_exists($uploadfile));

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        $result = Video::prepare(0, $_POST['name'], $alias, isset($_POST['ispublic']) && $_POST['ispublic'] == 'true');

                        if (gettype($result) != 'object') {
                            if (file_exists($uploadfile)) {
                                unlink($uploadfile);
                                $errorMessage = Locale::getValue('upload.error.file.message');
                            }
                        }
                    }

                    if (isset($result) && $result->register($currentuser->getId())) {
                        ResponseHelper::successResponse($result);
                    }
                } else {
                    $errorMessage = Locale::getValue('upload.error.format.message');
                }
            } else {
                $errorMessage = Locale::getValue('upload.error.message');
            }
        } else {
            $errorMessage = Locale::getValue('upload.error.message1');
        }

        if (isset($errorMessage)) {
            ResponseHelper::errorMessage($errorMessage, Locale::getValue('upload.error'));
        }
        break;
    default:
        ResponseHelper::errorMessage(Locale::getValue('common.error.notfound'), '', 404);
        break;
}
