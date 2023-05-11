<?php

namespace Core;

class Validator
{
    public static function between(
        string $value,
        $min = 1,
        $max = INF
    ): bool {
        return (
            strlen(trim($value)) >= $min
            && strlen(trim($value)) <= $max
        );
    }

    public static function email(string $value): mixed
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function password(
        string $password,
        int $length = 8
    ): bool {
        $has_number = preg_match('/\d/', $password);
        $has_uppercase = preg_match('/[A-Z]/', $password);
        $has_symbol = preg_match('/[^a-zA-Z0-9\s]/', $password);

        return
            $has_number
            && $has_uppercase
            && $has_symbol
            && strlen(trim($password)) >= $length;
    }

    public static function exists(
        $value,
        string $table,
        string $field = 'id'
    ): \stdClass|bool {
        $db = new Database(ENV_FILE);

        return $db->query(
            "SELECT id FROM {$table} WHERE {$field} = :value",
            ['value' => $value]
        )->find();
    }

    public static function image(string $path): bool
    {
        $valid_types = [
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif',
        ];
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $type =  finfo_file($finfo, $path);
        finfo_close($finfo);
        return in_array($type, $valid_types);
    }
}
