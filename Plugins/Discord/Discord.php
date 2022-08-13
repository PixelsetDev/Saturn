<?php

namespace Discord;

use Saturn\ClientKit\GUI;

class Discord
{
    public function __construct()
    {
        global $Plugins;

        $Plugins->RegisterHook('PANEL_SIDEBAR_END', __NAMESPACE__.'\Discord::Widget');
    }

    public static function Widget(): void
    {
        echo '<iframe src="https://discordapp.com/widget?id='.DISCORD_WIDGET_ID.'&theme=dark" width="100%" height="300" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>';
    }
}

const DISCORD_WIDGET_ID = '818587266062614540';

new Discord();
