<?php
include_once __DIR__ . '/user.php';
include_once __DIR__ . '/video.php';

class Playlist
{
    private int $id, $userid;
    private string $name;
    private array $entries;

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID_Playlist'];
        $this->userid = $dbdata['ID_User'];
        $this->name = $dbdata['Name'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userid;
    }

    public function getName()
    {
        return htmlspecialchars($this->name);
    }

    public function getEntries()
    {
        if (!isset($this->entries)) {
            $this->entries = [];
            if ($stmt = SQL::runQuery(
                "EXECUTE W_GetPlaylistEntries @plsid = ?",
                [$this->getId()]
            )) {
                if ($rows = SQL::sqlResultToArray($stmt)) {
                    foreach ($rows as $row) {
                        if ($video = Video::getById($row['ID_Video'])) {
                            array_push($this->entries, $video);
                        }
                    }
                }
            }
        }

        return $this->entries;
    }


    public function indexOfEntry(string $alias)
    {
        foreach ($this->getEntries() as $index => $video) {
            if (!strcasecmp($alias, $video->getAlias())) {
                return $index;
            }
        }

        return -1;
    }

    public static function get(int $id)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetPlaylist @id = ?",
            [$id]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return new Playlist($row);
            }
        }
    }

    public static function getAll(?int $userid = 0)
    {
        if (!$userid) {
            return ($user = User::getUser()) ? self::getAll($user->getId()) : null;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetPlaylistsByUser @id = ?",
            [$userid]
        )) {
            if ($rows = SQL::sqlResultToArray($stmt)) {
                $plss = [];
                foreach ($rows as $row) {
                    if ($pls = new Playlist($row)) {
                        array_push($plss, $pls);
                    }
                }
                return $plss;
            }
        }
    }

    public static function create(string $name)
    {
        if (!($user = User::getUser())) {
            return -2;
        }
        if ($stmt = SQL::runQuery(
            "EXECUTE W_AddPlaylist @userid = ?, @name = ?",
            [$user->getId(), $name]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }
        return -1;
    }

    public static function count(User $user)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_GetPlaylistCountByUserID @id = ?",
            [$user->getId()]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                return $row['cnt'];
            }
        }
        return -1;
    }

    public function edit(string $name)
    {
        if (!($user = User::getUser())) {
            return -2;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_EditPlaylist @userid = ?, @plsid = ?, @name = ?",
            [$user->getId(), $this->getId(), $name]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }

        return -1;
    }

    public function delete()
    {
        if (!($user = User::getUser())) {
            return -2;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_RemovePlaylist @userid = ?, @plsid = ?",
            [$user->getId(), $this->getId()]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }

        return -1;
    }

    public function addVideo(Video $video)
    {
        if (!($user = User::getUser())) {
            return -2;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_AddPlaylistEntry @userid = ?, @plsid = ?, @videoid = ?",
            [$user->getId(), $this->getId(), $video->getId()]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }
        return -1;
    }

    public function removeVideo(Video $video)
    {
        if (!($user = User::getUser())) {
            return -2;
        }

        if ($stmt = SQL::runQuery(
            "EXECUTE W_RemovePlaylistEntry @userid = ?, @plsid = ?, @videoid = ?",
            [$user->getId(), $this->getId(), $video->getId()]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }
        return -1;
    }
}
