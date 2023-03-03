<?php

require __DIR__ . '/MyPDO.php';
$file =  __DIR__ . '/../env.local.ini';
try {
    $connection = new MyPDO($file);
    selectNotes($connection);
} catch (Exception $e) {
    echo ($e->getMessage());
};

function selectNotes(MyPDO $connection): void
{
    $sql = <<<sql
    SELECT * FROM notes WHERE id < :id
sql;
    $sth = $connection->prepare($sql);
    $sth->execute(['id' => 2]);
    $data = $sth->fetchAll();
    var_dump($data);
}
