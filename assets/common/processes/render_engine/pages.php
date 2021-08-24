<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/assets/common/global_public.php';

function get_page_id_from_url($uri)
{
    $uri = checkInput('HTML', $uri);

    global $conn;

    $query = 'SELECT `id` FROM `'.DATABASE_PREFIX."pages` WHERE `url` = '".$uri."';";
    $rs = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($rs);

    return $row['id'];
}

function getdata($pageID): array
{
    $pageData['title'] = get_page_title($pageID);
    $pageData['content'] = get_page_content($pageID);
    $pageData['author']['id'] = get_page_last_edit_user_id($pageID);
    $pageData['section']['navigation'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/navigation.template');
    $pageData['section']['footer'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/footer.template');

    return $pageData;
}

function replacedata($pageOutput, $pageData): string
{
    $pageOutput = str_replace('{{data:title}}', $pageData['title'], $pageOutput);
    $pageOutput = str_replace('{{data:content}}', $pageData['content'], $pageOutput);
    $pageOutput = str_replace('{{data:author:name}}', $pageData['author']['id'], $pageOutput);
    $pageOutput = str_replace('{{section:navigation}}', $pageData['section']['navigation'], $pageOutput);

    return str_replace('{{section:footer}}', $pageData['section']['footer'], $pageOutput);
}

$pageID = get_page_id_from_url($pageuri);

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/theme.json'));

$file = strtolower(get_page_template($pageID));
$pageOutput = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/'.$file.'.template');

$pageData = getdata($pageID);
echo replacedata($pageOutput, $pageData);
