<?php

    function display_dashboard_statistics($id)
    {
        echo'<h1 class="text-3xl text-gray-700 dark:text-gray-50 mt-4">'.__('Panel:Dashboard_Statistics').'</h1>';

        $edits = get_user_statistics_edits($id);
        list($max, $current, $next, $colour) = getvalues_dashboard_statistics($edits);
        echo display_dashboard_statbox('Writer', $edits, $max, $current, $next, $colour);

        if (get_user_roleID($_SESSION['id'])) {
            $approvals = get_user_statistics_approvals($id);
            list($max, $current, $next, $colour) = getvalues_dashboard_statistics($approvals);
            echo display_dashboard_statbox('Editor', $approvals, $max, $current, $next, $colour);
        }
    }
    function getvalues_dashboard_statistics($value): array
    {
        if ($value < '10') {
            $current = 'Beginner';
            $next = 'Explorer';
            $colour = 'red';
        } elseif ($value < '20') {
            $current = 'Explorer';
            $next = 'Junior';
            $colour = 'yellow';
        } elseif ($value < '30') {
            $current = 'Junior';
            $next = 'Experienced';
            $colour = 'green';
        } elseif ($value < '40') {
            $current = 'Experienced';
            $next = 'Senior';
            $colour = 'blue';
        } elseif ($value < '50') {
            $current = 'Senior';
            $next = 'Semi-Pro';
            $colour = 'purple';
        }
        if (isset($colour)) {
            $max = ceil($value / 10) * 10;
        } else {
            if ($value < '100') {
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
        }

        return [$max, $current, $next, $colour];
    }

    function display_dashboard_statbox($type, $current, $max, $currentLevel, $next, $colour): string
    {
        $return = '<div class="flex mt-4">
                    <div class="shadow-md rounded-xl w-full bg-white dark:bg-neutral-800 relative overflow-hidden">
                        <a class="w-full h-full block">
                            <div class="flex items-center justify-between px-4 py-6 space-x-4">
                                <div class="flex items-center">
                                    <span class="rounded-full relative pl-3 pr-2 py-2 bg-'.$colour.'-100 dark:bg-'.$colour.'-300">
                                        <i class="fas fa-user-';
        if ($type == 'Writer') {
            $return .= 'edit';
        } elseif ($type == 'Editor') {
            $return .= 'check';
        }
        $return .= ' text-'.$colour.'-500 dark:text-'.$colour.'-700"></i>
                                    </span>
                                    <p class="text-sm text-gray-700 dark:text-white ml-2 font-semibold">
                                        '.__('Panel:'.$type).' '.__('Panel:Level').': '.$currentLevel.'
                                    </p>
                                </div>
                                <div class="mt-6 md:mt-0 text-black dark:text-white font-bold text-xl">
                                    '.$current.' / '.$max.'
                                    <span class="text-xs text-gray-400">
                                    ';
        if ($type == 'Writer') {
            $return .= __('Panel:Edits');
        } elseif ($type == 'Editor') {
            $return .= __('Panel:Approvals');
        }
        if ($current == 0 || $max == 0) {
            $width = 0;
        } else {
            $width = ($current / $max) * 100;
        }
        $return .= '
                                    </span>
                                </div>
                            </div>
                            <div class="w-full h-3 bg-gray-100 dark:bg-neutral-600 absolute bottom-0">
                                <div style="width:'.$width.'%" class="h-full text-center text-xs text-white bg-'.$colour.'-400 dark:bg-'.$colour.'-600">
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="shadow-md rounded-xl w-1/6 bg-white dark:bg-neutral-800 text-'.$colour.'-500 dark:text-'.$colour.'-700 relative overflow-hidden ml-4">
                        <div class="text-center">
                            <p class="text-xl font-medium mt-4 mx-2">'.__('Panel:NextLevel').'</p>
                            <p class="mt-2">'.$next.'</p>
                        </div>
                        <div class="w-full h-3 bg-'.$colour.'-400 dark:bg-'.$colour.'-600 mt-3">
                            <div class="w-full h-full text-center text-xs text-white bg-'.$colour.'-400 dark:bg-'.$colour.'-600">
                            </div>
                        </div>
                    </div>
                </div>';

        return $return;
    }
