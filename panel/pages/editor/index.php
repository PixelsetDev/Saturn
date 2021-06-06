<?php session_start();
    ob_start();
    include_once(__DIR__.'/../../../assets/common/global_private.php');

    $pageID = $_GET['pageID'];

    global $conn;

    if(empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = "application/x-www-form-urlencoded";
    }
    if(isset($_POST['title'])) {
        if ($_POST['title'] != null) {
            if ($_POST['content'] != null) {
                $title = checkInput('HTML', $_POST['title']);
                $content = checkInput('HTML',$_POST['content']);
                $references = checkInput('HTML',$_POST['references']);
                if (CONFIG_PAGE_APPROVALS == true) {
                    $myID = $_SESSION['id'];
                    $query = "UPDATE `".DATABASE_PREFIX."pages_pending` SET `title`='$title',`content`='$content',`reference`='$references',`user_id`='$myID' WHERE `id`='$pageID';";
                    unset($myID);
                    $rs = mysqli_query($conn,$query);
                    $successMsg = "Your edit has been saved and is currently pending approval.";
                    log_all('SATURN][PAGES',get_user_fullname($_SESSION['id']).' edited page with ID: '.$pageID.' ('.get_page_title($pageID).'). The edit is pending approval.');
                } else {
                    $query = "UPDATE `".DATABASE_PREFIX."pages` SET `title`='$title',`content`='$content',`reference`='$references' WHERE `id`='$pageID';";
                    $rs = mysqli_query($conn,$query);
                    $query = "INSERT INTO `".DATABASE_PREFIX."pages_history` (`id`, `page_id`, `user_id`, `timestamp`) VALUES (NULL, '".$pageID."','".$_SESSION['id']."', CURRENT_TIMESTAMP)";
                    $rs = mysqli_query($conn,$query);
                    $newEdits = get_user_edits($_SESSION['id'])+1;
                    update_user_edits($_SESSION['id'], $newEdits);
                    $successMsg = "Your edit has been saved.";
                    log_all('SATURN][PAGES',get_user_fullname($_SESSION['id']).' edited page with ID: '.$pageID.' ('.get_page_title($pageID).').');
                }
                header('Location: '.$_SERVER['PHP_SELF'].'/?pageID='.$pageID.'&success='.$successMsg);
                exit;
            } else {
                $errorMsg = "Page requires content.";
                header('Location: '.$_SERVER['PHP_SELF'].'/?pageID='.$pageID.'&error='.$errorMsg);
                exit;
            }
        } else {
            $errorMsg = "Page requires a title.";
            header('Location: '.$_SERVER['PHP_SELF'].'/?pageID='.$pageID.'&error='.$errorMsg);
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

        <script src="https://cdn.ckeditor.com/ckeditor5/26.0.0/classic/ckeditor.js"></script>
        <title>Saturn Panel</title>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Page Editor: <?php $title = get_page_title($pageID); $title = mysqli_real_escape_string($conn, $title); echo $title; ?></h1>
            </div>
        </header>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>/?pageID=<?php echo $pageID; ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php if(isset($_GET['error'])) { echo '<br><div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">'.$_GET['error'].'</h6>
                                </div>
                            </div><br>';} else if(isset($_GET['success'])) { echo '<br><div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2">
                                <div class="p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">'.$_GET['success'].'</h6>
                                </div>
                            </div><br>';} ?>

            <div class="py-6">
                <h2 class="text-2xl mb-2 font-bold my-2">Title</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_TITLE_CHARS; ?> Characters.</p>
                <textarea name="title" id="title" maxlength="60" class="w-full border"><?php
                        $pageStatus = get_page_status($pageID);
                        if ($pageStatus == 'green' OR $pageStatus == 'red' OR CONFIG_PAGE_APPROVALS == false) {
                            $title = get_page_title($pageID);
                            $title = checkOutput('HTML', $title); echo $title;
                        } else if ($pageStatus == 'yellow') {
                            $title = get_page_pending_title($pageID);
                            $title = checkOutput('HTML', $title); echo $title;
                        }
                        unset($title);
                ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2">Content</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_PAGE_CHARS-10000; ?> Characters.</p>
                <textarea name="content" id="content"><?php
                        if ($pageStatus == 'green' OR $pageStatus == 'red' OR CONFIG_PAGE_APPROVALS == false) {
                            $content = get_page_content($pageID);
                            $content = checkOutput('HTML', $content); echo $content;
                        } else if ($pageStatus == 'yellow') {
                            $content = get_page_pending_content($pageID);
                            $content = checkOutput('HTML', $content); echo $content;
                        }
                        unset($content);
                ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2">References</h2>
                <p class="mb-2">Max. <?php echo CONFIG_MAX_REFERENCES_CHARS-2000; ?> Characters.</p>
                <textarea name="references" id="references"><?php
                        if ($pageStatus == 'green' OR $pageStatus == 'red' OR CONFIG_PAGE_APPROVALS == false) {
                            $references = get_page_references($pageID);
                            $references = checkOutput('HTML', $references); echo $references;
                        } else if ($pageStatus == 'yellow') {
                            $references = get_page_pending_references($pageID);
                            $references = checkOutput('HTML', $references); echo $references;
                        }
                        unset($references);
                ?></textarea>
            </div>

            <div class="flex space-x-4">
                <input type="submit" id="submit" name="submit" value="Save" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 md:py-1 md:text-rg md:px-10">
                <a href="<?php echo CONFIG_INSTALL_URL;?>/panel/pages" class="transition-all duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
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