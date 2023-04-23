<?php

class SQL
{
    private static $conn;

    private static function connect()
    {
        if (!isset(self::$conn) || is_null(self::$conn)) {
            $data = json_decode(file_get_contents(__DIR__ . '/sql.json'), true);

            self::$conn = sqlsrv_connect($data['server'], $data['connection']);
        }
        if (!self::$conn) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    public static function sqlResultToArray($stmt)
    {
        $data = [];

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            self::convertRowToUTF8($row);
            array_push($data, $row);
        }
        sqlsrv_free_stmt($stmt);

        return $data;
    }

    public static function sqlResultFirstRow($stmt)
    {
        if ($stmt) {
            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                sqlsrv_free_stmt($stmt);
            }
            self::convertRowToUTF8($row);
            return $row;
        } else {
            return null;
        }
    }

    public static function sqlResult($stmt)
    {
        if ($stmt) {
            return sqlsrv_fetch($stmt);
        }
    }

    public static function runQuery(string $query, array $params = null)
    {
        self::connect();
        if ($params == null || sizeof($params) == 0) {
            return sqlsrv_query(self::$conn, $query);
        } else {
            self::convertRowToCP1251($params);
            $stmt = sqlsrv_prepare(self::$conn, $query, $params);
            return sqlsrv_execute($stmt) ? $stmt : false;
        }
    }

    public static function getErrors()
    {
        return print_r(sqlsrv_errors(), true);
    }

    private static function convertRowToUTF8(&$row)
    {
        if ($row) {
            foreach ($row as $key => $value) {
                if (gettype($value) == 'string') {
                    $row[$key] = iconv('cp1251', 'UTF-8', $value);
                }
            }
            return $row;
        }
    }

    private static function convertRowToCP1251(&$row)
    {
        foreach ($row as $key => $value) {
            if (gettype($value) == 'string') {
                $row[$key] = iconv('UTF-8', 'cp1251',  $value);
            }
        }
        return $row;
    }
}
