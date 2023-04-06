<?php
include_once __DIR__ . '/arrayable.php';
include_once __DIR__ . '/video.php';
include_once __DIR__ . '/locale.php';
include_once __DIR__ . '/common.php';

class Comment implements Arrayable
{
    private int $id, $userid, $videoid;
    private string $text;
    private DateTime $time;

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID_Comment'];
        $this->userid = $dbdata['ID_User'];
        $this->videoid = $dbdata['ID_Video'];
        $this->text = trim($dbdata['Text']);
        $this->time = $dbdata['Time'];
        //date_timezone_set($this->time, new DateTimeZone('GMT+03:00'));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getVideoId()
    {
        return $this->videoid;
    }

    public function getText()
    {
        return htmlspecialchars($this->text);
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getHumanTime()
    {
        return Common::getHumanTime($this->getTime());
    }

    public function getUser()
    {
        return User::getUser($this->getUserId());
    }

    public function getVideo()
    {
        return Video::getById($this->getVideoId());
    }

    public function toArray()
    {
        $user = $this->getUser();
        return [
            'id' => $this->getId(),
            //'userid' => $this->getUserId(),
            //'videoid' => $this->getVideoId(),
            'humantime' => $this->getHumanTime(),
            'text' => $this->getText(),
            'user' => [
                'id' => $user->getId(),
                'name' => $user->getName()
            ]
        ];
    }

    public static function arrayToArray(array $array)
    {
        $out = [];
        foreach ($array as $item) {
            if ($item instanceof Comment) {
                array_push($out, $item->toArray());
            }
        }
        return $out;
    }

    public static function getAllByVideoId(int $id)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetCommentByID @id = ?",
            [$id]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return new Comment($row);
            }
        }
        return false;
    }


    public static function getById(int $id)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetCommentByID @id = ?",
            [$id]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return new Comment($row);
            }
        }
        return false;
    }
}
