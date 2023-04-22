<?php

namespace Core;

class Validator
{
    public static function between(string $value, $min = 1, $max = INF)
    {
        return (strlen(trim($value)) >= $min && strlen(trim($value)) <= $max);
    }

    public static function email(string $value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function password(string $password, int $length = 8)
    {
        $has_number = preg_match('/\d/', $password);
        $has_uppercase = preg_match('/[A-Z]/', $password);
        $has_symbol = preg_match('/[^a-zA-Z0-9\s]/', $password);

        return $has_number && $has_uppercase && $has_symbol && strlen(trim($password)) >= $length;
    }

    public static function exists($value, string $table, string $field = 'id'): array|bool
    {
        $db = new Database(ENV_FILE);
        return $db->query("SELECT id FROM {$table} WHERE {$field} = :value", ['value' => $value])->find();
    }
}
