<?php session_start();
    ob_start();
    include_once(__DIR__.'/../../../assets/common/global_private.php');

    $articleID = checkInput('DEFAULT', $_GET['articleID']);

    global $conn;

    if(empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
    }
    if(isset($_POST['title'])) {
        if ($_POST['title'] != null) {
            if ($_POST['content'] != null) {
                if(CONFIG_ARTICLE_APPROVALS) {
                    update_article_status($articleID,'PENDING');
                    update_article_title($articleID, checkInput('DEFAULT',$_POST['title']));
                    update_article_content($articleID, checkInput('HTML',$_POST['content']));
                    update_article_references($articleID, checkInput('HTML',$_POST['references']));
                    log_all('SATURN][ARTICLES',get_user_fullname($_SESSION['id']).' edited page with ID: '.$articleID.' ('.get_article_title($articleID).'). The edit is pending approval.');
                } else {
                    update_article_title($articleID, checkInput('DEFAULT',$_POST['title']));
                    update_article_content($articleID, checkInput('HTML',$_POST['content']));
                    update_article_references($articleID, checkInput('HTML',$_POST['references']));
                    log_all('SATURN][ARTICLES',get_user_fullname($_SESSION['id']).' edited article with ID: '.$articleID.' ('.get_article_title($articleID).').');
                }
            } else {
                $errorMsg = "Article requires content.";
                header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$articleID.'&error='.$errorMsg);
                exit;
            }
        } else {
            $errorMsg = "Article requires a title.";
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$articleID.'&error='.$errorMsg);
            exit;
        }
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
        include_once(__DIR__.'/../../../assets/common/panel/theme.php');
        ?>

        <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js" integrity="sha256-5RjTlnB92dAMNEPY6q0rX2AusjFwvVf1YHHikzobEss=" crossorigin="anonymous"></script>
        <title>Article Editor - Saturn Panel</title>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Article Editor: <?php $title = get_article_title($articleID); $title = mysqli_real_escape_string($conn, $title); echo $title; ?></h1>
            </div>
        </header>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?articleID=<?php echo $articleID; ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php
            if(isset($_GET['error'])) {
                alert('ERROR', $_GET['error']);
            } else if(isset($_GET['success'])) {
                alert('SUCCESS', $_GET['success']);
            }
            ?>

            <div class="py-6">
                <h2 class="text-2xl mb-2 font-bold my-2">Title</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_TITLE_CHARS; ?> Characters.</p>
                <textarea name="title" id="title" maxlength="60" class="w-full border"><?php
                    $title = get_article_title($articleID);
                    $title = checkOutput('DEFAULT', $title);
                    echo $title;
                    unset($title);
                    ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2">Content</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_ARTICLE_CHARS-10000; ?> Characters.</p>
                <textarea name="content" id="content"><?php
                    $content = get_article_references($articleID);
                    $content = checkOutput('HTML', $content);
                    echo $content;
                    unset($content);
                    ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2">References</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_REFERENCES_CHARS-2000; ?> Characters.</p>
                <textarea name="references" id="references"><?php
                    $references = get_article_references($articleID);
                    $references = checkOutput('HTML', $references);
                    echo $references;
                    unset($references);
                    ?></textarea>
            </div>

            <div class="flex space-x-4">
                <input type="submit" id="submit" name="submit" value="Save" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-1 md:text-rg md:px-10">
                <a href="<?php echo CONFIG_INSTALL_URL;?>/panel/articles" class="transition-all duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                    Cancel
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