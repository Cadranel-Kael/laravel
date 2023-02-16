<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php require VIEWS_PATH . '/partials/nav.view.php' ?>
        <?php require VIEWS_PATH . '/partials/header.view.php' ?>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="h-96 rounded-lg border-4 border-dashed border-gray-200">
                        <h1>Ma collection de livres</h1>
                        <?php if (count($filteredBooks)) : ?>
                            <?php foreach ($filteredBooks as $book) : ?>
                                <article>
                                    <h2><?= $book["title"] ?></h2>
                                    <p>Écrit par : <?= $book["author"] ?></p>
                                </article>
                            <?php endforeach ?>
                        <?php else : ?>
                            <p>Il n’y a pas de livre à afficher</p>
                        <?php endif ?>
                        <nav>
                            <h2>Les auteurs</h2>
                            <?php foreach ($authors as $bookAuthor) : ?>
                                <a href="/?author=<?= $bookAuthor ?>"><?= $bookAuthor ?></a>
                            <?php endforeach ?>
                        </nav>
                    </div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>

</body>

</html>
