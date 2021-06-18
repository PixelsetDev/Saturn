<?php

    function display_dashboard_statistics($id)
    {
        echo'<h1 class="text-3xl text-gray-700 dark:text-gray-50 mt-4">Your Statistics</h1>';

        $edits = get_user_edits($id);
        list($max, $current, $next, $colour) = getvalues_dashboard_statistics($edits);
        echo display_dashboard_edits($edits, $max, $current, $next, $colour);

        if (get_user_roleID($_SESSION['id'])) {
            $approvals = get_user_approvals($id);
            list($max, $current, $next, $colour) = getvalues_dashboard_statistics($approvals);
            echo display_dashboard_approvals($approvals, $max, $current, $next, $colour);
        }
    }
    function getvalues_dashboard_statistics($value): array
    {
        if ($value < '10') {
            $max = '10';
            $current = 'Beginner';
            $next = 'Explorer';
            $colour = 'red';
        } elseif ($value < '20') {
            $max = '20';
            $current = 'Explorer';
            $next = 'Junior';
            $colour = 'yellow';
        } elseif ($value < '30') {
            $max = '30';
            $current = 'Junior';
            $next = 'Experienced';
            $colour = 'green';
        } elseif ($value < '40') {
            $max = '40';
            $current = 'Experienced';
            $next = 'Senior';
            $colour = 'blue';
        } elseif ($value < '50') {
            $max = '50';
            $current = 'Senior';
            $next = 'Semi-Pro';
            $colour = 'purple';
        } elseif ($value < '100') {
            $max = '100';
            $current = 'Semi-Pro';
            $next = 'Professional';
            $colour = 'pink';
        } elseif ($value < '200') {
            $max = '200';
            $current = 'Professional';
            $next = 'Master';
            $colour = 'red';
        } elseif ($value < '500') {
            $max = '500';
            $current = 'Master';
            $next = 'Legendary';
            $colour = 'yellow';
        } else {
            $max = '500';
            $current = 'Legendary';
            $next = 'None';
            $colour = 'green';
        }

        return [$max, $current, $next, $colour];
    }

    function display_dashboard_edits($edits, $maxedits, $current, $next, $colour): string
    {
        return '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-'.$colour.'-100">
                                        <i class="fas fa-user-edit text-'.$colour.'-500"></i>
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
                                <div style="width:'.(($edits / $maxedits) * 100).'%" class="h-full text-center text-xs text-white bg-'.$colour.'-400">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-'.$colour.'-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">'.$next.'</p>
                        </div>
                        <div class="w-full h-3 bg-'.$colour.'-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-'.$colour.'-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }

    function display_dashboard_approvals($approvals, $maxapprovals, $current, $next, $colour): string
    {
        return '<div class="flex mt-4">
                    <div class="shadow-lg rounded-xl w-full bg-white dark:bg-gray-700 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-'.$colour.'-100">
                                        <i class="fas fa-user-check text-'.$colour.'-500"></i>
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
                                <div style="width:'.(($approvals / $maxapprovals) * 100).'%" class="h-full text-center text-xs text-white bg-'.$colour.'-400"></div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-lg rounded-xl w-1/6 bg-white text-'.$colour.'-500 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">Next Level:</p>
                            <p class="mt-2">'.$next.'</p>
                        </div>
                        <div class="w-full h-3 bg-'.$colour.'-100 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-'.$colour.'-100">
                            </div>
                        </div>
                    </div>
                </div>';
    }
