<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/common/global_public.php';

const THEME_DIRECTORY = '/themes/';

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
    $pageData['references'] = get_page_references($pageID);
    $pageData['description'] = get_page_description($pageID);
    $pageData['author']['id'] = get_page_last_edit_user_id($pageID);
    $pageData['section']['navigation'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/navigation.tt');
    $pageData['section']['footer'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/footer.tt');
    $pageData['image']['url'] = get_page_image($pageID);
    $pageData['image']['credit'] = get_page_image_credit($pageID);
    $pageData['image']['license'] = get_page_image_license($pageID);

    return $pageData;
}

function replacedata($pageOutput, $pageData, $themeData): string
{
    if (CONFIG_DEBUG) {
        $starttime = microtime(true);
    }
    // Sections
    if ($pageData['section']['navigation'] != null) {
        $pageOutput = str_replace('{{section:navigation}}', $pageData['section']['navigation'], $pageOutput);
    }
    if ($pageData['section']['footer'] != null) {
        $pageOutput = str_replace('{{section:footer}}', $pageData['section']['footer'], $pageOutput);
    }
    // Page Data
    if ($pageData['title'] != null) {
        $pageOutput = str_replace('{{page:title}}', $pageData['title'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:title}}', '', $pageOutput);
    }
    if ($pageData['content'] != null) {
        $pageOutput = str_replace('{{page:content}}', $pageData['content'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:content}}', '', $pageOutput);
    }
    if ($pageData['references'] != null) {
        $pageOutput = str_replace('{{page:references}}', $pageData['references'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:references}}', '', $pageOutput);
    }
    if ($pageData['description'] != null) {
        $pageOutput = str_replace('{{page:description}}', $pageData['description'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:description}}', '', $pageOutput);
    }
    if ($pageData['author']['id'] != null) {
        $pageOutput = str_replace('{{page:author:name}}', get_user_fullname($pageData['author']['id']), $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:author:name}}', '', $pageOutput);
    }
    if ($pageData['image']['url'] != null) {
        $pageOutput = str_replace('{{page:image}}', $pageData['image']['url'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:image}}', '', $pageOutput);
    }
    if ($pageData['image']['credit'] != null) {
        $pageOutput = str_replace('{{page:image:credit}}', $pageData['image']['credit'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:image:credit}}', '', $pageOutput);
    }
    if ($pageData['image']['license'] != null) {
        $pageOutput = str_replace('{{page:image:license}}', $pageData['image']['license'], $pageOutput);
    } else {
        $pageOutput = str_replace('{{page:image:license}}', '', $pageOutput);
    }
    // Data
    try {
        $pageOutput = str_replace('{{data:random:integer}}', random_int(0, 9999), $pageOutput);
    } catch (Exception $e) {
        errorHandlerError($e, 'Random integer creation error.');
    }
    // Config values
    if (CONFIG_INSTALL_URL != null) {
        $pageOutput = str_replace('{{config:basedir}}', CONFIG_INSTALL_URL, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:basedir}}', '', $pageOutput);
    }
    if (CONFIG_SITE_TIMEZONE != null) {
        $pageOutput = str_replace('{{config:timezone}}', CONFIG_SITE_TIMEZONE, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:timezone}}', '', $pageOutput);
    }
    if (CONFIG_SITE_NAME != null) {
        $pageOutput = str_replace('{{config:sitename}}', CONFIG_SITE_NAME, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:sitename}}', '', $pageOutput);
    }
    if (CONFIG_SITE_DESCRIPTION != null) {
        $pageOutput = str_replace('{{config:description}}', CONFIG_SITE_DESCRIPTION, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:description}}', '', $pageOutput);
    }
    if (CONFIG_SITE_KEYWORDS != null) {
        $pageOutput = str_replace('{{config:keywords}}', CONFIG_SITE_KEYWORDS, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:keywords}}', '', $pageOutput);
    }
    if (CONFIG_SITE_CHARSET != null) {
        $pageOutput = str_replace('{{config:charset}}', CONFIG_SITE_CHARSET, $pageOutput);
    } else {
        $pageOutput = str_replace('{{config:charset}}', '', $pageOutput);
    }
    // Images
    $pageOutput = str_replace('{{image:logo}}', '/storage/images/logo.png', $pageOutput);
    $pageOutput = str_replace('{{image:icon}}', '/storage/images/icon.png', $pageOutput);
    // Colours
    $cd = file_get_contents(__DIR__.'/../../../themes/'.THEME_SLUG.'/'.THEME_COLOUR_SCHEME.'.tc');
    $cd = json_decode($cd);
    $pageOutput = str_replace('{{colour:text}}', $cd->colours->text, $pageOutput);
    $pageOutput = str_replace('{{colour:bg}}', $cd->colours->bg, $pageOutput);
    $pageOutput = str_replace('{{colour:link}}', $cd->colours->link->default, $pageOutput);
    $pageOutput = str_replace('{{colour:link:hover}}', $cd->colours->link->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:link:focus}}', $cd->colours->link->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:text}}', $cd->colours->navbar->text->default, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:text:hover}}', $cd->colours->navbar->text->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:text:focus}}', $cd->colours->navbar->text->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:bg}}', $cd->colours->navbar->bg->default, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:bg:hover}}', $cd->colours->navbar->bg->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:bg:focus}}', $cd->colours->navbar->bg->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:text}}', $cd->colours->navbar->button->text->default, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:text:hover}}', $cd->colours->navbar->button->text->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:text:focus}}', $cd->colours->navbar->button->text->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:bg}}', $cd->colours->navbar->button->bg->default, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:bg:hover}}', $cd->colours->navbar->button->bg->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:navbar:button:bg:focus}}', $cd->colours->navbar->button->bg->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:text}}', $cd->colours->footer->text->default, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:text:hover}}', $cd->colours->footer->text->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:text:focus}}', $cd->colours->footer->text->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:text}}', $cd->colours->footer->button->text->default, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:text:hover}}', $cd->colours->footer->button->text->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:text:focus}}', $cd->colours->footer->button->text->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:bg}}', $cd->colours->footer->button->bg->default, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:bg:hover}}', $cd->colours->footer->button->bg->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:button:bg:focus}}', $cd->colours->footer->button->bg->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:bg}}', $cd->colours->footer->bg->default, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:bg:hover}}', $cd->colours->footer->bg->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:footer:bg:focus}}', $cd->colours->footer->bg->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:button:text}}', $cd->colours->button->text->default, $pageOutput);
    $pageOutput = str_replace('{{colour:button:text:hover}}', $cd->colours->button->text->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:button:text:focus}}', $cd->colours->button->text->focus, $pageOutput);
    $pageOutput = str_replace('{{colour:button:bg}}', $cd->colours->button->bg->default, $pageOutput);
    $pageOutput = str_replace('{{colour:button:bg:hover}}', $cd->colours->button->bg->hover, $pageOutput);
    $pageOutput = str_replace('{{colour:button:bg:focus}}', $cd->colours->button->bg->focus, $pageOutput);
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
        $cdn_css = '';
        $cdn_js = '';
        if (CONFIG_DEBUG) {
            log_console('Saturn][Resource Loader][G-Tags', 'Unable to load framework or a framework may not be assigned.');
        }
    }
    $pageOutput = str_replace('{{cdn:css}}', $cdn_css, $pageOutput);
    $pageOutput = str_replace('{{cdn:js}}', $cdn_js, $pageOutput);
    // Config
    $pageOutput = str_replace('{{config:slug}}', THEME_SLUG, $pageOutput);
    $pageOutput = str_replace('{{config:name}}', $themeData->{'theme'}->{'name'}, $pageOutput);
    $pageOutput = str_replace('{{config:colourscheme}}', THEME_COLOUR_SCHEME, $pageOutput);
    $pageOutput = str_replace('{{config:font}}', THEME_FONT, $pageOutput);
    $pageOutput = str_replace('{{config:panelfont}}', THEME_PANEL_FONT, $pageOutput);
    $pageOutput = str_replace('{{config:panelcolour}}', THEME_PANEL_COLOUR, $pageOutput);
    $pageOutput = str_replace('{{config:socialimage}}', THEME_SOCIAL_IMAGE, $pageOutput);

    if (CONFIG_DEBUG) {
        log_console('Saturn][Resource Loader][G-Tags', 'Converted 73 Global Tags in '.(number_format(microtime(true) - $starttime, 5)).' seconds.');
    }

    return $pageOutput;
}

$pageID = get_page_id_from_url($pageuri);

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/theme.json'));

$file = strtolower(get_page_template($pageID));
$pageOutput = file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/'.$file.'.tt');

$pageData = getdata($pageID);
echo stripslashes(replacedata($pageOutput, $pageData, $data));
