<?php
use Saturn\SecurityManager\XSS;

$XSS = new XSS();
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __('Error'); ?> <?= out($ErrorCode); ?> - <?= out(WEBSITE_NAME); ?></title>
        <link rel="stylesheet" type="text/css" href="<?= out(WEBSITE_ROOT); ?>/Assets/CSS/Saturn.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body class="body">
        <nav class="navigation">
            <a href="/" class="navigation-item"><?= __('Home'); ?></a>
        </nav>

        <main class="main">
            <img src="<?= out(WEBSITE_ROOT); ?>/Assets/Images/Saturn-logo.webp" class="w-1/4 mx-auto">

            <div class="pb-8">
                <h1 class="text-header">
                    <?= __('Error'); ?> <?= out($ErrorCode); ?>: <?= out($ErrorName); ?>
                </h1>

                <p class="text-body">
                    <?= out($ErrorDescription); ?>
                </p>
            </div>

            <div class="pb-8">
                <h2 class="text-subheader">
                    <?= __('Error_Information'); ?>
                </h2>
                <p class="text-error">
                    <?= out($ErrorMessage); ?>
                </p>
            </div>

            <div class="pb-8">
                <h2 class="text-subheader">
                    <?= __('Server_Information'); ?>
                </h2>
                <p class="text-body pb-2">
                    <?= __('Request_URI'); ?> <code class="text-error-sm"><?= out($_SERVER['REQUEST_URI']); ?></code>
                </p>
                <p class="text-body pb-2">
                    <?= __('PHP_Version'); ?> <code class="text-error-sm"><?= out(PHP_VERSION); ?></code>
                </p>
                <?php if (PHP_VERSION > SATURN_RECOMMENDED_PHP) { ?><div class="alert-warning mb-2 mt-1">
                    <div class="alert-warning-icon">
                        <i class="fa-solid fa-exclamation-triangle"></i>
                    </div>
                    <p class="alert-warning-text">
                        <strong>Warning:</strong> Saturn recommends using PHP <?= SATURN_RECOMMENDED_PHP; ?> or higher.
                    </p>
                </div><?php }  ?>
                <p class="text-body pb-2">
                    <?= __('Operating_System'); ?> <code class="text-error-sm"> <?php if (PHP_OS == 'Darwin') {
    echo out('macOS (Darwin)');
} else {
    echo out(PHP_OS);
} ?></code>
                </p>
            </div>
        </main>
    </body>
</html>