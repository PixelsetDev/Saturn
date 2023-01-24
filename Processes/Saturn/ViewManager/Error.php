<?php
use Saturn\SecurityManager\XSS;
$XSS = new XSS();
?><!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title><?= __('Error'); ?> <?= out($ErrorCode); ?> - <?= out(WEBSITE_NAME); ?></title>
        <link rel="stylesheet" type="text/css" href="<?= out(WEBSITE_ROOT); ?>/Assets/CSS/Saturn.css">
    </head>
    <body class="body">
        <nav class="navigation">
            <a href="/" class="navigation-item">Home</a>
        </nav>

        <main class="main">
            <img src="<?= out(WEBSITE_ROOT); ?>/Assets/Images/Saturn-logo.webp" class="w-1/4 mx-auto">

            <div class="pb-8">
                <h1 class="text-header">
                    Error <?= out($ErrorCode); ?>: <?= out($ErrorName); ?>
                </h1>

                <p class="text-body">
                    <?= out($ErrorDescription); ?>
                </p>
            </div>

            <div class="pb-8">
                <h2 class="text-subheader">
                    Error Information
                </h2>
                <p class="text-error">
                    <?= out($ErrorMessage); ?>
                </p>
            </div>

            <div class="pb-8">
                <h2 class="text-subheader">
                    Server Information
                </h2>
                <p class="text-body pb-2">
                    Request URI: <code class="text-error-sm"><?= out($_SERVER['REQUEST_URI']); ?></code>
                </p>
                <p class="text-body pb-2">
                    PHP Version: <code class="text-error-sm"><?= out(PHP_VERSION); ?></code>
                </p>
                <p class="text-body pb-2">
                    Operating System: <code class="text-error-sm"><?= out(PHP_OS); ?></code>
                </p>
            </div>
        </main>
    </body>
</html>