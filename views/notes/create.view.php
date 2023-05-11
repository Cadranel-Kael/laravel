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
                <form method="post" action="/notes" enctype="multipart/form-data">
                    <?php csrf_token() ?>
                    <div class="space-y-12">
                        <div class="border-b border-gray-900/10 pb-12">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Create a new note</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-600">Write something beautiful.</p>

                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                                <div class="col-span-full">
                                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">description</label>
                                    <div class="mt-2">
                                        <textarea id="description" name="description" rows="3" class="block px-1.5 w-full rounded-md border-0 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:py-1.5 sm:text-sm sm:leading-6"><?= $_SESSION['old']['description'] ?? '' ?></textarea>
                                    </div>
                                    <?php if (isset($_SESSION['errors']['description'])) : ?>
                                        <p><?= $_SESSION['errors']['description'] ?></p>
                                    <?php endif ?>
                                </div>
                                <div class="col-span-full">
                                    <label for="thumbnail">Thumbnail</label>
                                    <input type="file" name="thumbnail" id="thumbnail">
                                    <?php if (isset($_SESSION['errors']['thumbnail'])) : ?>
                                        <p><?= $_SESSION['errors']['thumbnail'] ?></p>
                                    <?php endif ?>
                                </div>
                                <div class="flex gap-x-6">
                                    <button type="submit" class="rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add the new note</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>

</html>
