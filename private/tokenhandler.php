<?php
include_once __DIR__ . '/sql.php';
include_once __DIR__ . '/common.php';

class TokenHandler
{
    private const TokenPrefix = 'UcezZ ';
    private const TokenPrefixLength = 6;
    private const TokenLength = 32;

    private static function erase()
    {
        if (isset($_COOKIE['token'])) {
            setcookie('token', '', -1);
        }
    }

    public static function check(string $token = null)
    {
        if (isset($token) && strlen($token) == self::TokenLength) {
            $useCookie = false;
        } else if (
            isset($_SERVER['HTTP_AUTHORIZATION']) &&
            strlen($_SERVER['HTTP_AUTHORIZATION']) == self::TokenPrefixLength + self::TokenLength &&
            substr($_SERVER['HTTP_AUTHORIZATION'], 0, self::TokenPrefixLength) == self::TokenPrefix
        ) {
            $useCookie = false;
            $token = substr($_SERVER['HTTP_AUTHORIZATION'], self::TokenPrefixLength);
        } else if (isset($_COOKIE['token']) && strlen($_COOKIE['token']) == self::TokenLength) {
            $useCookie = true;
            $token = $_COOKIE['token'];
        }

        if (isset($token) && $stmt = SQL::runQuery('EXECUTE W_CheckToken @token = ?, @ip = ?', [$token, Common::getClientIp()])) {
            $result = SQL::sqlResultFirstRow($stmt);
            if (isset($result['ERROR']) && $result['ERROR'] == 0) {
                if ($useCookie && !headers_sent()) {
                    setcookie('token', $token, date_timestamp_get($result['EXPIRATION']));
                }
                return $token;
            }
        }

        self::erase();

        return false;
    }
}
