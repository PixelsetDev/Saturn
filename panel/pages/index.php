<?php session_start(); ?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once(__DIR__.'/../../assets/common/global_private.php');
            include_once(__DIR__ . '/../../assets/common/panel/vendors.php');
            include_once(__DIR__.'/../../assets/common/panel/theme.php');
        ?>
        <title>Pages - Saturn Panel</title>

        <?php
            if(isset($_GET['error'])) {
                $error = $_GET['error'];
                if ($error == 'permission') {
                    $errorMsg = "Error: You do not have the required permissions to do that.";
                } else if ($error == 'new') {
                    $errorMsg = "Error: There was a problem creating a new page.";
                } else {
                    $errorMsg = "Error: An unknown error occurred.";
                }
            }

            $key = '
                                                        <div class="text-xs text-left absolute bottom-2 left-0 h-16 w-30 p-2 bg-gray-50 rounded">
                                                            <span class="text-red-500">Red:</span> No Content<br>
                                                            <span class="text-yellow-500">Yellow:</span> Pending Approval<br>
                                                            <span class="text-green-500">Green:</span> Currently Live<br>
                                                            <i>You can edit pending pages.</i>
                                                        </div>'
        ?>

    </head>
    <body class="mb-8">
        <?php include_once(__DIR__.'/../../assets/common/panel/navigation.php'); ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">Pages</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <?php
            if(isset($error)){
                echo '<br>
                            <div class="duration-300 transform bg-red-100 border-l-4 border-red-500 hover:-translate-y-2">
                                <div class="h-full p-5 border border-l-0 rounded-r shadow-sm">
                                    <h6 class="mb-2 font-semibold leading-5">'.$errorMsg.'</h6>
                                </div>
                            </div>';
            }
            unset($errorMsg);
            ?>
            <div class="px-4 py-6 sm:px-0">
                <?php
                $role = get_user_roleID($_SESSION['id']);
                $i=1;
                $category = get_page_category_name($i);
                while($category != null) {
                    $percent = 0; $written = 0; $complete = 0; $pending = 0; $total = 0;
                    echo '<div x-data="{ open: false }">
                        <div class="fixed inset-0 overflow-hidden z-50" x-show="open" @click.away="open = false">
                            <div class="absolute inset-0 overflow-hidden">
                                <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                                <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex" aria-labelledby="slide-over-heading">
                                    <div class="relative w-screen max-w-md">
                                        <div class="absolute top-0 left-0 -ml-8 pt-4 pr-2 flex sm:-ml-10 sm:pr-4">
                                            <button @click="open = false" class="rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                                            <div class="px-4 sm:px-6">
                                                <h2 id="slide-over-heading" class="text-3xl font-medium text-gray-900">
                                                    '.$category.'
                                                </h2>
                                            </div>
                                            <div class="mt-6 relative flex-1 px-4 sm:px-6">
                                                <div class="absolute inset-0 px-4 sm:px-6 h-full">
                                                    <p>Please select a page.</p>';
                    $query = "select title, id from ".DATABASE_PREFIX."pages where category_id = '$i'";
                    $rs = mysqli_query($conn,$query);
                    $row = mysqli_fetch_assoc($rs);
                    $o = $row['id'];

                    $query = "select title, id from ".DATABASE_PREFIX."pages where category_id = '$i' AND id = '$o'";
                    $rs = mysqli_query($conn,$query);
                    $row = mysqli_fetch_assoc($rs);

                    while ($row['title'] != null) {
                        unset($query);
                        unset($rs);
                        unset($row);
                        $query = "select title, id from ".DATABASE_PREFIX."pages where category_id = '$i' AND id = '$o'";

                        $rs = mysqli_query($conn,$query);
                        $row = mysqli_fetch_assoc($rs);

                        if($row['title'] != null) {
                            $status = get_page_status($o); if ($status == 'green') {$complete++;} else if ($status == 'yellow') {if(CONFIG_PAGE_APPROVALS == true){$pending++;}else{$status='green';$complete++;}} $total++;
                            echo'<div class="w-full font-semibold inline-block py-2 px-4 uppercase rounded text-gray-900 bg-gray-100">
                                                                <div class="flex w-full relative">
                                                                    <div class="absolute -top-1 -right-1 bg-'.$status.'-500 w-3 h-3 rounded-full"></div>
                                                                    '; if (($status == 'red')) {echo'<div class="absolute -top-1 -right-1 bg-'.$status.'-500 w-3 h-3 rounded-full animate-ping"></div>';}echo'
                                                                    <div class="flex-grow mr-2 self-center">'.get_page_title($o).'</div>
                                                                    <div><a href="editor/?pageID='.$o.'" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-200 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">Edit</span></a></div>
                                                                </div>
                                                                <div class="text-xs normal-case font-normal text-gray-400 italic">'; if($status=='yellow'){echo 'Pending approval request from '.get_user_fullname(get_page_pending_user_id($o)).'.';}else if($status=='red'){echo'This page has not been edited by anyone yet.';}else{echo 'Last edited by '.get_user_fullname(get_page_last_edit_user_id($o)).' at '.get_page_last_edit_timestamp($row['id']).'.';}echo'</div>
                                                            </div>
                                                            <br><br>';
                        }
                        $o++;
                    } if(get_user_roleID($_SESSION['id']) == '4') { echo '<form action="new" name="newpage" method="GET">
                                                                <div class="w-full font-semibold inline-block py-2 px-3 uppercase rounded text-gray-900 bg-gray-100">
                                                                    <div class="flex w-full relative space-x-3">
                                                                        <div class="flex-grow">
                                                                            <label for="pagetitle" class="sr-only">Page Name</label>
                                                                            <input id="pagetitle" name="pagetitle" type="text" maxlength="100" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Page Title">
                                                                        </div>
                                                                        <div><input type="submit" name="create" id="create" value="CREATE NEW" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-200 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full"></div>
                                                                    </div>
                                                                </div>
                                                            </form>'; } echo '<br><br><br><br>
                                                </div>
                                            </div>
                                            '.$key.'
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <h1 class="text-xl font-bold leading-tight text-gray-900">'.$category.'</h1>
                        
                        <div class="flex">
                            <div class="flex-grow h-16 relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>';
                    if (is_nan($complete / $total) * 100) {$statusColour = 'gray'; $status = 'No Pages';}
                    else if((($complete / $total) * 100) == 100.00) {$statusColour = 'green'; $status = 'Complete';}
                    else if((($complete / $total) * 100) != 0 || (($pending / $total) * 100) != 0) {$statusColour = 'yellow'; $status = 'In Progress';}
                    else if((($complete / $total) * 100) == 0 && (($pending / $total) * 100) == 0) {$statusColour = 'red'; $status = 'Not Started';}
                    else {$statusColour = 'gray'; $status = 'Unknown Status';}
                    echo '<span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-'.$statusColour.'-500 bg-'.$statusColour.'-200">'.$status.'</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block">Written: <span class="text-xs font-semibold inline-block text-gray-600">'; $written = $complete+$pending; $percent = ($written / $total) * 100; if (is_nan($percent)) { echo'N/A'; } else { echo number_format((float)$percent, 2, '.', '').'%';} echo '</span></span>
                                        <br>
                                        <span class="text-xs font-semibold inline-block">Approved: <span class="text-xs font-semibold inline-block text-gray-600">'; $percent = ($complete / $total) * 100; if (is_nan($percent)) { echo'N/A'; } else { echo number_format((float)$percent, 2, '.', '').'%';} echo '</span></span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-red-400">
                                    <div style="width:'.(($complete / $total) * 100).'%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                                    <div style="width:'.(($pending / $total) * 100).'%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-yellow-500"></div>
                                </div>
                            </div>
                            <div class="flex-none">&nbsp;&nbsp;&nbsp;</div>
                            <div class="flex-none w-16 h-16">
                                <a @click="open = true" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 bg-'.THEME_PANEL_COLOUR.'-100 hover:bg-'.THEME_PANEL_COLOUR.'-200 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                    Select
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="flex">
                                <div class="container mx-auto">
                                    Assigned Editors:
                                    <div class="flex -space-x-1 overflow-hidden">';
                    $uid = 1;
                    $users = get_user_firstname($uid);
                    while($users != null) {
                        if(get_user_roleID($uid) == '3' || get_user_roleID($uid) == '4') {
                            echo'<a href="'.get_user_profile_link($uid).'" class="relative inline-block">
                                                <img class="bg-white inline-block h-6 w-6 rounded-full ring-2 ring-white" src="'.get_user_profilephoto($uid).'" title="'.get_user_fullname($uid).'" alt="'.get_user_fullname($uid).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity($uid).'-600 border-2 border-white rounded-full"></span>
                                            </a>';
                        }
                        $uid++;
                        $users = get_user_firstname($uid);
                    }
                    echo '</div>
                                </div>
                            <div class="container mx-auto">
                                    Assigned Writers:
                                    <div class="flex -space-x-1 overflow-hidden">';
                    $uid = 1;
                    $users = get_user_firstname($uid);
                    while($users != null) {
                        if(get_user_roleID($uid) != '1' ) {
                            echo'<a href="'.get_user_profile_link($uid).'" class="relative inline-block">
                                                <img class="bg-white inline-block h-6 w-6 rounded-full ring-2 ring-white" src="'.get_user_profilephoto($uid).'" title="'.get_user_fullname($uid).'" alt="'.get_user_fullname($uid).'">
                                                <span class="absolute bottom-0 right-0 inline-block w-2 h-2 bg-'.get_activity($uid).'-600 border-2 border-white rounded-full"></span>
                                            </a>';
                            $uid++;
                            $users = get_user_firstname($uid);
                        }
                    }
                    echo '</div>
                                </div>
                            </div>';
                    unset($category);
                    $i++;
                    $category = get_page_category_name($i);
                    echo '
                    </div><br><hr><br>';
                }
                ?>
            </div>
    </body>
</html>