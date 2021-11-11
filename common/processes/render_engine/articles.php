<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/common/global_public.php';

function getdata($articleID): array
{
    $articleData['title'] = get_article_title($articleID);
    $articleData['content'] = get_article_content($articleID);
    $articleData['author']['id'] = get_article_author_id($articleID);
    $articleData['section']['navigation'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/navigation.tt');
    $articleData['section']['footer'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/footer.tt');

    return $articleData;
}

function replacedata($articleOutput, $articleData, $themeData): string
{
    if (CONFIG_DEBUG) {
        $starttime = microtime(true);
    }
    // Sections
    $articleOutput = str_replace('{{section:navigation}}', $articleData['section']['navigation'], $articleOutput);
    $articleOutput = str_replace('{{section:footer}}', $articleData['section']['footer'], $articleOutput);
    // Data
    $articleOutput = str_replace('{{data:title}}', $articleData['title'], $articleOutput);
    $articleOutput = str_replace('{{data:content}}', $articleData['content'], $articleOutput);
    $articleOutput = str_replace('{{data:author:name}}', $articleData['author']['id'], $articleOutput);
    // Config values
    $articleOutput = str_replace('{{config:basedir}}', CONFIG_INSTALL_URL, $articleOutput);
    $articleOutput = str_replace('{{config:timezone}}', CONFIG_SITE_TIMEZONE, $articleOutput);
    $articleOutput = str_replace('{{config:sitename}}', CONFIG_SITE_NAME, $articleOutput);
    $articleOutput = str_replace('{{config:description}}', CONFIG_SITE_DESCRIPTION, $articleOutput);
    $articleOutput = str_replace('{{config:keywords}}', CONFIG_SITE_KEYWORDS, $articleOutput);
    $articleOutput = str_replace('{{config:charset}}', CONFIG_SITE_CHARSET, $articleOutput);
    // Images
    $articleOutput = str_replace('{{image:logo}}', '/assets/storage/images/logo.png', $articleOutput);
    $articleOutput = str_replace('{{image:icon}}', '/assets/storage/images/icon.png', $articleOutput);
    // Colours
    $articleOutput = str_replace('{{theme:colour:text}}', '', $articleOutput);
    $articleOutput = str_replace('{{theme:colour:bg}}', '', $articleOutput);
    $articleOutput = str_replace('{{theme:colour:navbarbg}}', '', $articleOutput);
    $articleOutput = str_replace('{{theme:colour:navbartext}}', '', $articleOutput);
    $articleOutput = str_replace('{{theme:colour:footerbg}}', '', $articleOutput);
    $articleOutput = str_replace('{{theme:colour:footertext}}', '', $articleOutput);
    // CDN
    if ($themeData->{'theme'}->{'framework'} == 'tailwind') {
        $cdn_css = 'https://unpkg.com/tailwindcss@2.2.16/dist/tailwind.min.css';
        $cdn_js = 'https://unpkg.com/alpinejs@2.8.2/dist/alpine.js';
    } elseif ($themeData->{'theme'}->{'framework'} == 'bootstrap') {
        $cdn_css = 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css';
        $cdn_js = 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js';
    } elseif ($themeData->{'theme'}->{'framework'} == 'materialize') {
        $cdn_css = 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css';
        $cdn_js = 'https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js';
    } else {
        if (CONFIG_DEBUG) {
            $cdn_css = '';
            $cdn_js = '';
            log_console('Saturn][Resource Loader][G-Tags', 'Unable to load framework or a framework may not be assigned.');
        }
    }
    $articleOutput = str_replace('{{cdn:css}}', $cdn_css, $articleOutput);
    $articleOutput = str_replace('{{cdn:js}}', $cdn_js, $articleOutput);
    // Config
    $articleOutput = str_replace('{{config:slug}}', THEME_SLUG, $articleOutput);
    $articleOutput = str_replace('{{config:name}}', $themeData->{'theme'}->{'name'}, $articleOutput);
    $articleOutput = str_replace('{{config:colourscheme}}', THEME_COLOUR_SCHEME, $articleOutput);
    $articleOutput = str_replace('{{config:font}}', THEME_FONT, $articleOutput);
    $articleOutput = str_replace('{{config:panelfont}}', THEME_PANEL_FONT, $articleOutput);
    $articleOutput = str_replace('{{config:panelcolour}}', THEME_PANEL_COLOUR, $articleOutput);
    $articleOutput = str_replace('{{config:socialimage}}', THEME_SOCIAL_IMAGE, $articleOutput);

    if (CONFIG_DEBUG) {
        log_console('Saturn][Resource Loader][G-Tags', 'Converted 28 Global Tags in '.(number_format(microtime(true) - $starttime, 5)).' seconds.');
    }

    return str_replace('{{section:footer}}', $articleData['section']['footer'], $articleOutput);
}

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/theme.json'));

$articleOutput = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/article.tt');

$articleData = getdata($articleID);
echo replacedata($articleOutput, $articleData, $data);
