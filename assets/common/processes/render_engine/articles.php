<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/assets/common/global_public.php';

function getdata($articleID): array
{
    $articleData['title'] = get_article_title($articleID);
    $articleData['content'] = get_article_content($articleID);
    $articleData['author']['id'] = get_article_author_id($articleID);
    $articleData['section']['navigation'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/navigation.tt');
    $articleData['section']['footer'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/footer.tt');

    return $articleData;
}

function replacedata($articleOutput, $articleData): string
{
    if (CONFIG_DEBUG) {
        $starttime = microtime(true);
    }
    $articleOutput = str_replace('{{data:title}}', $articleData['title'], $articleOutput);
    $articleOutput = str_replace('{{data:content}}', $articleData['content'], $articleOutput);
    $articleOutput = str_replace('{{data:author:name}}', $articleData['author']['id'], $articleOutput);
    $articleOutput = str_replace('{{section:navigation}}', $articleData['section']['navigation'], $articleOutput);
    // Config values
    $articleOutput = str_replace('{{config:basedir}}', CONFIG_INSTALL_URL, $articleOutput);
    $articleOutput = str_replace('{{config:timezone}}', CONFIG_SITE_TIMEZONE, $articleOutput);
    $articleOutput = str_replace('{{config:sitename}}', CONFIG_SITE_NAME, $articleOutput);
    $articleOutput = str_replace('{{config:description}}', CONFIG_SITE_DESCRIPTION, $articleOutput);
    $articleOutput = str_replace('{{config:keywords}}', CONFIG_SITE_KEYWORDS, $articleOutput);
    $articleOutput = str_replace('{{config:charset}}', CONFIG_SITE_CHARSET, $articleOutput);

    if (CONFIG_DEBUG) {
        log_console('Saturn][Resource Loader][G-Tags', 'Converted 10 Global Tags in '.(number_format(microtime(true) - $starttime, 5)).' seconds.');
    }

    return str_replace('{{section:footer}}', $articleData['section']['footer'], $articleOutput);
}

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/theme.json'));

$articleOutput = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/article.tt');

$articleData = getdata($articleID);
echo replacedata($articleOutput, $articleData);
