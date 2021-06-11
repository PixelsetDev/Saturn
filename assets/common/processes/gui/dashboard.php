<?php
    function display_dashboard_statistics($id){

        echo'<h1 class="text-3xl text-gray-700 dark:text-gray-50 mt-4">Your Statistics</h1>';

        $edits = get_user_edits($id);
        $approvals = get_user_approvals($id);

        if ($edits < '10') {
            $maxedits = '10';
            $current = 'Beginner';
            $next = 'Explorer';
        } else if ($edits < '20') {
            $maxedits = '20';
            $current = 'Explorer';
            $next = 'Junior';
        } else if ($edits < '30') {
            $maxedits = '30';
            $current = 'Junior';
            $next = 'Experienced';
        } else if ($edits < '40') {
            $maxedits = '40';
            $current = 'Experienced';
            $next = 'Senior';
        } else if ($edits < '50') {
            $maxedits = '40';
            $current = 'Senior';
            $next = 'Semi-Pro';
        } else if ($edits < '100') {
            $maxedits = '50';
            $current = 'Semi-Pro';
            $next = 'Professional';
        } else if ($edits < '200') {
            $maxedits = '100';
            $current = 'Professional';
            $next = 'Master';
        } else if ($edits < '500') {
            $maxedits = '200';
            $current = 'Master';
            $next = 'Legendary';
        } else {
            $maxedits = '500';
            $current = 'Legendary';
            $next = 'None';
        }

        echo display_dashboard_edits($edits, $maxedits, $current, $next);

        if(get_user_roleID($_SESSION['id'])) {
            if ($approvals < '10') {
                $maxapprovals = '10';
                $current = 'Beginner';
                $next = 'Explorer';
            } else if ($approvals < '20') {
                $maxapprovals = '20';
                $current = 'Explorer';
                $next = 'Junior';
            } else if ($approvals < '30') {
                $maxapprovals = '30';
                $current = 'Junior';
                $next = 'Experienced';
            } else if ($approvals < '40') {
                $maxapprovals = '40';
                $current = 'Experienced';
                $next = 'Senior';
            } else if ($approvals < '50') {
                $maxapprovals = '40';
                $current = 'Senior';
                $next = 'Semi-Pro';
            } else if ($approvals < '100') {
                $maxapprovals = '50';
                $current = 'Semi-Pro';
                $next = 'Professional';
            } else if ($approvals < '200') {
                $maxapprovals = '100';
                $current = 'Professional';
                $next = 'Master';
            } else if ($approvals < '500') {
                $maxapprovals = '200';
                $current = 'Master';
                $next = 'Legendary';
            } else {
                $maxapprovals = '500';
                $current = 'Legendary';
                $next = 'None';
            }

            echo display_dashboard_approvals($approvals, $maxapprovals, $current, $next);
        }
    }

    function display_dashboard_edits($edits, $maxedits, $current, $next): string {
        return '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-blue-100">
                                        <i class="fas fa-user-edit text-blue-500"></i>
                                    </span>
                                    <p class="text-sm text-gray-700 dark:text-white ml-2 font-semibold">
                                        Writer Level: '.$current.'
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-black dark:text-white font-bold text-xl">
                                    '.$edits.' / '.$maxedits.'
                                    <span class="text-xs text-gray-400">
                                    Edits
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-3 bg-gray-100">
                                <div style="width:'.(($edits / $maxedits) * 100).'%" class="h-full text-center text-xs text-white bg-green-400">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-indigo-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">'.$next.'</p>
                        </div>
                        <div class="w-full h-3 bg-gray-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-indigo-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }

    function display_dashboard_approvals($approvals, $maxapprovals, $current, $next): string {
        return '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-blue-100">
                                        <i class="fas fa-user-check text-blue-500"></i>
                                    </span>
                                    <p class="text-sm text-gray-700 dark:text-white ml-2 font-semibold">
                                        Editor Level: '.$current.'
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-black dark:text-white font-bold text-xl">
                                    '.$approvals.' / '.$maxapprovals.'
                                    <span class="text-xs text-gray-400">
                                    Approvals
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-3 bg-gray-100">
                                <div style="width:'.(($approvals / $maxapprovals) * 100).'%" class="h-full text-center text-xs text-white bg-green-400"></div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-indigo-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">'.$next.'</p>
                        </div>
                        <div class="w-full h-3 bg-gray-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-indigo-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }