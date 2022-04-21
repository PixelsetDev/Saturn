<?php session_start();
    ob_start();
    include_once __DIR__.'/../../../common/global_private.php';

    $pageID = checkInput('DEFAULT', $_GET['pageID']);

    global $conn;

    if (empty($_SERVER['CONTENT_TYPE'])) {
        $_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';
    }

    if (isset($_POST['discardRecovery'])) {
        unlink(__DIR__."/../../../storage/recovery/".$pageID.".srp");
        header ('Location: '.$_SERVER['PHP_SELF'].'?pageID='.$pageID);
        exit;
    } elseif (isset($_POST['loadRecovery'])) {
        $recoveredData = file_get_contents(__DIR__."/../../../storage/recovery/".$pageID.".srp");
        $recoveredData = json_decode($recoveredData);
        unlink(__DIR__."/../../../storage/recovery/".$pageID.".srp");
    }

    if (isset($_POST['submit'])) {
        if ($_POST['title'] != null) {
            if ($_POST['content'] != null) {
                $title = checkInput('HTML', $_POST['title']);
                $content = checkInput('HTML', $_POST['content']);
                $references = checkInput('HTML', $_POST['references']);
                if (CONFIG_PAGE_APPROVALS) {
                    $myID = $_SESSION['id'];
                    $query = 'UPDATE `'.DATABASE_PREFIX."pages_pending` SET `title`='$title',`content`='$content',`reference`='$references',`user_id`='$myID' WHERE `id`='$pageID';";
                    unset($myID);
                    $rs1 = mysqli_query($conn, $query); $rs2 = true;
                    $successMsg = 'Your edit has been saved and is currently pending approval.';
                    log_all('SATURN][PAGES', get_user_fullname($_SESSION['id']).' edited page with ID: '.$pageID.' ('.get_page_title($pageID).'). The edit is pending approval.');
                } else {
                    $query = 'UPDATE `'.DATABASE_PREFIX."pages` SET `title`='$title',`content`='$content',`reference`='$references' WHERE `id`='$pageID';";
                    $rs1 = mysqli_query($conn, $query);
                    $query = 'INSERT INTO `'.DATABASE_PREFIX."pages_history` (`id`, `page_id`, `user_id`, `timestamp`) VALUES (NULL, '".$pageID."','".$_SESSION['id']."', CURRENT_TIMESTAMP)";
                    $rs2 = mysqli_query($conn, $query);
                    $newEdits = get_user_statistics_edits($_SESSION['id']) + 1;
                    update_user_edits($_SESSION['id'], $newEdits);
                    $successMsg = 'Your edit has been saved.';
                    log_all('SATURN][PAGES', get_user_fullname($_SESSION['id']).' edited page with ID: '.$pageID.' ('.get_page_title($pageID).').');
                }
                if ($rs1 && $rs2) {
                    header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$pageID.'&success='.$successMsg);
                } else {

                    if (!file_exists(__DIR__."/../../../storage/recovery")) {
                        mkdir(__DIR__."/../../../storage/recovery", 0755, true);
                    }
                    $srp = fopen(__DIR__."/../../../storage/recovery/".$pageID.".srp", "w");
                    $data = '{
	"SaturnRecoveredPage": {
		"id": "'.$pageID.'",
		"title": "'.$title.'",
		"content": "'.$content.'",
		"references": "'.$references.'"
	}
}';
                    $srpWrite = fwrite($srp, $data);
                    fclose($srp);

                    if (!$srp || !$srpWrite) {
                        $errorMsg = 'Saturn encountered an error whilst attempting to save your work and was also unable to save it to a recovery file.';
                        header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$pageID.'&error='.$errorMsg);
                    } else {
                        $errorMsg = 'Unable to save data to the database, a recovery file has been used instead.';
                        header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$pageID.'&error='.$errorMsg);
                    }
                    exit;

                }
            } else {
                $errorMsg = 'Page requires content.';
                header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$pageID.'&error='.$errorMsg);
            }
        } else {
            $errorMsg = 'Page requires a title.';
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.$pageID.'&error='.$errorMsg);
        }
        exit;
    }

    if (isset($_POST['submitSettings'])) {
        update_page_description($pageID, $_POST['settings_page_description']);
        update_page_category($pageID, $_POST['settings_page_category']);
        update_page_template($pageID, $_POST['settings_page_template']);
        update_page_url($pageID, $_POST['settings_page_url']);
        update_page_image_url($pageID, $_POST['settings_page_image']);
        update_page_image_credit($pageID, $_POST['settings_page_image_credit']);
        update_page_image_license($pageID, $_POST['settings_page_image_license']);
    }

    if (isset($_POST['deletePage'])) {
        if (delete_page($pageID)) {
            header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/?success=deleted');
        } else {
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?pageID='.htmlspecialchars($pageID).'&error=Unable to delete the page.');
        }
        exit;
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-700 dark:bg-white">
    <head>
        <?php
        include_once __DIR__.'/../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../common/panel/theme.php';
        ?>

        <title>Page Editor - Saturn Panel</title>
        <script src="<?php echo CONFIG_INSTALL_URL; ?>/assets/js/editor.js"></script>

    </head>
    <body class="mb-8 dark:bg-neutral-700">
        <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>
        <?php if (file_exists(__DIR__."/../../../storage/recovery/".$pageID.".srp")) { ?>
        <form x-data="{ open: true }" action="" method="post">
            <?php echo display_modal('info', 'Recovery File Found', 'Something didn\'t go quite right last time this page was saved and a recovery file was created. Would you like to load the data from this file now?<br><br>Loading a recovery file will delete your existing work if you later choose to save it. To revert to your previous work after loading click the cancel button at the bottom of the screen.<br><br>The recovery file will be deleted when you make your decision.', '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="loadRecovery" name="loadRecovery" value="Yes" class="dark:bg-green-800 dark:text-white dark:hover:bg-green-700 transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 bg-green-200 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" id="discardRecovery" name="discardRecovery" value="No" class="dark:bg-red-800 dark:text-white dark:hover:bg-red-700 transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 bg-red-200 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                </div>'); ?>
        </form>
        <?php } ?>
        <div<?php if (get_user_roleID($_SESSION['id']) >= PERMISSION_EDIT_PAGE_SETTINGS) { ?> x-data="{ open: false }"<?php } ?>>
            <header class="bg-white shadow dark:bg-neutral-800">
                <div class="py-6 px-4 sm:px-6 lg:px-8 md:flex max-w-7xl w-7xl mx-auto">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900 flex-grow dark:text-white">Page Editor: <?php $title = checkOutput('DEFAULT', get_page_title($pageID)); echo $title; ?></h1>
                    <br class="md:hidden block">
                    <span class="self-center flex space-x-6 text-right">
                        <a href="<?php echo get_page_url($pageID); ?>" target="_blank" rel="noopener" class="text-<?php echo THEME_PANEL_COLOUR; ?>-900 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:hover:text-white dark:text-gray-300 transition duration-200 underline transition duration-200">
                            View live <i class="fas fa-external-link-alt" aria-hidden="true"></i>
                        </a>
                        <?php if (get_user_roleID($_SESSION['id']) >= PERMISSION_EDIT_PAGE_SETTINGS) { ?>
                        <a @click="open = true" target="_blank" rel="noopener" class="cursor-pointer text-<?php echo THEME_PANEL_COLOUR; ?>-900 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-500 dark:hover:text-white dark:text-gray-300 transition duration-200 underline transition duration-200">
                            Page Settings <i class="fas fa-cogs" aria-hidden="true"></i>
                        </a>
                        <?php } ?>
                    </span>
                </div>
            </header>
            <?php if (get_user_roleID($_SESSION['id']) >= PERMISSION_EDIT_PAGE_SETTINGS) { ?>
            <form action="index.php?pageID=<?php echo checkInput('DEFAULT', $pageID); ?>" method="POST" class="fixed inset-0 overflow-hidden z-50 dark:bg-gray-700" x-show="open" @click.away="open = false">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-75" aria-hidden="true" @click="open = false"></div>
                    <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex" aria-labelledby="slide-over-heading">
                        <div class="relative w-screen max-w-md">
                            <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                                <div @click="open = false" class="cursor-pointer rounded-md text-gray-300 hover:text-white hover:outline-none hover:ring-2 hover:ring-white">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                            </div>
                            <div class="h-full flex flex-col py-6 bg-white dark:bg-neutral-900 shadow-xl overflow-y-scroll">
                                <div class="px-4 sm:px-6">
                                    <h2 id="slide-over-heading" class="text-3xl font-medium text-gray-900 dark:text-white">
                                        Page Settings
                                    </h2>
                                </div>
                                <div class="mt-6 relative flex-1 px-4 sm:px-6">
                                    <div class="mb-2">
                                        <label for="settings_page_description" class="self-center dark:text-white">Description</label><br>
                                        <textarea id="settings_page_description" name="settings_page_description" type="text" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm"><?php echo get_page_description($pageID); ?></textarea>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_category" class="self-center dark:text-white">Category</label>
                                        <select id="settings_page_category" name="settings_page_category" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
<?php                                       $i = 1;
                                            $category = get_page_category_name($i);
                                            while ($category != null) {
                                                ?>
                                            <option value="<?php echo get_category_id_from_name($category); ?>"<?php if (get_category_id_from_name($category) == get_page_category_id($pageID)) {
                                                    echo ' selected';
                                                } ?>><?php echo $category; ?></option>
<?php                                           $i++;
                                                $category = get_page_category_name($i);
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_template" class="self-center dark:text-white">Template</label>
                                        <select id="settings_page_template" name="settings_page_template" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                                            <?php
                                        $files = glob(__DIR__.'/../../../themes/'.THEME_SLUG.'/*.tt');
                                        foreach ($files as $file) {
                                            $file = substr($file, strrpos($file, '/') + 1);
                                            $file = substr($file, 0, strpos($file, '.'));
                                            $file = strtoupper($file);
                                            if ($file != 'NAVIGATION' && $file != 'FOOTER' && $file != 'ARTICLE') {
                                                ?>
                                        <option value="<?php echo $file; ?>"<?php if (get_page_template($pageID) == $file) {
                                                    echo ' selected';
                                                } ?>><?php echo $file; ?></option>
                                        <?php
                                            }
                                        } ?>
                                        </select>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_image" class="self-center dark:text-white">Image URL</label>
                                        <input id="settings_page_image" name="settings_page_image" type="text" value="<?php echo get_page_image($pageID); ?>" class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm"/>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_image_credit" class="self-center dark:text-white">Image Credit</label>
                                        <input id="settings_page_image_credit" name="settings_page_image_credit" type="text" value="<?php echo get_page_image_credit($pageID); ?>" class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm"/>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_image_license" class="self-center dark:text-white">Image License</label>
                                        <input id="settings_page_image_license" name="settings_page_image_license" type="text" value="<?php echo get_page_image_license($pageID); ?>" class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm"/>
                                    </div>
                                    <div class="grid grid-cols-2 mb-2">
                                        <label for="settings_page_url" class="self-center dark:text-white">URL</label>
                                        <input id="settings_page_url" name="settings_page_url" type="text" value="<?php echo get_page_url($pageID); ?>" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 dark:text-white dark:border-neutral-900 dark:bg-neutral-800 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm" />
                                    </div>
                                    <input type="submit" id="submitSettings" name="submitSettings" value="Save" class="dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 md:py-1 md:text-rg md:px-10">
                                    <p class="text-xs italics dark:text-white">Warning: This save button only saves settings, not your work. If you've edited the page, save that first.</p>
                                    <div class="mt-12 rounded border border-red-500 dark:border-red-800 p-4" x-data="{open:false}">
                                        <h3 class="font-bold text-red-500 dark:text-red-800 pb-4">Danger Zone</h3>
                                        <form action="index.php" method="POST">
                                            <a @click="open = true" class="dark:bg-red-800 dark:hover:bg-red-700 dark:text-white flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 bg-red-200 hover:bg-red-300 md:py-1 md:text-rg md:px-10">Delete Page</a>
                                            <?php echo display_modal('red', 'Delete Page', 'Are you sure you want to delete this page?<br> <u>This action cannot be undone.</u>', '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="deletePage" name="deletePage" value="Delete Page" class="dark:bg-red-800 dark:text-white dark:hover:bg-red-700 transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 bg-red-200 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="dark:bg-neutral-800 dark:text-white dark:hover:bg-neutral-700 flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-900 bg-gray-200 hover:bg-gray-300 md:py-1 md:text-rg md:px-10">Cancel</a>
                                </div>'); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
            <?php } ?>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>/?pageID=<?php echo checkInput('DEFAULT', $pageID); ?>" method="POST" class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <?php
                if (isset($_GET['error'])) {
                    echo alert('ERROR', $_GET['error']);
                    log_error('ERROR', checkInput('DEFAULT', $_GET['error']));
                } elseif (isset($_GET['success'])) {
                    echo alert('SUCCESS', $_GET['success']);
                }
            ?>

            <div class="py-6">
                <h2 class="text-2xl mb-2 font-bold my-2 dark:text-white">Title</h2>
                <label class="hidden" for="title">Title</label>
                <p class="mb-2 dark:text-white">Max. <?php echo CONFIG_MAX_TITLE_CHARS; ?> Characters.</p>
                <textarea name="title" id="title" maxlength="<?php echo stripslashes(CONFIG_MAX_TITLE_CHARS); ?>" class="w-full border"><?php
                        $pageStatus = get_page_status($pageID);
                    if (isset($recoveredData) && $recoveredData->SaturnRecoveredPage->title != null) {
                        $title = $recoveredData->SaturnRecoveredPage->title;
                        $title = checkOutput('HTML', $title);
                        echo stripslashes($title);
                    } else {
                        if ($pageStatus == 'green' || $pageStatus == 'red' || !CONFIG_PAGE_APPROVALS) {
                            $title = get_page_title($pageID);
                            $title = checkOutput('HTML', $title);
                            echo $title;
                        } elseif ($pageStatus == 'yellow') {
                            $title = get_page_pending_title($pageID);
                            $title = checkOutput('HTML', $title);
                            echo $title;
                        }
                    }
                    unset($title);
                ?></textarea>
            </div>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2 dark:text-white">Content</h2>
                <label class="hidden" for="content">Content</label>
                <p class="mb-2 dark:text-white">Max. <?php echo CONFIG_MAX_PAGE_CHARS - (CONFIG_MAX_PAGE_CHARS / 5); ?> Characters.</p>
                <textarea name="content" id="content" class="content" maxlength="<?php echo CONFIG_MAX_PAGE_CHARS - (CONFIG_MAX_PAGE_CHARS / 5); ?>" ><?php
                    if (isset($recoveredData) && $recoveredData->SaturnRecoveredPage->content != null) {
                        $content = $recoveredData->SaturnRecoveredPage->content;
                        $content = checkOutput('HTML', $content);
                        echo stripslashes($content);
                    } else {
                        if ($pageStatus == 'green' || $pageStatus == 'red' || !CONFIG_PAGE_APPROVALS) {
                            $content = get_page_content($pageID);
                            $content = checkOutput('HTML', $content);
                            echo stripslashes($content);
                        } elseif ($pageStatus == 'yellow') {
                            $content = get_page_pending_content($pageID);
                            $content = checkOutput('HTML', $content);
                            echo stripslashes($content);
                        }
                    }
                    unset($content);
                ?></textarea>
            </div>

            <script>
                ClassicEditor
                    .create(document.querySelector('.content'),{
                        toolbar:{items: ['heading','|','bold','italic','underline','strikethrough','link','|','bulletedList','numberedList','|','outdent','indent','|','subscript','superscript','|','insertTable','mediaEmbed','undo','redo']},
                        language:'en-gb',
                        table:{contentToolbar:['tableColumn','tableRow','mergeTableCells']},
                        licenseKey: '',
                    })
                    .then( editor => {window.editor = editor;})
                    .catch( error => {
                        console.error('[ERROR][SATURN] 003: Occurred in instance \'.content\'. Please report the following error on https://saturncms.net/report-error with the CKE5 build id and the error stack trace. CKE5 Build id: 82xe5t2x22wm-w2zoc189x0t1');
                        console.error(error);
                        alert('[ERROR][SATURN] 003: See console for more information.');
                    } );
            </script>

            <div class="py-6">
                <h2 class="text-2xl font-bold mt-2 dark:text-white">References</h2>
                <p class="mb-2 dark:text-white">Max. <?php echo CONFIG_MAX_PAGE_CHARS - (CONFIG_MAX_PAGE_CHARS / 10); ?> Characters.</p>
                <label class="hidden" for="references">References</label>
                <textarea name="references" id="references" class="references" maxlength="<?php echo CONFIG_MAX_PAGE_CHARS - (CONFIG_MAX_PAGE_CHARS / 10); ?>"><?php
                    if (isset($recoveredData->SaturnRecoveredPage->references) && $recoveredData->SaturnRecoveredPage->references != null) {
                        $references = $recoveredData->SaturnRecoveredPage->references;
                        $references = checkOutput('HTML', $references);
                        echo stripslashes($references);
                    } else {
                        if ($pageStatus == 'green' || $pageStatus == 'red' || !CONFIG_PAGE_APPROVALS) {
                            $references = get_page_references($pageID);
                            $references = checkOutput('HTML', $references);
                            echo stripslashes($references);
                        } elseif ($pageStatus == 'yellow') {
                            $references = get_page_pending_references($pageID);
                            $references = checkOutput('HTML', $references);
                            echo stripslashes($references);
                        }
                    }
                    unset($references);
                ?></textarea>
            </div>

            <script>
                ClassicEditor
                    .create(document.querySelector('.references'),{
                        toolbar:{items: ['bold','italic','underline','strikethrough','link','|','bulletedList','numberedList','subscript','superscript','|','undo','redo']},
                        language:'en-gb',
                        licenseKey: '',
                    })
                    .then( editor => {window.editor = editor;})
                    .catch( error => {
                        console.error('[ERROR][SATURN] 003: Occurred in instance \'.references\'. Please report the following error on https://saturncms.net/report-error with the CKE5 build id and the error stack trace. CKE5 Build id: 82xe5t2x22wm-w2zoc189x0t1');
                        console.error(error);
                        alert('[ERROR][SATURN] 003: See console for more information.');
                    } );
            </script>

            <div class="flex space-x-4">
                <input type="submit" id="submit" name="submit" value="Save" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages" class="transition-all duration-200 hover:shadow-lg w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                    Cancel
                </a>
            </div>
        </form>
    </body>
</html>