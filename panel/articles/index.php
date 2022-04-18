<?php session_start();
require_once __DIR__.'/../../common/global_private.php';

if (isset($_POST['newArticle'])) {
    create_article($_POST['newArticleTitle']);
}
?><!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-700 dark:text-white">
    <head>
        <?php
            include_once __DIR__.'/../../common/panel/vendors.php';
        ?>
        <title><?php echo __('Panel:Articles'); ?> - <?php echo __('General:Saturn').' '.__('Admin:Panel'); ?></title>

        <?php
            if (isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'permission') {
                    $errorMsg = __('Error:Permissions');
                } elseif ($error == 'new') {
                    $errorMsg = __('Error:Articles_New');
                } else {
                    $errorMsg = __('Error:Unknown');
                }
            }

            if (isset($_POST['publish'])) {
                $articleID = checkInput('DEFAULT', $_GET['articleID']);
                if (get_article_author_id($articleID) == $_SESSION['id']) {
                    if (update_article_status($articleID, 'PUBLISHED')) {
                        $successMsg = __('Panel:Article_Published');
                    } else {
                        $errorMsg = __('Error:Unknown');
                    }
                } else {
                    $errorMsg = __('Error:Articles_DownOwn_Publish');
                }
            }

            if (isset($_POST['delete'])) {
                $articleID = checkInput('DEFAULT', $_GET['articleID']);
                if (get_article_author_id($articleID) == $_SESSION['id']) {
                    if (update_article_status($articleID, 'DELETED') && update_article_content($articleID, '') && update_article_references($articleID, '')) {
                        $successMsg = __('Panel:Article_Deleted');
                    } else {
                        $errorMsg = __('Error:Unknown');
                    }
                } else {
                    $errorMsg = __('Error:Articles_DownOwn_Delete');
                }
            }

            if (isset($_POST['hide'])) {
                $articleID = checkInput('DEFAULT', $_GET['articleID']);
                if (get_article_author_id($articleID) == $_SESSION['id']) {
                    if (update_article_status($articleID, 'UNPUBLISHED')) {
                        $successMsg = __('Panel:Article_Hidden');
                    } else {
                        $errorMsg = __('Error:Unknown');
                    }
                } else {
                    $errorMsg = __('Error:Articles_DownOwn_Hide');
                }
            }

            if (isset($_POST['savesettings'])) {
                $articleID = checkInput('DEFAULT', $_GET['articleID']);
                $author = checkInput('DEFAULT', $_POST['users']);
                if (get_article_author_id($articleID) == $_SESSION['id']) {
                    if (update_article_author($articleID, $author)) {
                        $successMsg = __('Panel:Article_Settings_Updated');
                    } else {
                        $errorMsg = __('Error:Unknown');
                    }
                } else {
                    $errorMsg = __('Error:Articles_DownOwn_Settings');
                }
            }

            if (isset($_GET['request'])) {
                $articleID = checkInput('DEFAULT', $_GET['articleID']);
                if (get_article_author_id($articleID) == $_SESSION['id']) {
                    if (update_article_status($articleID, 'PENDING')) {
                        $successMsg = __('Panel:Article_Submitted');
                    } else {
                        $errorMsg = __('Error:Unknown');
                    }
                } else {
                    $errorMsg = __('Error:Articles_DownOwn_Publish');
                }
            }
            ?>

    </head>
    <body class="mb-8">
        <?php include_once __DIR__.'/../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Articles'); ?></h1>
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
                $exists = false;
                while ($article != null) {
                    if (get_article_author_id($i) == $_SESSION['id'] && get_article_status($i) != 'DELETED') {
                        $exists = true; ?>  <div>
                                <div id="<?php echo $article; ?>">
                                    <div class="flex-0 relative pt-1 mb-2">
                                        <div class="flex items-center justify-between">
                                            <h1 class="text-xl font-bold leading-tight text-gray-900 mr-2 dark:text-white"><?php echo $article; ?></h1>
                                            <div><?php
                        if (get_article_status($i) == 'UNPUBLISHED') {
                            $statusColour = 'red';
                            $status = __('Panel:Unpublished');
                        } elseif (get_article_status($i) == 'PENDING') {
                            $statusColour = 'yellow';
                            $status = __('General:Pending');
                        } elseif (get_article_status($i) == 'REJECTED') {
                            $statusColour = 'red';
                            $status = __('Panel:Rejected');
                        } elseif (get_article_status($i) == 'PUBLISHED') {
                            $statusColour = 'green';
                            $status = __('Panel:Published');
                        } else {
                            $statusColour = 'gray';
                            $status = __('Panel:UnknownStatus');
                        } ?><span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-lg text-<?php echo $statusColour; ?>-900 dark:text-white bg-<?php echo $statusColour; ?>-200 dark:bg-<?php echo $statusColour; ?>-600"><?php echo $status; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2 flex-grow flex w-30 h-8 space-x-2">
                                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles/editor/?articleID=<?php echo $i; ?>" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-white bg-<?php echo THEME_PANEL_COLOUR; ?>-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                            <i class="fas fa-pencil-alt" aria-hidden="true"></i>&nbsp;<?php echo __('General:Edit'); ?>
                                        </a>
                                        <?php
                        if ($status == 'Published' || $status == 'Pending') {
                            echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.$i.'" method="post" x-data="{ open: false }" class="h-8">
                                            <a @click="open = true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-100 dark:bg-neutral-600 hover:bg-'.THEME_PANEL_COLOUR.'-200 dark:hover:bg-neutral-500 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                                <i class="fas fa-eye-slash" aria-hidden="true"></i>&nbsp;'.__('Panel:Hide').'
                                            </a>
                                            '.display_modal('red', ''.__('Panel:Article_Hide').': '.$article, __('Panel:Article_Hide_Message_1').'<br><br>'.__('Panel:Article_Hide_Message_2').'<br>'.__('Panel:Article_Hide_Message_3'), '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="hide" name="hide" value="'.__('Panel:Article_Hide').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 dark:text-white bg-gray-100 dark:bg-neutral-800 hover:bg-gray-200 dark:hover:bg-neutral-700 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                </div>').'
                                        </form>';
                        } elseif ($status != 'Published' && CONFIG_ARTICLE_APPROVALS === false) {
                            echo '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.$i.'" method="post" x-data="{ open: false }" class="h-8">
                                            <a @click="open = true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                                <i class="fas fa-upload" aria-hidden="true"></i>&nbsp;'.__('Panel:Publish').'
                                            </a>
                                            '.display_modal('green', __('Panel:Article_Publish').': '.$article, __('Panel:Article_Publish_Message'), '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="publish" name="publish" value="'.__('Panel:Article_Publish').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white hover:bg-gray-200 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                </div>').'
                                        </form>';
                        } elseif ($status != 'Published' && CONFIG_ARTICLE_APPROVALS === true) {
                            echo '<a href="'.CONFIG_INSTALL_URL.'/panel/articles/?articleID='.$i.'&request=true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                            <i class="fas fa-upload" aria-hidden="true"></i>&nbsp;'.__('Panel:RequestPublication').'
                                        </a>';
                        } else {
                            alert('ERROR', __('Error:Articles_ApprovalStatus') . ' ' . $i);
                            log_error('ERROR', __('Error:Articles_ApprovalStatus') . ' ' . $i);
                        }
                        $contents = 'Article Owner: '.display_user_dropdown('SELECTME');
                        echo '          <form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.$i.'" method="post" x-data="{open: false}" class="h-8">
                                            <a @click="open = true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                                <i class="fas fa-cogs" aria-hidden="true"></i>&nbsp;'.__('General:Settings').'
                                            </a>
                                        '.display_modal_sidebar(__('Panel:Article_Settings').': '.$article, $contents, '<span class="mx-6 text-gray-500">'.__('Panel:Article_Settings_Message').'</span><div class="bg-gray-50 dark:bg-neutral-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="savesettings" name="savesettings" value="'.__('General:Save').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-green-900 dark:text-white bg-green-200 dark:bg-green-700 dark:hover:bg-green-600 hover:bg-green-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                </div>').'
                                        </form>
                                        <form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'/?articleID='.$i.'" method="post" x-data="{ open: false }" class="h-8">
                                            <a @click="open = true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                                <i class="fas fa-trash-alt" aria-hidden="true"></i>&nbsp;'.__('General:Delete').'
                                            </a>
                                            '.display_modal('red', __('Panel:Article_Delete').': '.$article, __('Panel:Article_Delete_Message'), '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="delete" name="delete" value="'.__('Panel:Article_Delete').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white hover:bg-gray-200 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                </div>').'
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <br><hr class="dark:text-neutral-900 text-gray-200"><br>';
                    }
                    unset($article);
                    $i++;
                    $article = get_article_title($i);
                }
                ?>
                <div class="px-4 py-6 sm:px-0">
                    <div>
                        <div name="New Article" id="New Article">
                            <div class="flex-0 relative pt-1 mb-2">
                                <div class="flex items-center justify-between">
                                    <h1 class="text-xl font-bold leading-tight text-gray-900 mr-2 dark:text-white"><?php echo __('Panel:Article_New'); ?></h1>
                                </div>
                            </div>
                            <div class="mb-2 w-30 h-8">
                                <form action="" method="post" x-data="{ open: false }" class="flex space-x-2">
                                    <div class="flex-grow w-full">
                                        <label for="newArticleTitle" class="sr-only"><?php echo __('General:Title'); ?></label>
                                        <input id="newArticleTitle" name="newArticleTitle" type="text" required class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-600 dark:text-white dark:border-blue-900 px-3 py-2 rounded-md w-full" placeholder="<?php echo __('General:Title'); ?>">
                                    </div>
                                    <input type="submit" id="newArticle" name="newArticle" value="<?php echo __('General:Create'); ?>" class="hover:shadow-lg h-full cursor-pointer flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-white bg-<?php echo THEME_PANEL_COLOUR; ?>-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>