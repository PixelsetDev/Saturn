<?php
$themeDataJSON = file_get_contents(__DIR__.'/../../../../themes/'.THEME_SLUG.'/theme.json');
$themeData = json_decode($themeDataJSON);
if ($themeData->{'theme'}->{'name'} != null || $themeData->{'theme'}->{'name'} != '') {
    log_console('SATURN][RESOURCE LOADER][THEMES','Loaded theme: '.$themeData->{'theme'}->{'name'});
}