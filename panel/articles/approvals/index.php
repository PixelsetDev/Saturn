<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../../common/global_private.php';
            include_once __DIR__.'/../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../common/panel/theme.php';
            include_once __DIR__.'/../../../common/processes/pages.php';
            include_once __DIR__.'/../../../common/processes/gui/pages.php';
        ?>

        <title>Articles - Saturn Panel</title>

        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'permission') {
                $errorMsg = 'Error: You do not have the required permissions to do that.';
            } elseif ($error == 'new') {
                $errorMsg = 'Error: There was a problem creating a new article.';
            } else {
                $errorMsg = 'Error: An unknown error occurred.';
            }
        }

        if (get_user_roleID($_SESSION['id']) < 3) {
            header('Location: '.CONFIG_INSTALL_URL.'/panel/pages?error=permission');
        }

        ?>

    </head>
    <body class="mb-8 dark:text-white dark:bg-neutral-700">
        <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white">Articles</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <?php
        if (isset($errorMsg)) {
            echo alert('ERROR', $errorMsg);
            log_error('ERROR', $errorMsg);
        }
        unset($errorMsg);
        if (isset($successMsg)) {
            echo alert('SUCCESS', $successMsg);
        }
        unset($successMsg);
        ?>
            <div class="px-4 py-6 sm:px-0">
                <?php
                $role = get_user_roleID($_SESSION['id']);
                $i = 1;
                $article = get_article_title($i);
                $found = false;
                while ($article != null) {
                    if (get_article_status($i) == 'PENDING') {
                        echo '            <div>
                                    <div name="'.$article.'" id="'.$article.'">
                                        <div class="flex-grow relative pt-1 mb-2">
                                            <div class="flex items-center justify-between">
                                                <h1 class="text-xl font-bold leading-tight text-gray-900 dark:text-white mr-2">'.$article.'</h1>
                                                <p class="text-gray-500 dark:text-white">Requested by '.get_user_fullname(get_article_author_id($i)).'</p>
                                            <div>
                                            <div class="flex items-center justify-between space-x-2">
                                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-yellow-500 dark:text-white bg-yellow-200 dark:bg-yellow-600">Pending</span>
                                                <a href="'.CONFIG_INSTALL_URL.'/panel/articles/approvals/approve/?articleID='.$i.'" class="transition-all duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-neutral-900 dark:text-white bg-neutral-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-neutral-300 md:py-1 md:text-rg md:px-10">
                                                    Approve
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <br><hr><br>';
                        $found = true;
                    }
                    unset($article);
                    $i++;
                    $article = get_article_title($i);
                }
                if (!$found) {
                    ?>
            <div class="flex-grow relative pt-1 mb-2">
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold leading-tight text-gray-900 dark:text-white mr-2">No pending approvals.</h1>
                </div>
            </div>
            <?php
                } ?>
        </div>
    </body>
</html>