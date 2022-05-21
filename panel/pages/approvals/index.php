<?php session_start(); ?><!DOCTYPE html>
<html lang="en" class="dark:bg-neutral-700 dark:text-white">
    <head>
        <?php
        include_once __DIR__.'/../../../common/global_private.php';
        include_once __DIR__.'/../../../common/panel/vendors.php';
        include_once __DIR__.'/../../../common/panel/theme.php';
        include_once __DIR__.'/../../../common/processes/pages.php';
        include_once __DIR__.'/../../../common/processes/gui/pages.php';
        ?>
        <title>Pages - Saturn Panel</title>

        <?php
        if (isset($_GET['error'])) {
            $error = $_GET['error'];
            if ($error == 'permission') {
                $errorMsg = 'You do not have the required permissions to do that.';
            } elseif ($error == 'none') {
                $errorMsg = 'The page you selected does not have any pending approvals.';
            } else {
                $errorMsg = 'An unknown error occurred.';
            }
        }
        if (isset($_GET['success'])) {
            $success = $_GET['success'];
            if ($success == 'approved') {
                $successMsg = 'The page\'s edit has been approved.';
            } elseif ($success == 'denied') {
                $successMsg = 'The page\'s edit has been denied.';
            }
        }

        $key = '
                                                            <div class="text-xs text-left absolute bottom-0 left-0 h-20 w-30 p-2 bg-gray-50 dark:bg-neutral-800 rounded-tr">
                                                                <span class="text-red-500">Red:</span> No Content<br>
                                                                <span class="text-yellow-500">Yellow:</span> Pending Approval<br>
                                                                <span class="text-green-500">Green:</span> Currently Live<br>
                                                                <i>You can edit pending pages.</i>
                                                            </div>'
        ?>

    </head>
    <body class="mb-8">
    <?php include_once __DIR__.'/../../../common/panel/navigation.php'; ?>

    <header class="bg-white shadow dark:bg-neutral-800">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white">Pages Approvals</h1>
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
            $i = 0;
            $results = mysqli_fetch_all(mysqli_query($conn, 'SELECT `name`, `id` FROM `'.DATABASE_PREFIX.'pages_categories` WHERE 1 ORDER BY `name` ASC'));
            foreach ($results as $cresult) {
                $categoryID = $cresult[1];
                $percent = 0;
                $written = 0;
                $complete = 0;
                $pending = 0;
                $approved = 0;
                $total = 0;
                $i++; ?>
                <script>
                    function myFunction<?php echo $i; ?>() {
                        var input, filter, ul, li, a, i, txtValue;
                        input = document.getElementById("myInput<?php echo $i; ?>");
                        filter = input.value.toUpperCase();
                        ul = document.getElementById("myUL<?php echo $i; ?>");
                        li = ul.getElementsByTagName("li");
                        for (i = 0; i < li.length; i++) {
                            a = li[i].getElementsByTagName("span")[0];
                            txtValue = a.textContent || a.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                li[i].style.display = "";
                            } else {
                                li[i].style.display = "none";
                            }
                        }
                    }
                </script>
                <div x-data="{ open: false }">
                    <div class="fixed inset-0 overflow-hidden z-50" x-show="open" @click.away="open = false">
                        <div class="absolute inset-0 overflow-hidden">
                            <div class="absolute inset-0 bg-gray-500 bg-opacity-75 dark:bg-black dark:bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>
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
                                    <div class="h-full flex flex-col py-6 bg-white dark:bg-neutral-900 shadow-xl overflow-y-scroll">
                                        <div class="px-4 sm:px-6">
                                            <h2 id="slide-over-heading" class="text-3xl font-medium text-gray-900 dark:text-white">
                                                <?php echo $cresult[0]; ?>
                                            </h2>
                                            <input type="text" id="myInput<?php echo $i; ?>" onkeyup="myFunction<?php echo $i; ?>()" placeholder="Search" class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-800 dark:text-white dark:border-blue-900 px-1 rounded-md">
                                        </div>
                                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                                            <ul id="myUL<?php echo $i; ?>" class="absolute inset-0 px-4 sm:px-6 h-full">
                                                <?php
                                                $results = mysqli_fetch_all(mysqli_query($conn, 'SELECT * FROM `'.DATABASE_PREFIX.'pages` WHERE `category_id` = '.$categoryID.' ORDER BY `title` ASC'));

                foreach ($results as $result) {
                    if ($result[5] != null) {
                        $status = get_page_status($result[0]);
                        if (get_page_pending_title($result[0]) != null && get_page_pending_title($result[0]) != '') {
                            $pending++;
                            $status = 'red';
                        } else {
                            $approved++;
                            $status = 'green';
                        }
                        $total++; ?>
                                                        <li class="my-2">
                                                            <div class="w-full font-semibold inline-block py-2 px-4 uppercase rounded text-gray-900 dark:text-white bg-gray-100 dark:bg-neutral-800">
                                                                <div class="flex w-full relative">
                                                                    <div class="flex-grow">
                                                                        <div class="absolute -top-1 -right-1 bg-<?php echo $status; ?>-500 w-3 h-3 rounded-full"></div>
                                                                        <?php if ($status == 'red') { ?>
                                                                            <div class="absolute -top-1 -right-1 bg-<?php echo $status; ?>-500 w-3 h-3 rounded-full animate-ping"></div>
                                                                        <?php } ?>
                                                                        <div class="flex-grow mr-2 self-center"><span><?php echo $result[5]; ?></span>
                                                                            <?php if ($result[0] == get_page_category_homepage($categoryID)) { ?>
                                                                                <i class="fas fa-home" aria-hidden="true"></i>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <div class="text-xs normal-case font-normal">
                                                                            <?php echo stripslashes($result[6]); ?>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <a href="approve/?pageID=<?php echo $result[0]; ?>" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:text-white bg-<?php echo THEME_PANEL_COLOUR; ?>-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                                                            Approve
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="text-xs normal-case font-normal text-gray-400 italic">
                                                                    <?php
                                                                    if ($status == 'red') {
                                                                        echo 'Pending approval request from '.get_user_fullname(get_page_pending_user_id($result[0])).'.';
                                                                    } elseif (get_page_content($result[0]) == null || get_page_content($result[0]) == '') {
                                                                        echo 'This page has not been edited by anyone yet.';
                                                                    } else {
                                                                        echo 'Last edited by '.get_user_fullname(get_page_last_edit_user_id($result[0])).' at '.get_page_last_edit_timestamp($result[0]).'.';
                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                        unset($result, $status);
                    }
                }
                if (get_user_roleID($_SESSION['id']) >= PERMISSION_CREATE_PAGE) {
                    echo display_page_new_form(strtolower($cresult[0]));
                } ?>
                                                <br><br><br><br>
                                            </ul>
                                        </div>
                                        <?php echo $key; ?>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <?php
                    if (is_nan($approved / $total) * 100) {
                        $statusColour = 'gray';
                        $sCol = 'gray';
                        $status = 'No Pages';
                    } elseif ((($approved / $total) * 100) == 100.00) {
                        $statusColour = 'green';
                        $sCol = 'green';
                        $status = 'No Pending Approvals';
                    } elseif ((($approved / $total) * 100) != 0 || (($pending / $total) * 100) != 0) {
                        $statusColour = 'red';
                        $sCol = 'red';
                        $status = 'Pending Approvals';
                    } elseif ((($approved / $total) * 100) == 0 && (($pending / $total) * 100) == 0) {
                        $statusColour = 'green';
                        $sCol = 'green';
                        $status = 'No Pending Approvals';
                    } else {
                        $statusColour = 'gray';
                        $sCol = 'gray';
                        $status = 'Unknown Status';
                    } ?>
                    <div class="flex w-full space-x-4">
                        <div class="flex w-full">
                            <div class="flex-grow">
                                <h1 class="text-2xl leading-tight text-gray-900 dark:text-white"><?php echo $cresult[0]; ?></h1>
                                <span class="text-xs font-semibold inline-block py-1 px-2 height-auto rounded-lg text-<?php echo $statusColour; ?>-900 bg-<?php echo $statusColour; ?>-200 dark:text-white dark:bg-<?php echo $statusColour; ?>-600"><?php echo $status; ?></span>
                            </div>
                            <?php /*
                                    <div class="flex mb-1 items-center justify-between">
                                        <div class="text-right">
                                            <span class="text-xs font-semibold inline-block">
                                                Written:
                                                <span class="text-xs font-semibold inline-block text-gray-600">
                                                    <?php echo
                                                        $written = $complete + $pending;
                        $percent = ($written / $total) * 100;
                        if (is_nan($percent)) {
                            echo'N/A';
                        } else {
                            echo number_format((float) $percent, 2, '.', '').'%';
                        } ?>
                                                </span>
                                            </span>
                                            <br>
                                            <span class="text-xs font-semibold inline-block">
                                                Approved:
                                                <span class="text-xs font-semibold inline-block text-gray-600">
                                                <?php
                                                    $percent = ($complete / $total) * 100;
                        if (is_nan($percent)) {
                            echo'N/A';
                        } else {
                            echo number_format((float) $percent, 2, '.', '').'%';
                        } ?>
                                                </span>
                                            </span>
                                        </div>
                                    </div> */ ?>
                        </div>
                        <div class="flex-none w-22 h-12">
                            <a @click="open = true" class="dark:bg-neutral-600 dark:hover:bg-neutral-500 dark:text-white hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-4 py-1 border border-transparent text-base font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full">
                                Select
                            </a>
                        </div>
                    </div>
                    <div class="flex float-right h-auto relative w-full mt-3">
                        <div class="overflow-hidden h-1.5 text-xs flex rounded bg-green-400 dark:bg-green-600 w-full">
                            <div style="width:<?php echo 100 - ($pending / $total) * 100 ?>%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500 dark:bg-green-600"></div>
                            <div style="width:<?php echo($pending / $total) * 100 ?>%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500 dark:bg-red-600"></div>
                        </div>
                    </div>
                    <br>
                    <?php
                    unset($cresult);
                get_assigned_editors();
                get_assigned_writers(); ?>
                </div>
                <br><hr class="dark:text-neutral-900 text-gray-200"><br>
                <?php
            }
            if (get_user_roleID($_SESSION['id']) >= PERMISSION_CREATE_CATEGORY) {
                echo display_category_new_form();
            }
            ?>
        </div>
    </body>
</html>