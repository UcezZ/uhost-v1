<?php
include_once __DIR__ . '/sql.php';
include_once __DIR__ . '/filestream.php';
include_once __DIR__ . '/searchparams.php';
include_once __DIR__ . '/common.php';
include_once __DIR__ . '/arrayable.php';

class Video implements Arrayable
{
    private int $id, $userid, $duration;
    private string $name, $alias;
    private string|null $pathOverride;
    private bool $isPublic;
    private DateTime $time;
    private User $user;
    private const basePath = '/Projects/mirea/uHost/';

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID_Video'] ??  0;
        $this->userid = $dbdata['ID_User'];
        $this->duration = $dbdata['Duration'] ?? 0;
        $this->alias = $dbdata['Alias'];
        $this->name = $dbdata['Name'];
        $this->isPublic = $dbdata['Is_Public'];
        $this->pathOverride = isset($dbdata['Path_override']) ? $dbdata['Path_override'] : null;
        if (isset($dbdata['Time'])) {
            $this->time = $dbdata['Time'];
        }
        $this->user = User::getUser($this->getUserId());
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getName()
    {
        return htmlspecialchars($this->name);
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public function getTime()
    {
        return $this->time ?? null;
    }

    public function getHumanTime()
    {
        return $this->getTime() ? Common::getHumanTime($this->getTime()) : null;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getHumanDuration()
    {
        $h = intval($this->getDuration() / 3600);
        $m = intval(($this->getDuration() % 3600) / 60);
        $s = intval($this->getDuration() % 60);
        return ($h ? str_pad($h, 2, '00', STR_PAD_LEFT) . ':' : '') . str_pad($m, 2, '00', STR_PAD_LEFT) . ':' . str_pad($s, 2, '00', STR_PAD_LEFT);
    }

    private function getVideoPath()
    {
        return $this->pathOverride ?? __DIR__ . '/media/video/' . $this->getAlias() . '.mp4';
    }

    public function sendVideoStream(?bool $download = false)
    {
        $stream = new FileStream($this->getVideoPath(), 'video/mp4');
        if ($download) {
            $stream->send($this->getName() . '.mp4');
        } else {
            $stream->send();
        }
    }

    private function getThumbnailPath()
    {
        return __DIR__ . '/media/thumb/' . $this->getAlias() . '.jpg';
    }

    public function sendThumbnailStream()
    {
        if (!($file = fopen($this->getThumbnailPath(), 'rb'))) {
            if (!$this->createThumbnail()) {
                return $this->sendThumbnailStream();
            }
        } else {
            fclose($file);
        }

        $stream = new FileStream($this->getThumbnailPath(), 'image/jpg');
        $stream->send();
    }

    public function createThumbnail()
    {
        exec('C:\\SDK\\ffmpeg-n5.1.2-7-ga6e26053c2-win64-gpl-shared-5.1\\bin\\ffprobe.exe -v error -select_streams v:0 -show_entries stream=width,height:stream_tags=rotate -of csv=p=0 "' . $this->getVideoPath() . '"', $out, $result);

        $dims = $out ? explode(',', $out[0]) : [640, 640];

        if ($dims[0] > 640) {
            $scale = 640 / $dims[0];
            $dims[0] *= $scale;
            $dims[1] *= $scale;
        }

        if ($dims[1] > 640) {
            $scale = 640 / $dims[1];
            $dims[0] *= $scale;
            $dims[1] *= $scale;
        }

        if (sizeof($dims) > 2 || str_ends_with($out[0], '.')) {
            $t = $dims[0];
            $dims[0] = $dims[1];
            $dims[1] = $t;
        }

        exec('C:\\SDK\\ffmpeg-n5.1.2-7-ga6e26053c2-win64-gpl-shared-5.1\\bin\\ffmpeg.exe -y -i "' . $this->getVideoPath() . '" -vf "thumbnail,scale=' . $dims[0] . ':' . $dims[1] . '" -frames:v 1 -update 1 "' . $this->getThumbnailPath() . '"', $out, $result);

        return $result;
    }

    public function calculateDuration()
    {
        exec('C:\\SDK\\ffmpeg-n5.1.2-7-ga6e26053c2-win64-gpl-shared-5.1\\bin\\ffprobe.exe -v error -select_streams v:0 -show_entries stream=duration -of default=noprint_wrappers=1:nokey=1 "' . $this->getVideoPath() . '"', $out, $result);

        if ($result) {
            return false;
        } else {
            foreach ($out as $row) {
                if (floatval($row)) {
                    $this->duration = intval(floatval($row));
                    return true;
                }
            }
        }
        return false;
    }

    public static function newAlias()
    {
        if ($stmt = SQL::runQuery("EXECUTE W_NewAlias")) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                return $result['Alias'];
            }
        }
    }

    public static function prepare(int $userid, string $name, string $alias, bool $isPublic)
    {
        $v = new Video([
            'ID_User' => $userid,
            'Alias' => $alias,
            'Name' => $name,
            'Is_Public' => $isPublic
        ]);

        if (!$v->calculateDuration()) {
            return 1;
        }

        if ($v->createThumbnail()) {
            return 2;
        }
        //exec('C:\\SDK\\ffmpeg-n5.1.2-7-ga6e26053c2-win64-gpl-shared-5.1\\bin\\ffmpeg.exe -y -hwaccel cuda -i Z:\20220402_120048.mp4 -b:v 1536k -vcodec h264_nvenc -minrate 8k -maxrate 2048k -bufsize 256k -acodec aac -ar 48000 -ac 2 -b:a 96k Z:\out.mp4');
        return $v;
    }

    public function register(int $userid)
    {
        if (SQL::runQuery(
            "EXECUTE W_AddVideo @userid = ?, @name = ?, @dura = ?, @pub = ?, @alias = ?",
            [$userid, $this->getName(), $this->getDuration(), $this->getIsPublic(), $this->getAlias()]
        )) {
            $this->userid = $userid;
            return true;
        }
        return false;
    }

    public static function getByAlias(string $alias, int $userid = 0)
    {
        if (!$userid) {
            $userid = ($user = User::getUser()) ? $user->getId() : 0;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetVideoByAlias @userid = ?, @alias = ?",
            [$userid, $alias]
        )) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                return new Video($result);
            }
        }
        return false;
    }

    public static function getById(int $id)
    {
        $userid = ($user = User::getUser()) ? $user->getId() : 0;
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetVideoByID @userid = ?, @id = ?",
            [$userid, $id]
        )) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                return new Video($result);
            }
        }
        return false;
    }

    public static function getAllByUserId(int $userid, int $reqId = 0, int $perpage = 16, int $page = 1)
    {
        $videos = [];

        if (!$reqId && $user = User::getUser()) {
            $reqId = $user->getId();
        }
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetVideos @userid = ?, @req = ?, @perpage = ?, @page = ?",
            [
                $userid,
                $reqId,
                $perpage,
                $page
            ]
        )) {
            if ($result = SQL::sqlResultToArray($stmt)) {
                foreach ($result as $row) {
                    array_push($videos, new Video($row));
                }
            }
        }

        return $videos;
    }

    public static function getAllByUserIdCount(int $userid, int $reqId = 0)
    {
        if (!$reqId && $user = User::getUser()) {
            $reqId = $user->getId();
        }
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetVideosCount @userid = ?, @req = ?",
            [$userid, $reqId]
        )) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                return $result['CNT'];
            }
        }
    }

    public function delete()
    {
        $user = User::getUser();
        if ($this->userid == $user->getId() || $user->isAdmin()) {
            if (SQL::runQuery(
                "EXECUTE W_RemoveVideoByID @id = ?",
                [$this->getId()]
            )) {
                if (is_null($this->pathOverride) && file_exists($this->getVideoPath())) {
                    unlink($this->getVideoPath());
                }
                if (file_exists($this->getThumbnailPath())) {
                    unlink($this->getThumbnailPath());
                }
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function edit(string $name, bool $public)
    {
        $user = User::getUser();
        if ($this->userid == $user->getId() || $user->isAdmin()) {
            if (SQL::runQuery(
                "EXECUTE W_EditVideo @id = ?, @name = ?, @pub = ?",
                [$this->getId(), $name, $public]
            )) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    public function getThumbnailUrl()
    {
        return self::basePath . 'video.php?v=' . $this->getAlias() . '&q=thumbnail';
    }

    public function getVideoUrl()
    {
        return self::basePath . 'video.php?v=' . $this->getAlias() . '&q=video';
    }

    public function getDownloadUrl()
    {
        return self::basePath . 'video.php?v=' . $this->getAlias() . '&q=download';
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'userid' => $this->getUserId(),
            'duration' => $this->getDuration(),
            'name' => $this->getName(),
            'alias' => $this->getAlias(),
            'isPublic' => $this->getIsPublic(),
            'time' => $this->getTime()?->format('Y-m-d H:i:s'),
            'humantime' => $this->getHumanTime(),
            'user' => [
                'login' => $this->getUser()->getLogin(),
                'name' => $this->getUser()->getName()
            ],
            'humanduration' => $this->getHumanDuration(),
            'thumbUrl' => $this->getThumbnailUrl(),
            'videoUrl' => $this->getVideoUrl(),
            'downloadUrl' => $this->getDownloadUrl()
        ];
    }

    public static function count(User $user)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetVideoCountByUserID @id = ?",
            [$user->getId()]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return $row['cnt'];
            }
        }
        return -1;
    }

    public static function search(string $query, SearchParams $params)
    {
        $user = User::getUser();
        $mask = $query;
        while (str_contains($mask, ' ') || str_contains($mask, '%%')) {
            $mask = str_replace([' ', '%%'], '%', $mask);
        }
        $mask = trim($mask, " \t\n\r\0\x0B%");

        if (strlen($mask) == 0) {
            return 1;
        } else if (strlen($mask) < 3) {
            return 3;
        } else if (strlen($mask) > 30) {
            return 4;
        }

        $mask = str_replace('_', '[_]', $mask);

        if ($stmt = SQL::runQuery(
            "EXECUTE W_SearchVideo @querymask = ?, @perpage = ?, @page = ?, @userid = ?, @own = ?",
            ["%$mask%", $params->getPerPage(), $params->getPage(), $user ? $user->getId() : 0, $params->getOwn()]
        )) {
            if ($rows = SQL::sqlResultToArray($stmt)) {
                $result = [];
                foreach ($rows as $row) {
                    array_push($result, new Video($row));
                }
                return $result;
            }
        }
        return 2;
    }

    public static function getRandom(?int $count = 8, ?int $userId = 0)
    {
        if (!$userId && $user = User::getUser()) {
            $userId = $user->getId();
        }
        if (($stmt = SQL::runQuery(
                'EXECUTE W_GetRandomVideos @userid = ?, @limit = ?',
                [$userId, $count]
            )) &&
            $rows = SQL::sqlResultToArray($stmt)
        ) {
            $videos = [];
            foreach ($rows as $row) {
                array_push($videos, new Video($row));
            }
            return $videos;
        }
    }
}
