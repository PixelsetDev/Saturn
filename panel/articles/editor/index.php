<?php session_start();
    ob_start();
    include_once __DIR__.'/../../../common/global_private.php';

    $articleID = checkInput('DEFAULT', $_GET['articleID']);

    if (get_article_author_id($articleID) != $_SESSION['id']) {
        internal_redirect('/panel/articles');
    }

    global $conn;

    if (empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
    }
    if (isset($_POST['title'])) {
        if ($_POST['title'] != null) {
            if ($_POST['content'] != null) {
                if (update_article_title($articleID, checkInput('DEFAULT', $_POST['title'])) &&
                    update_article_content($articleID, checkInput('HTML', $_POST['content'])) &&
                    update_article_references($articleID, checkInput('HTML', $_POST['references']))) {
                    $successMsg = __('Panel:Article_Saved');
                    header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.checkOutput('DEFAULT', $articleID).'&success='.checkOutput('DEFAULT', $successMsg));
                    log_all('SATURN][ARTICLES', get_user_fullname($_SESSION['id']).' '.__('Panel:Article_Edited_Log_1').' '.$articleID.' ('.get_article_title($articleID).'). '.__('Panel:Article_Edited_Log_2'));
                } else {
                    $errorMsg = __('Error:SaveEdit');
                    header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.checkOutput('DEFAULT', $articleID).'&error='.checkOutput('DEFAULT', $errorMsg));
                }
            } else {
                $errorMsg = __('Error:Article_NoContent');
                header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.checkOutput('DEFAULT', $articleID).'&error='.checkOutput('DEFAULT', $errorMsg));
                exit;
            }
        } else {
            $errorMsg = __('Error:Article_NoTitle');
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.checkOutput('DEFAULT', $articleID).'&error='.checkOutput('DEFAULT', $errorMsg));
            exit;
        }
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once __DIR__.'/../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../common/panel/theme.php';
        ?>

        <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js" integrity="sha256-5RjTlnB92dAMNEPY6q0rX2AusjFwvVf1YHHikzobEss=" crossorigin="anonymous"></script>
        <title><?php echo __('Panel:Articles'); ?> <?php echo __('Panel:Editor'); ?> - <?php echo __('General:Saturn').' '.__('Admin:Panel'); ?></title>

    </head>
    <body class="mb-8 dark:bg-neutral-700 dark:text-white">
        <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>
        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Articles'); ?> <?php echo __('Panel:Editor'); ?>: <?php $title = get_article_title($articleID); $title = mysqli_real_escape_string($conn, $title); echo $title; ?></h1>
            </div>
        </header>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?articleID=<?php echo $articleID; ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php
            if (isset($_GET['error'])) {
                echo alert('ERROR', $_GET['error']);
                log_error('ERROR', checkInput('DEFAULT', $_GET['error']));
            } elseif (isset($_GET['success'])) {
                echo alert('SUCCESS', $_GET['success']);
            }
            ?>

            <div class="py-6">
                <h2 class="text-2xl mb-2 font-bold my-2"><?php echo __('Panel:Title'); ?></h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_TITLE_CHARS; ?> <?php echo __('Panel:Characters'); ?></p>
                <textarea name="title" id="title" maxlength="60" class="w-full border"><?php
                    $title = get_article_title($articleID);
                    $title = checkOutput('DEFAULT', $title);
                    echo stripslashes($title);
                    unset($title);
                    ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2"><?php echo __('Panel:Content'); ?></h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_ARTICLE_CHARS - 10000; ?> <?php echo __('Panel:Characters'); ?></p>
                <textarea name="content" id="content"><?php
                    $content = get_article_content($articleID);
                    $content = checkOutput('HTML', $content);
                    echo stripslashes($content);
                    unset($content);
                    ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2"><?php echo __('Panel:References'); ?></h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_REFERENCES_CHARS - 2000; ?> <?php echo __('Panel:Characters'); ?></p>
                <textarea name="references" id="references"><?php
                    $references = get_article_references($articleID);
                    $references = checkOutput('HTML', $references);
                    echo stripslashes($references);
                    unset($references);
                    ?></textarea>
            </div>

            <div class="flex space-x-4">
                <input type="submit" id="submit" name="submit" value="<?php echo __('General:Save'); ?>" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles" class="transition-all duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                    <?php echo __('General:Cancel'); ?>
                </a>
            </div>
        </form>

        <script>
            ClassicEditor
                .create( document.querySelector( '#content' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#references' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    </body>
</html>