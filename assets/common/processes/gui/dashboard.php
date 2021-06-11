<?php
    function display_dashboard_statistics($id){

        echo'<h1 class="text-3xl text-gray-700 dark:text-gray-50 mt-4">Your Statistics</h1>';
        echo display_dashboard_edits(get_user_edits($id),'6');
        if(get_user_roleID($_SESSION['id'])){echo display_dashboard_approvals(get_user_approvals($id),'6');}
    }

    function display_dashboard_edits($edits, $maxedits): string {
        $send = '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-blue-100">
                                        <i class="fas fa-user-edit text-blue-500"></i>
                                    </span>
                                    <p class="text-sm text-gray-700 dark:text-white ml-2 font-semibold">
                                        Writer Level: Beginner
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-black dark:text-white font-bold text-xl">
                                    '.$edits.' / 6
                                    <span class="text-xs text-gray-400">
                                    Edits
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-3 bg-gray-100">
                                <div class="w-';
        if ($edits > 0) {
            $send = $send.$edits.'/'.$maxedits;
        } else {
            $send = $send.'0';
        }
        return $send.' h-full text-center text-xs text-white bg-green-400">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-indigo-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">Explorer</p>
                        </div>
                        <div class="w-full h-3 bg-gray-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-indigo-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }

    function display_dashboard_approvals($approvals, $maxapprovals): string {
        $send = '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-blue-100">
                                        <i class="fas fa-user-check text-blue-500"></i>
                                    </span>
                                    <p class="text-sm text-gray-700 dark:text-white ml-2 font-semibold">
                                        Editor Level: Beginner
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-black dark:text-white font-bold text-xl">
                                    '.$approvals.' / 6
                                    <span class="text-xs text-gray-400">
                                    Edits
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-3 bg-gray-100">
                                <div class="w-';
        if ($approvals > 0) {
            $send = $send.$approvals.'/'.$maxapprovals;
        } else {
            $send = $send.'0';
        }
        return $send.' h-full text-center text-xs text-white bg-green-400">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-indigo-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">Explorer</p>
                        </div>
                        <div class="w-full h-3 bg-gray-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-indigo-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }