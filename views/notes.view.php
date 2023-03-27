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
                        <h1>Ma liste de notes</h1>
                        <?php if (count($notes)) : ?>
                            <?php foreach ($notes as $note) : ?>
                                <article>
                                    <p><a class="underline text-blue-500" href="/note?id=<?= $note['id']; ?>"><?= $note["description"] ?></a></p>
                                </article>
                            <?php endforeach ?>
                        <?php else : ?>
                            <p>Il n’y a pas de note à afficher</p>
                        <?php endif ?>
                    </div>
                    <div><a class="text-blue-500 underline" href="/note-create">Create a new note</a></div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>

</body>

</html>
