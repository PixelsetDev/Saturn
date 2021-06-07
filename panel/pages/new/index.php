<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once(__DIR__.'/../../../assets/common/global_private.php');
            include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
            include_once(__DIR__.'/../../../assets/common/panel/theme.php');

            if(isset($_GET['create'])) {
                $pageTitle = trim(checkInput('DEFAULT',$_POST['pagetitle']));
            } else if(isset($_POST['posted'])) {
                $pageURL = trim(checkInput('DEFAULT',$_POST['pageurl']));
                $pageCategory = trim(checkInput('DEFAULT',$_POST['pagecategory']));
                $pageTemplate = trim(checkInput('DEFAULT',$_POST['pagetemplate']));
                $pageTitle = trim(checkInput('DEFAULT',$_POST['pagetitle']));
                $pageDescription = trim(checkInput('DEFAULT',$_POST['pagedescription']));
                if(create_page($pageURL,$pageCategory,$pageTemplate,$pageTitle,$pageDescription) == true) {
                    $successMsg = 'Page created. <a href="'.CONFIG_INSTALL_URL.'/panel/pages" class="text-green-500 hover:text-green-400 transition duration-200">Go Back</a>';
                    log_all('SATURN][PAGES',get_user_fullname($_SESSION['id']).' created a page ('.$_POST['pagetitle'].').');
                }else{
                    $errorMsg = 'Page not created. <a href="'.CONFIG_INSTALL_URL.'/panel/pages" class="text-red-500 hover:text-red-400 transition duration-200">Go Back</a>';
                    log_all('SATURN][ERROR',get_user_fullname($_SESSION['id']).' attempted to create a page but an error occurred.');
                }
            } else {
                header('Location: '.CONFIG_INSTALL_URL.'/panel/pages/?error=new');
                exit;
            }

            if(!isset($pageTitle)) {
                $pageTitle = NULL;
            }
        ?>

        <title>New Page (<?php echo $pageTitle; ?>) - Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Create a New Page</h1>
            </div>
        </header>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <?php
                if(isset($errorMsg)){
                    echo '<div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                    <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">[ERROR] '.$errorMsg.'</h6>
                                    </div>
                                </div><br>'; exit;
                }
                unset($errorMsg);
                if(isset($successMsg)){
                    echo '<div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2">
                                    <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
                                        <h6 class="mb-2 font-semibold leading-5">'.$successMsg.'</h6>
                                    </div>
                                </div><br>'; exit;
                }
                unset($successMsg);
                ?>
                <div class="px-4 py-6 sm:px-0">
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Title</h1>
                        <div class="flex-grow">
                            <label for="pagetitle" class="sr-only self-center">Page Title</label>
                            <input id="pagetitle" name="pagetitle" type="text" maxlength="100" value="<?php echo $pageTitle; ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-lg" placeholder="Page Title">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Description</h1>
                        <div class="flex-grow">
                            <label for="pagedescription" class="sr-only self-center">Page Description</label>
                            <input id="pagedescription" name="pagedescription" type="text" maxlength="255" value="<?php echo $pageTitle; ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-lg" placeholder="Page Description">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page URL</h1>
                        <div class="flex-grow">
                            <label for="pageurl" class="sr-only self-center">Page Title</label>
                            <input id="pageurl" name="pageurl" type="text" value="<?php echo '/'.strtolower(get_page_category_name(1)).'/'.strtolower($pageTitle); ?>" required class="self-center appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 text-lg" placeholder="Page URL">
                        </div>
                    </div>
                    <div class="flex space-x-2 mb-2">
                        <h1 class="text-xl w-1/6 self-center">Page Category</h1>
                        <div class="flex-grow">
                            <label for="pagecategory" class="sr-only self-center">Page Category</label>
                            <select name="pagecategory" id="pagecategory" class="flex-grow w-full h-10 pl-3 pr-6 text-base placeholder-gray-600 border rounded-lg appearance-none focus:shadow-outline">
                    <?php
                        $i=1;
                        $category = get_page_category_name($i);
                        while($category != null) {
                            echo '<option value="'.get_page_category_id($i).'">'.$category.'</option>';
                            $i++;
                            $category = get_page_category_name($i);
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
                                <option value="DEFAULT"><?php echo list_page_templates(); ?></option>
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
