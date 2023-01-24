<!DOCTYPE html>
<html lang="<?= WEBSITE_LANGUAGE; ?>">
    <head>
        <title>Error <?= $ErrorCode; ?> - <?=WEBSITE_NAME; ?></title>
    </head>
    <body>
        <h1 class="text-header">
            Error <?= $ErrorCode; ?>
        </h1>
        <p class="text-body">
            <?= $ErrorDescription; ?>
        </p>
        <p class="text-error">
            <?= $ErrorMessage; ?>
        </p>
    </body>
</html>