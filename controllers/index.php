<?php
$heading = 'Dashboard';
$author = $_GET["author"] ?? "";

$books = [
    [
        "title" => "L’étranger",
        "author" => "Albert Camus",
        "release_date" => 1942,
    ],
    [
        "title" => "La peste",
        "author" => "Albert Camus",
        "release_date" => 1947,
    ],
    [
        "title" => "La conjuration des imbéciles",
        "author" => "John Kennedy Toole",
        "release_date" => 1980,
    ],
];

$decision = function (array $item) use ($author): bool {
    return $item["author"] === $author;
};

$filteredBooks = array_filter($books, $decision);
$authors = array_column($books, "author", "author");
require VIEWS_PATH . "/index.view.php";
