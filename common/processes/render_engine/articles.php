<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/common/global_public.php';

const THEME_DIRECTORY = '/themes/';

function getarticles()
{
    $i = 1;
    $article = get_article_title($i);
    $articleStatus = get_article_status($i);
    $return = '';
    while ($article != null) {
        if ($articleStatus == 'PUBLISHED') {
            $return .= '<div class="w-full bg-gray-100 rounded-md shadow hover:shadow-xl mb-8 p-2 transition duration-200 flex">
    <div class="flex-grow">
        <h1 class="text-xl">'.$article.'</h1>
        <p>By '.get_user_fullname(get_article_author_id($i)).'</p>
    </div>
    <div>
        <a href="/articles/'.$i.'" class="hover:shadow-lg cursor-pointer w-full h-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 transition-all duration-200 md:py-1 md:text-rg md:px-10">
            <i class="fas fa-eye" aria-hidden="true"></i>&nbsp;View
        </a>
    </div>
</div>';
        }
        unset($article, $articleStatus);
        $i++;
        $article = get_article_title($i);
        $articleStatus = get_article_status($i);
    }

    return $return;
}

function getdata($articleID): array
{
    if (get_article_status($articleID) == 'PUBLISHED') {
        $articleData['title'] = get_article_title($articleID);
    } elseif ($articleID != null) {
        $articleData['title'] = __('Panel:Article_Unavailable').'<br><i>'.__('Panel:Article_ReadOther').'</i>';
    }
    if (get_article_status($articleID) == 'PUBLISHED') {
        $articleData['content'] = get_article_content($articleID);
    } elseif ($articleID != null) {
        $articleData['content'] = null;
    }
    $articleData['references'] = get_article_references($articleID);
    $articleData['description'] = null;
    $articleData['author']['id'] = get_article_author_id($articleID);
    $articleData['section']['navigation'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/navigation.tt');
    $articleData['section']['footer'] = file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/footer.tt');
    if ($articleID != null && get_article_status($articleID) == 'PUBLISHED') {
        $articleData['section']['articles'] = $articleData['content'].'<br><br>'.$articleData['references'].'<br><br><em>'.__('Panel:Article_WrittenBy').' '.get_user_fullname($articleData['author']['id']).'</em>';
    } else {
        $articleData['section']['articles'] = getarticles();
    }
    $articleData['image']['url'] = null;
    $articleData['image']['credit'] = null;
    $articleData['image']['license'] = null;

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
    $articleOutput = str_replace('{{section:articles}}', $articleData['section']['articles'], $articleOutput);
    // Article Data
    $articleOutput = str_replace('{{page:title}}', $articleData['title'], $articleOutput);
    $articleOutput = str_replace('{{page:content}}', $articleData['content'], $articleOutput);
    $articleOutput = str_replace('{{page:references}}', $articleData['references'], $articleOutput);
    $articleOutput = str_replace('{{page:description}}', $articleData['description'], $articleOutput);
    $articleOutput = str_replace('{{page:author:name}}', get_user_fullname($articleData['author']['id']), $articleOutput);
    $articleOutput = str_replace('{{page:image}}', $articleData['image']['url'], $articleOutput);
    $articleOutput = str_replace('{{page:image:credit}}', $articleData['image']['credit'], $articleOutput);
    $articleOutput = str_replace('{{page:image:license}}', $articleData['image']['credit'], $articleOutput);
    // Data
    try {
        $articleOutput = str_replace('{{data:random:integer}}', random_int(0, 9999), $articleOutput);
    } catch (Exception $e) {
        errorHandlerError($e, __('Error:RandomInteger'));
    }
    // Config values
    $articleOutput = str_replace('{{config:basedir}}', CONFIG_INSTALL_URL, $articleOutput);
    $articleOutput = str_replace('{{config:timezone}}', CONFIG_SITE_TIMEZONE, $articleOutput);
    $articleOutput = str_replace('{{config:sitename}}', CONFIG_SITE_NAME, $articleOutput);
    $articleOutput = str_replace('{{config:description}}', CONFIG_SITE_DESCRIPTION, $articleOutput);
    $articleOutput = str_replace('{{config:keywords}}', CONFIG_SITE_KEYWORDS, $articleOutput);
    $articleOutput = str_replace('{{config:charset}}', CONFIG_SITE_CHARSET, $articleOutput);
    // Images
    $articleOutput = str_replace('{{image:logo}}', '/storage/images/logo.png', $articleOutput);
    $articleOutput = str_replace('{{image:icon}}', '/storage/images/icon.png', $articleOutput);
    // Colours
    $cd = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/'.THEME_COLOUR_SCHEME.'.tc');
    $cd = json_decode($cd);
    $articleOutput = str_replace('{{colour:text}}', $cd->colours->text, $articleOutput);
    $articleOutput = str_replace('{{colour:bg}}', $cd->colours->bg, $articleOutput);
    $articleOutput = str_replace('{{colour:link}}', $cd->colours->link->default, $articleOutput);
    $articleOutput = str_replace('{{colour:link:hover}}', $cd->colours->link->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:link:focus}}', $cd->colours->link->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:text}}', $cd->colours->navbar->text->default, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:text:hover}}', $cd->colours->navbar->text->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:text:focus}}', $cd->colours->navbar->text->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:bg}}', $cd->colours->navbar->bg->default, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:bg:hover}}', $cd->colours->navbar->bg->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:bg:focus}}', $cd->colours->navbar->bg->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:text}}', $cd->colours->navbar->button->text->default, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:text:hover}}', $cd->colours->navbar->button->text->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:text:focus}}', $cd->colours->navbar->button->text->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:bg}}', $cd->colours->navbar->button->bg->default, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:bg:hover}}', $cd->colours->navbar->button->bg->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:navbar:button:bg:focus}}', $cd->colours->navbar->button->bg->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:text}}', $cd->colours->footer->text->default, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:text:hover}}', $cd->colours->footer->text->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:text:focus}}', $cd->colours->footer->text->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:text}}', $cd->colours->footer->button->text->default, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:text:hover}}', $cd->colours->footer->button->text->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:text:focus}}', $cd->colours->footer->button->text->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:bg}}', $cd->colours->footer->button->bg->default, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:bg:hover}}', $cd->colours->footer->button->bg->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:button:bg:focus}}', $cd->colours->footer->button->bg->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:bg}}', $cd->colours->footer->bg->default, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:bg:hover}}', $cd->colours->footer->bg->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:footer:bg:focus}}', $cd->colours->footer->bg->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:button:text}}', $cd->colours->button->text->default, $articleOutput);
    $articleOutput = str_replace('{{colour:button:text:hover}}', $cd->colours->button->text->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:button:text:focus}}', $cd->colours->button->text->focus, $articleOutput);
    $articleOutput = str_replace('{{colour:button:bg}}', $cd->colours->button->bg->default, $articleOutput);
    $articleOutput = str_replace('{{colour:button:bg:hover}}', $cd->colours->button->bg->hover, $articleOutput);
    $articleOutput = str_replace('{{colour:button:bg:focus}}', $cd->colours->button->bg->focus, $articleOutput);
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
            log_console('Saturn][Resource Loader][G-Tags', __('FrameworkUnassigned'));
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
        log_console('Saturn][Resource Loader][G-Tags', __('General:Converted_GTAGS_1').' 74 '.__('General:Converted_GTAGS_2').' '.(number_format(microtime(true) - $starttime, 5)).' seconds.');
    }

    return $articleOutput;
}

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].THEME_DIRECTORY.THEME_SLUG.'/theme.json'));

$articleOutput = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME_SLUG.'/article.tt');

$articleData = getdata($articleID);
echo stripslashes(replacedata($articleOutput, $articleData, $data));
