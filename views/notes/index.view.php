<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full">
    <div class="min-h-full">
        <?php require base_path('views/partials/nav.view.php') ?>
        <?php require base_path('views/partials/header.view.php') ?>
        <main>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <!-- Replace with your content -->
                <div class="px-4 py-6 sm:px-0">
                    <div class="h-96 rounded-lg border-4 border-dashed border-gray-200">
                        <?php if (count($notes)) : ?>
                            <?php foreach ($notes as $note) : ?>
                                <article>
                                    <p><a class="underline text-blue-500" href="/note?id=<?= $note->id; ?>"><?= htmlspecialchars($note->description) ?></a></p>
                                </article>
                            <?php endforeach ?>
                        <?php else : ?>
                            <p>It seems that you haven't posted any note yet. Would you like to <a href="/notes/create" class="text-blue-500 underline">create one</a> ?</p>
                        <?php endif ?>
                    </div>
                    <div><a class="text-blue-500 underline" href="/notes/create">Create a new note</a></div>
                </div>
                <!-- /End replace -->
            </div>
        </main>
    </div>

</body>

</html>
