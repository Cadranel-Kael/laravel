<?php

require __DIR__ . '/MyPDO.php';
$file =  __DIR__ . '/../env.local.ini';
try {
    $connection = new MyPDO($file);
    deleteTables($connection);
    createTables($connection);
    seedTables($connection);
} catch (Exception $e) {
    echo ($e->getMessage());
};

function deleteTables(MyPDO $connection): void
{
    $sql = <<<sql
    DROP TABLE IF EXISTS `notes`;
sql;
    $connection->exec($sql);
    $sql = <<<sql
    DROP TABLE IF EXISTS `users`;
sql;
    $connection->exec($sql);
}
function createTables(MyPDO $connection): void
{
    $sql = <<<sql
    CREATE TABLE `users` (
      `id` int unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
sql;
    $connection->exec($sql);
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
    $connection->exec($sql);
}
function seedTables(MyPDO $connection): void
{
    $sql = <<<sql
    INSERT INTO `users` (`id`, `name`, `email`)
    VALUES
        (1,'Dominique','dominique.vilain@hepl.be');

    INSERT INTO `notes` (`id`, `user_id`, `description`)
    VALUES
        (1,1,'Ma première note'),
        (2,1,'Ma deuxième note');
sql;
    $connection->exec($sql)
}
