<?php

$author = $_GET["author"];

$books = [
	[
		"title" => "L’étranger",
		"author" => "Albert Camus"
	],
	[
		"title" => "La peste",
		"author" => "Albert Camus"
	],
	[
		"title" => "La conjuration des imbéciles",
		"author" => "John Kennedy Toole"
	]
];

$filteredBooks = [];

foreach ($books as $book) {
	if ($book["author"] === $author) {
		$filteredBooks[] = $book;
	}
}
$authors = array_column($books, "author", "author");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title></title>
</head>

<body>
	<h1>Ma collection de livres</h1>
	<?php foreach ($filteredBooks as $book) : ?>
		<article>
			<h2><?= $book["title"] ?></h2>
			<p>Écrit par : <?= $book["author"] ?></p>
		</article>
	<?php endforeach ?>
	<nav>
		<h2>Les auteurs</h2>
		<?php foreach ($authors as $bookAuthor) : ?>
			<a href="/?author=<?= $bookAuthor ?>"><?= $bookAuthor ?></a>
		<?php endforeach ?>
	</nav>
</body>

</html>
