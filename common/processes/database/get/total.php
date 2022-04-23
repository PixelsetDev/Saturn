<?php
function get_total_statistics_views_pages() {
    $id = 1;
    $totalViews = 0;

    while (get_user_statistics_views_pages($id) != NULL) {
        $totalViews += get_user_statistics_views_pages($id);
        $id++;
    }

    return $totalViews;
}
function get_total_statistics_views_articles() {
    $id = 1;
    $totalViews = 0;

    while (get_user_statistics_views_articles($id) != NULL) {
        $totalViews += get_user_statistics_views_articles($id);
        $id++;
    }

    return $totalViews;
}