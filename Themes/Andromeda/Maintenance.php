<!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= WEBSITE_NAME; ?></title>
        <link rel="stylesheet" type="text/css" href="<?= SATURN_ROOT; ?>/Assets/CSS/Saturn.css">
    </head>
    <body>
        <nav class="navigation">
            <a href="/" class="navigation-item"><?= __('Home'); ?></a>
        </nav>

        <main class="main">
            <img src="<?= SATURN_ROOT; ?>/Storage/Theme/Logo.webp" class="w-1/4 mx-auto" alt="<?= WEBSITE_NAME; ?>">

            <div class="pb-8">
                <h1 class="text-header">
                    <?= __('Maintenance_Mode_Message_1'); ?>
                </h1>

                <p class="text-body mb-4">
                    <?= __('Maintenance_Mode_Message_2'); ?>
                </p>

                <a class="navigation-item dark:text-white" href="<?= SATURN_ROOT; ?>/account">
                    <?= __('Admin_Login'); ?>
                </a>
            </div>
        </main>
    </body>
</html>