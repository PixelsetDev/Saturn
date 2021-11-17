<?php session_start(); ob_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../../common/global_private.php';
            include_once __DIR__.'/../../../common/panel/vendors.php';
            include_once __DIR__.'/../../../common/panel/theme.php';

            if (isset($_GET['categorytitle'])) {
                create_category(checkInput('DEFAULT', $_GET['categorytitle']), '0');
                internal_redirect('/panel/pages');
                exit;
            } elseif (isset($_GET['create'])) {
                $pageCategory = trim(checkInput('DEFAULT', $_GET['pagecategory']));
                $pageTitle = trim(checkInput('DEFAULT', $_GET['pagetitle']));
            } elseif (isset($_POST['posted'])) {
                $pageURL = trim(checkInput('DEFAULT', $_POST['pageurl']));
                $pageURL = str_replace(' ', '-', $pageURL);
                $pageCategory = trim(checkInput('DEFAULT', $_POST['pagecategory']));
                $pageTemplate = trim(checkInput('DEFAULT', $_POST['pagetemplate']));
                $pageTitle = trim(checkInput('DEFAULT', $_POST['pagetitle']));
                $pageDescription = trim(checkInput('DEFAULT', $_POST['pagedescription']));
                if (create_page($pageURL, $pageCategory, $pageTemplate, $pageTitle, $pageDescription)) {
                    header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/?success=new');
                    log_all('SATURN][PAGES', get_user_fullname($_SESSION['id']).' created a page ('.$_POST['pagetitle'].').');
                } else {
                    header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/?error=new');
                    log_error('ERROR', get_user_fullname($_SESSION['id']).' attempted to create a page but an error occurred.');
                }
            } else {
                header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/?error=new');
                exit;
            }

            if (!isset($pageTitle)) {
                $pageTitle = null;
            }
            ob_end_flush();
        ?>

        <title>New Page (<?php echo $pageTitle; ?>) - Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Create a New Page</h1>
            </div>
        </header>

        <form action="index.php" method="post">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <?php
                if (isset($errorMsg)) {
                    echo alert('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if (isset($successMsg)) {
                    echo alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
                ?>
                <div class="px-4 py-6 sm:px-0">
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Title</h1>
                        <div class="flex-grow">
                            <label for="pagetitle" class="sr-only self-center">Page Title</label>
                            <input id="pagetitle" maxlength="64" name="pagetitle" type="text" maxlength="100" value="<?php echo $pageTitle; ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 text-lg" placeholder="Page Title">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Description</h1>
                        <div class="flex-grow">
                            <label for="pagedescription" class="sr-only self-center">Page Description</label>
                            <input id="pagedescription" maxlength="127" name="pagedescription" type="text" maxlength="255" value="<?php echo $pageTitle; ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 text-lg" placeholder="Page Description">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page URL</h1>
                        <div class="flex-grow">
                            <label for="pageurl" class="sr-only self-center">Page Title</label>
                            <input id="pageurl" name="pageurl" maxlength="64" type="text" value="<?php echo str_replace(' ', '-', '/'.strtolower($pageCategory).'/'.strtolower($pageTitle)); ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 text-lg" placeholder="Page URL">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Category</h1>
                        <div class="flex-grow">
                            <label for="pagecategory" class="sr-only self-center">Page Category</label>
                            <select name="pagecategory" id="pagecategory" class="flex-grow w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline">
                    <?php
                    try {
                        $i = 1;
                        $category = get_page_category_name($i);
                        while ($category != null) {
                            if ($pageCategory == strtolower(get_page_category_name($i))) {
                                $selected = ' selected';
                            }
                            echo '<option value="'.$i.'"'.$selected.'>'.$category.'</option>';
                            $i++;
                            unset($selected,$category);
                            $category = get_page_category_name($i);
                        }
                    } catch (Exception $e) {
                        errorHandlerError('', 'An error occurred.');
                    }
                    ?>
                            </select>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <h1 class="text-xl w-1/6 self-center">Page Template</h1>
                        <div class="flex-grow">
                            <label for="pagetemplate" class="sr-only self-center">Page Template</label>
                            <select name="pagetemplate" id="pagetemplate" class="flex-grow w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline">
                                <option value="HOMEPAGE">Homepage</option>
                                <option value="DEFAULT" selected>Default</option>
                            </select>
                            </div>
                    </div>
                    <div class="mt-6">
                        <input type="submit" name="posted" id="posted" value="CREATE NEW" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-200 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                    </div>
                </div>
            </div>
        </form>
    </body>
</html>
