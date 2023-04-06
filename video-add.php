<?php
include_once __DIR__ . '/private/tokenhandler.php';
include_once __DIR__ . '/private/user.php';
include_once __DIR__ . '/private/filestream.php';
include_once __DIR__ . '/private/video.php';
include_once __DIR__ . '/private/locale.php';
include_once __DIR__ . '/private/theme.php';

$currentuser = User::getUser();
if (!isset($currentuser)) {
    header('Location: ./');
    exit;
}

if (isset($_FILES['file'])) {
    if ($_FILES['file']['tmp_name']) {
        if (strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)) == 'mp4') {
            do {
                $alias = Video::newAlias();
                $uploadfile = __DIR__ . '/private/media/video/' . $alias . '.mp4';
            } while (file_exists($uploadfile));
            //print($uploadfile . '<br>' . $_FILES['file']['tmp_name'] . '<br>');
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $result = Video::prepare(0, $_POST['name'], $alias, isset($_POST['pub']));

                if (gettype($result) != 'object') {
                    if (file_exists($uploadfile)) {
                        unlink($uploadfile);
                        $errorMessage = Locale::getValue('upload.error.file.message');
                    }
                } else {
                    $video = $result;
                }
            }

            if ($result->register($currentuser->getId())) {
                $video = $result;
            }
        } else {
            $errorMessage = Locale::getValue('upload.error.format.message');
        }
    } else {
        $errorMessage = Locale::getValue('upload.error.message');
    }
}

require __DIR__ . '/private/views/video-add.php';
