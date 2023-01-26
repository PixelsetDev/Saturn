<!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= WEBSITE_NAME; ?></title>
        <link rel="stylesheet" type="text/css" href="<?= WEBSITE_ROOT; ?>/Assets/CSS/Saturn.css">
    </head>
    <body>
        <nav class="navigation">
            <a href="/" class="navigation-item"><?= __('Home'); ?></a>
        </nav>

        <main class="main">
            <img src="<?= WEBSITE_ROOT; ?>/Storage/Theme/Logo.webp" class="w-1/4 mx-auto">

            <div class="pb-8">
                <h1 class="text-header">
                    <?= __('Maintenance'); ?>
                </h1>

                <a class="navigation-item text-white" href="<?= WEBSITE_ROOT; ?>/account">
                    <?= __('Login'); ?>
                </a>
            </div>
        </main>
    </body>
</html>