<!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= WEBSITE_NAME ?> <?= __CP('ControlPanel'); ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="robots" content="noindex">
        <meta name="charset" content="<?= WEBSITE_CHARSET; ?>">

        <link rel="stylesheet" type="text/css" href="<?= SATURN_ROOT; ?>/Assets/CSS/Saturn.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="body">
        <nav class="navigation">
            <div class="flex-grow self-center">
                <a href="<?= SATURN_ROOT; ?>">
                    <img src="<?= SATURN_ROOT; ?>/Storage/Theme/Logo.webp" alt="Logo" width="125px">
                </a>
            </div>
            <a href="<?= SATURN_ROOT; ?>/account" class="navigation-item"><?= __CP('Account'); ?></a>
        </nav>
        <main class="main">
            <h1 class="text-header-nopt"><?= __CP('Dashboard'); ?></h1>
            <div class="grid-block">
                <div class="grid-item grid-padding">
                    <span id="PageCount">Loading...</span>
                </div>
            </div>
        </main>

        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Console.js"></script>
        <script src="<?= SATURN_ROOT; ?>/Plugins/ControlPanel/Assets/JS/Statistics.js"></script>
    </body>
</html>