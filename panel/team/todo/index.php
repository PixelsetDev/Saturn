<?php session_start();
    // Include required files
    include_once(__DIR__.'/../../../assets/common/global_private.php');
    // Delete a list
    if(isset($_GET['delete'])) {
        $listID = $_GET['delete'];
        if(get_todo_list_owner_id($listID) == $_SESSION['id'] OR get_user_roleID($_SESSION['id']) == '4') {
            $successMsg = 'List deleted: '.get_todo_list_name($listID).'. <a href="?recover='.$listID.'" class="text-blue-500 hover:text-blue-400">Undo</a>';
            if(update_todo_list_status($listID, 0) != true) {
                unset($successMsg);
                $errorMsg = 'Unable to delete To-Do List: '.get_todo_list_name($listID).' - an error occurred.';
            }
        } else {
            $errorMsg = 'Only the owner of the To-Do List '.get_todo_list_name($listID).' ('.get_user_fullname(get_todo_list_owner_id($listID)).') or an Administrator can delete the list.';
        }
    }
    // Recover a deleted list.
    if(isset($_GET['recover'])) {
        $listID = $_GET['recover'];
        if(get_todo_list_owner_id($listID) == $_SESSION['id'] OR get_user_roleID($_SESSION['id']) == '4') {
            $successMsg = 'To-Do List recovered: '.get_todo_list_name($listID).'.';
            if(update_todo_list_status($listID, 1) != true) {
                unset($successMsg);
                $errorMsg = 'Unable to recover To-Do List: '.get_todo_list_name($listID).' - an error occurred.';
            }
        } else {
            $errorMsg = 'Only the owner of the To-Do List '.get_todo_list_name($listID).' ('.get_user_fullname(get_todo_list_owner_id($listID)).') or an Administrator can recover the list.';
        }
    }
    // Create a new list
    if(isset($_GET['create'])) {
        $listOwnerID = $_SESSION['id'];
        $listTitle = $_POST['listTitle'];
        $listDescription = $_POST['listDescription'];
        $listRoleID = $_POST['listRoleID'];
        $listVisibility = $_POST['listVisibility'];
        $createdListID = create_todo_list($listOwnerID,$listTitle,$listDescription,$listRoleID,$listVisibility);
        if($createdListID != null) {
            $successMsg = 'To-Do List created: '.get_todo_list_count().'.';
        } else {
            $errorMsg = 'Unable to create the To-Do List. Please try again later.';
        }
    }
    // Save a list
    if(isset($_GET['save'])) {
        $errorMsg = 'This function has not been implemented yet.';
    }
    // Add an item to the list
    if(isset($_GET['add_item'])) {
        $errorMsg = 'This function has not been implemented yet.';
    }
    // Save the manage section of a list
    if(isset($_GET['save_manage'])) {
        $errorMsg = 'This function has not been implemented yet.';
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include_once(__DIR__ . '/../../../assets/common/panel/vendors.php');
        include_once(__DIR__.'/../../../assets/common/panel/theme.php');
        ?>
        <title>Team To-Do - Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../../assets/common/panel/navigation.php'); ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">To-Do</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8" x-data="{ tab: '1' }">
            <?php
                if(isset($errorMsg)){
                echo '<div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                    <div class="p-5">
                        <h6 class="mb-2 font-semibold leading-5">[ERROR] '.$errorMsg.'</h6>
                    </div>
                </div><br>';
                unset($errorMsg);
                }
                if(isset($successMsg)){
                    echo '<div class="duration-300 transform bg-green-100 border-l-4 border-green-500 hover:-translate-y-2">
                        <div class="p-5">
                            <h6 class="mb-2 font-semibold leading-5">'.$successMsg.'</h6>
                        </div>
                    </div><br>';
                    unset($successMsg);
                }
            ?>
            <div class="my-2 py-4 flex space-x-6 overflow-x-auto">
                <?php
                    $i=1;
                    $listName = get_todo_list_name($i);
                    while($listName != NULL){
                        if((get_todo_list_status($i) == '1') AND (get_todo_list_visibility($i) == 'PUBLIC') AND (get_todo_list_role_id($i) <= get_user_roleID($_SESSION['id']))) {
                            echo '<a :class="{ \'active\': tab === \'' . $i . '\' }" @click.prevent="tab = \'' . $i . '\'" class="hover:shadow-lg cursor-pointer w-96 flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-' . THEME_PANEL_COLOUR . '-700 bg-' . THEME_PANEL_COLOUR . '-100 hover:bg-' . THEME_PANEL_COLOUR . '-200 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-30">
                        <i class="fas fa-list"></i>
                        <span class="ml-1">'.$listName.'</span>
                    </a>';
                        }
                        $i++;
                        $listName = get_todo_list_name($i);
                    }
                    unset($i,$listName);
                ?>
                <a :class="{ 'active': tab === 'new' }" @click.prevent="tab = 'new'" class="hover:shadow-lg cursor-pointer w-96 flex-auto flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-30">
                    <i class="far fa-plus-square"></i>
                    <span class="ml-1">Create New</span>
                </a>
            </div>
            <?php
            $i=1;
            $listName = get_todo_list_name($i);
            while($listName != NULL){
                if((get_todo_list_status($i) == '1') AND (get_todo_list_visibility($i) == 'PUBLIC') AND (get_todo_list_role_id($i) <= get_user_roleID($_SESSION['id']))) {
                    $o = 1;
                    $itemName = get_todo_item_title($o);
                    echo '<div x-show="tab === \'' . $i . '\'">
                <div class="flex space-x-6 pb-6 pt-1">
                    <div class="flex-grow">
                        <h2 class="text-2xl">' . $listName . '</h2>
                        <p class="">' . get_user_fullname(get_todo_list_owner_id($i)) . '\'s list.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="?save='.$i.'" class="py-1 px-2 hover:shadow-lg cursor-pointer w-full flex items-center justify-center text-base font-medium rounded-md text-' . THEME_PANEL_COLOUR . '-700 bg-' . THEME_PANEL_COLOUR . '-100 hover:bg-' . THEME_PANEL_COLOUR . '-200 transition-all duration-200 md:text-rg">
                            Save&nbsp;<i class="far fa-save"></i>
                        </a>
                        <a href="javascript:alert(\'This feature has not yet been implemented.\');" class="py-1 px-2 hover:shadow-lg cursor-pointer w-full flex items-center justify-center text-base font-medium rounded-md text-' . THEME_PANEL_COLOUR . '-700 bg-' . THEME_PANEL_COLOUR . '-100 hover:bg-' . THEME_PANEL_COLOUR . '-200 transition-all duration-200 md:text-rg">
                            Manage&nbsp;<i class="fas fa-cogs"></i>
                        </a>
                        <a href="?delete=' . $i . '" class="py-1 px-2 hover:shadow-lg cursor-pointer w-full flex items-center justify-center text-base font-medium rounded-md text-' . THEME_PANEL_COLOUR . '-700 bg-' . THEME_PANEL_COLOUR . '-100 hover:bg-' . THEME_PANEL_COLOUR . '-200 transition-all duration-200 md:text-rg">
                            Delete&nbsp;<i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>';
                    while ($itemName != NULL) {
                        $itemID = get_todo_item_list_id($o);
                        if ($itemID == $i) {
                            echo '<div class="py-1 sm:py-4 flex space-x-6 border rounded px-2 sm:px-6 mb-2">
                    <div class="flex-grow">
                        <strong>' . get_todo_item_title($itemID) . '</<br>
                        ' . get_todo_item_description($itemID) . '
                    </div>
                    <div class="flex items-center space-x-3 pr-6">
                        <input type="checkbox" id="listItem" name="listItem" value="1" ';
                            if (get_todo_item_status($itemID) == '1') {
                                echo 'checked';
                            }
                            echo '>
                    </div>
                </div>
                ';
                            if ((get_todo_list_visibility($i) == 'PUBLIC') or (get_todo_list_owner_id($i) == $_SESSION['id'])) {
                                echo '<div class="py-1 sm:py-4 flex space-x-6 border rounded px-2 sm:px-6 mb-2">
                    <div class="flex-grow">
                        <strong><div><input type="text" id="newItemTitle" name="newItemTitle" placeholder="Title" class="flex-grow self-center text-black tracking-tight w-3/4 bg-gray-100 bg-opacity-50" /><span class="self-center text-black font-extrabold tracking-tight w-3/4 bg-transparent"><i class="fas fa-pencil-alt text-black"></i></span></div></
                        <div><input type="text" id="newItemDescription" name="newItemDescription" placeholder="Description" class="flex-grow self-center text-black tracking-tight w-3/4 bg-gray-100 bg-opacity-50" /><span class="self-center text-black tracking-tight w-3/4 bg-transparent"><i class="fas fa-pencil-alt text-black"></i></span></div>
                    </div>
                    <div class="flex items-center space-x-3 pr-6">
                        <a href="javascript:alert(\'This feature has not yet been implemented.\');" class="py-1 px-2 hover:shadow-lg cursor-pointer w-full flex items-center justify-center text-base font-medium rounded-md text-' . THEME_PANEL_COLOUR . '-700 bg-' . THEME_PANEL_COLOUR . '-100 hover:bg-' . THEME_PANEL_COLOUR . '-200 transition-all duration-200 md:text-rg">
                            Add New&nbsp;<i class="far fa-plus-square"></i>
                        </a>
                    </div>
                </div>';
                            }
                        }
                        $o++;
                        $itemName = get_todo_item_title($o);
                    }
                }
                echo '</div>';
                $i++;
                $listName = get_todo_list_name($i);
            }
            unset($i,$listName);
            ?>
            <div x-show="tab === 'new'">
                <div class="flex space-x-6 pb-6">
                    <div class="flex-grow">
                        <h2 class="text-2xl">Create New</h2>
                    </div>
                </div>
                    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
                        <div class="rounded-md shadow-sm mb-6">
                            <div>
                                <label for="listName" class="sr-only">List Name</label>
                                <input id="listName" name="listName" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="To-Do List Name">
                            </div>
                            <div>
                                <label for="listDescription" class="sr-only">List Description</label>
                                <input id="listDescription" name="listDescription" type="text" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Description">
                            </div>
                            <div>
                                <p class="mb-2 mt-6">
                                    <strong>Privacy</strong>
                                    <a class="text-xs underline" href="javascript:alert('Public: Anybody can Read & Write.\nProtected: Anybody can Read & Only you can Write.\nPrivate: Only you can Read & Write.\n\nAdministrators can read your list regardless of this setting.');">Help</a>
                                </p>
                                <label for="privacyList" class="sr-only">Privacy</label>
                                <select id="privacyList" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    <option value="public" selected="">Public</option>
                                    <option value="protected">Protected</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                            <p class="mb-2 mt-6">
                                <strong>Visibility</strong>
                                <a class="text-xs underline" href="javascript:alert('This is who the list is visible to (if Privacy is set to Public or Protected).\n\nEverybody: Everybody can see your list (unless it is set to private).\nEditors, Administrators and You: You, Edits and Administrators can see your list (unless it is set to private).\nAdministrators and You: You and Administrators can see your list.');">Help</a>
                            </p>
                            <div>
                                <label for="visibilityList" class="sr-only">Privacy</label>
                                <select id="visibilityList" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                                    <option value="all" selected="">Everybody</option>
                                    <option value="editors">Editors, Administrators and You</option>
                                    <option value="administrators">Administrators and You</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="far fa-plus-square"></i>
                                </span>
                                Create New
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </body>
</html>