<?php

namespace QOTD;

class QOTD
{
    public function __construct()
    {
        global $Plugins;

        $Plugins->RegisterHook('PANEL_SIDEBAR_LINKS_END', __NAMESPACE__ .'\QOTD::GetQOTD');
    }

    public static function GetQOTD() {
        $Quote = json_decode(file_get_contents('https://zenquotes.io/api/today'));
        echo '<div>&nbsp;</div><div class="text-xs md:block hidden" id="QOTDPlugin"><span class="" id="QOTD">'.$Quote[0]->q.'</span><br><span class="italic" id="QOTDAuthor">'.$Quote[0]->a.' (Zen Quotes API)</span></div>';
    }
}

$QOTD = new QOTD();