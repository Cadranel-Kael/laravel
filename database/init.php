<?php

define('BASE_PATH', __DIR__ . '/../');
require BASE_PATH . 'core/functions.php';
require base_path('vendor/autoload.php');

$file = base_path('env.local.ini');
try {
    $database = new Core\Database($file);
    /* recreateDatabase($database); */
    deleteTables($database);
    createTables($database);
    seedTables($database);
} catch (Exception $e) {
    echo($e->getMessage());
};
function recreateDatabase(\Core\Database $database): void
{
    $sql = <<<sql
    DROP SCHEMA IF EXISTS `notes`;
    CREATE SCHEMA `notes`;
sql;

    $database->query($sql);
}

function deleteTables(Core\Database $database): void
{
    $sql = <<<sql
    DROP TABLE IF EXISTS `notes`;
sql;
    $database->query($sql);
    $sql = <<<sql
    DROP TABLE IF EXISTS `users`;
sql;
    $database->query($sql);
}

function createTables(Core\Database $database): void
{
    $sql = <<<sql
    CREATE TABLE `users` (
      `id` int unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
sql;
    $database->query($sql);
    $sql = <<<sql
    CREATE TABLE `notes` (
      `id` int unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int unsigned NOT NULL,
      `description` text NOT NULL,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

sql;
    $database->query($sql);
}

function seedTables(Core\Database $database): void
{
    $password = password_hash('change_this', PASSWORD_BCRYPT);
    $sql = <<<sql
    INSERT INTO `users` (`id`, `name`, `email`,`password`)
    VALUES
        (1,'Dominique','dominique.vilain@hepl.be','$password'),
        (2,'Myriam','myriam.dupont@hepl.be','$password'),
        (3,'Daniel','daniel.schreurs@hepl.be','$password');

    INSERT INTO `notes` (`id`, `user_id`, `description`)
    VALUES
        (1,1,'Ma première note de Dominique'),
        (2,1,'Ma deuxième note de Dominique'),
        (3,2,'Ma première note de Myriam'),
        (4,2,'Ma deuxième note de Myriam'),
        (5,3,'Ma première note de Daniel'),
        (6,3,'Ma deuxième note de Daniel');
sql;
    $database->query($sql);
}
