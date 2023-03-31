<?php

namespace Core;

class Response
{
    public const BAD_REQUEST = 400;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;

    public static function abort($code = self::NOT_FOUND)
    {
        http_response_code($code);
        view("codes/{$code}.view.php");
        die();
    }
}
