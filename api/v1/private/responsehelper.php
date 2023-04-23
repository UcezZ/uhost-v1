<?php
include_once __DIR__ . '/../../../private/arrayable.php';

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    ResponseHelper::sendCORS();
    http_response_code(200);
    exit;
}

/**
 * API response helper
 */
class ResponseHelper
{
    /**
     * Sends CORS-related headers
     * Also used for `OPTIONS` response
     */
    public static function sendCORS()
    {
        header('Access-Control-Allow-Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers: Authorization,Content-Type,Accept,Origin,User-Agent,DNT,Cache-Control');
        header('Access-Control-Allow-Methods: GET,POST');
    }

    /**
     * Default response
     * @param array $data Response payload
     * @param int $httpCode Response code
     * @param bool $success Success flag
     */
    private static function defaultResponse(array $data = null, int $httpCode = 200, bool $success = true)
    {
        self::sendCORS();
        http_response_code($httpCode);
        header('Content-Type: application/json');

        print json_encode([
            'success' => $success,
            'result' => $data
        ]);
        exit;
    }

    /**
     * Default error response
     * @param array $data Response payload
     * @param int $httpCode Response code
     */
    public static function errorResponse(mixed $data = null, int $httpCode = 400)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }

        self::defaultResponse($data, $httpCode, false);
    }

    /**
     * Default error message response
     * @param string $message Response message
     * @param string $caption Response caption *(if using dialog window)*
     * @param int $httpCode Response code
     */
    public static function errorMessage(string $message = '', string $caption = '', int $httpCode = 400)
    {
        self::errorResponse(
            [
                'message' => $message,
                'caption' => $caption
            ],
            $httpCode
        );
    }

    /**
     * Convert Arrayable instances to array recursively
     * @param array $data Response payload
     */
    private static function arrayableToArrayRecursive(mixed &$data)
    {
        if ($data instanceof Arrayable) {
            $data = $data->toArray();
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                self::arrayableToArrayRecursive($data[$key]);
            }
        }
        // foreach ($data as $key => $value) {
        //     if (is_array($value)) {
        //         self::arrayableToArrayRecursive($data[$key]);
        //     }
        //     if ($value instanceof Arrayable) {
        //         // $data[$key] = $value->toArray();
        //         print_r($value->toArray());
        //     }
        // }
    }

    /**
     * Default success response
     * @param array $data Response payload
     */
    public static function successResponse(mixed $data = null)
    {
        self::arrayableToArrayRecursive($data);

        self::defaultResponse($data, 200, true);
    }

    /**
     * Default success message response
     * @param string $message Response message
     * @param string $caption Response caption *(if using dialog window)*
     */
    public static function successMessage(string $message = 'ok', string $caption = '')
    {
        self::successResponse([
            'message' => $message,
            'caption' => $caption
        ]);
    }
}
