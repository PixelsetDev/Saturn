<?php

namespace QOTD;

use Saturn\ClientKit\GUI;

class QOTD
{
    public function __construct()
    {
        global $Plugins;

        $Plugins->RegisterHook('PANEL_DASH_WIDGETS_END', __NAMESPACE__.'\QOTD::DashboardQOTD');
    }

    public static function DashboardQOTD(): void
    {
        $Quote = self::GetQOTD();
        $GUI = new GUI();
        echo $GUI->Widget('<div class="flex flex-col justify-start">
                            <h2 class="text-3xl font-bold mb-2">Quote of the Day</h2>
                            <p class="text-xl text-left my-2">
                                "'.$Quote[0]->q.'" <span class="text-sm">- '.$Quote[0]->a.'</span><br>
                                <span class="italic text-xs text-neutral-400">Provided by ZenQuotes API</span>
                            </p>
                        </div>');
    }

    public static function GetQOTD()
    {
        return json_decode(file_get_contents('https://zenquotes.io/api/today'));
    }
}

new QOTD();
