<?php
include_once __DIR__ . '/tokenhandler.php';
include_once __DIR__ . '/sql.php';
include_once __DIR__ . '/arrayable.php';
include_once __DIR__ . '/common.php';

class User implements Arrayable
{
    private int $id, $roleID, $videos, $playlists;
    private string $name, $login, $info, $locale, $theme, $role;

    public function __construct(array $dbdata)
    {
        $this->id = $dbdata['ID_User'];
        $this->name = $dbdata['Name'];
        $this->login = $dbdata['Login'];
        $this->info = $dbdata['Info'];
        $this->roleID = $dbdata['ID_Role'];
        $this->locale = $dbdata['Locale'];
        $this->theme = $dbdata['Theme'];
        $this->role = $dbdata['Role'] ?? '';
        $this->videos = $dbdata['Videos'] ?? 0;
        $this->playlists = $dbdata['Playlists'] ?? 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getRoleID()
    {
        return $this->roleID;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function isAdmin()
    {
        return $this->roleID == 1;
    }

    public static function register(string $login, string $password, string $name)
    {
        $pwdhash = md5($password);

        if ($stmt = SQL::runQuery(
            "EXECUTE W_Register @login = ?, @pwdhash = ?, @name = ?, @info = ?",
            [$login, $pwdhash, $name, '']
        )) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                if (isset($result['ERROR'])) {
                    return !$result['ERROR'];
                }
            }
        }
        return false;
    }

    public static function login(string $login, string $password, bool $useCookie = true)
    {
        $pwdhash = md5($password);

        if ($stmt = SQL::runQuery("EXECUTE W_Login @login = ?, @pwdhash = ?, @ip = ?", [$login, $pwdhash, Common::getClientIp()])) {
            if ($result = SQL::sqlResultFirstRow($stmt)) {
                if (!isset($result['ERROR'])) {
                    if ($useCookie) {
                        setcookie('token', $result['TOKEN'], date_timestamp_get($result['EXPIRATION']));
                    }

                    return $result['TOKEN'];
                }
            }
        }

        return false;
    }

    public static function logout()
    {
        while ($token = TokenHandler::check()) {
            SQL::runQuery("EXECUTE W_Logout @token = ?", [$token]);
        }
    }

    public static function getUser(?int $id = 0, ?string $token = null)
    {
        if ($id) {
            $stmt = SQL::runQuery("EXECUTE W_GetUser @id = ?", [$id]);
        } else {
            if (!$token) {
                $token = TokenHandler::check();
            }
            if ($token) {
                $stmt = SQL::runQuery("EXECUTE W_GetUser @token = ?", [$token]);
            }
        }

        if (isset($stmt) && $result = SQL::sqlResultFirstRow($stmt)) {
            $user = new User($result);
            return $user;
        }
    }

    public static function getRoles()
    {
        if ($stmt = SQL::runQuery("EXECUTE WS_GetRoleCollection")) {
            if ($result = SQL::sqlResultToArray($stmt)) {
                $collection = [];
                foreach ($result as $value) {
                    $collection[$value['id']] = $value['name'];
                }
                return $collection;
            }
        }
    }

    public function edit(string $name, string $info, string $theme, string $locale)
    {
        if ($stmt = SQL::runQuery(
            "EXECUTE W_EditUser @id = ?, @name = ?, @info = ?, @theme = ?, @locale = ?",
            [$this->getId(), $name, $info, $theme, $locale]
        )) {
            if ($row = SQL::sqlResultFirstRow($stmt)) {
                if (isset($row['ERROR'])) {
                    return $row['ERROR'];
                }
            }
        }
        return 2;
    }

    public function changePassword(string $oldPassword, string $newPassword)
    {
        $oldPassword = md5($oldPassword);
        $newPassword = md5($newPassword);

        if (($stmt = SQL::runQuery(
                'EXECUTE W_ChangePassword @id = ?, @oldpwdhash = ?, @newpwdhash = ?',
                [$this->getId(), $oldPassword, $newPassword]
            )) && ($row = SQL::sqlResultFirstRow($stmt)) &&
            (isset($row['ERROR']))
        ) {
            return $row['ERROR'];
        }
        return 2;
    }

    public function toArray()
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "login" => $this->getLogin(),
            "roleId" => $this->getRoleID(),
            "role" => $this->getRole(),
            "info" => $this->getInfo(),
            "locale" => $this->getLocale(),
            "theme" => $this->getTheme(),
            "isadmin" => $this->isAdmin(),
            "videos" => $this->videos,
            "playlists" => $this->playlists
        ];
    }
}
