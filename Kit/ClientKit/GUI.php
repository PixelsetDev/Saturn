<?php

namespace Saturn\ClientKit;

class GUI
{
    public function Alert(string $Type, string $Title = null, string $Message = null, array $ButtonsText = null, array $ButtonsLinks = null, string $YMargin = '0')
    {
        $Colour = match (strtoupper($Type)) {
            'ERROR'        => 'red',
            'WARNING'      => 'yellow',
            'SUCCESS'      => 'green',
            'INFO'         => 'blue',
            'NOTIFICATION' => 'neutral'
        };

        if ($Message != null) {
            return '<div class="px-2 py-1 my-'.$YMargin.' bg-'.$Colour.'-100 border-l-2 border-'.$Colour.'-500"><strong>'.$Title.'</strong><br>'.$Message.'</div>';
        } else {
            return '<div class="px-2 py-1 my-'.$YMargin.' bg-'.$Colour.'-100 border-l-2 border-'.$Colour.'-500"><strong>'.$Title.'</strong></div>';
        }
    }

    public function Widget(string $Content, string $Link = null)
    {
        $Widget = '<div class="shadow-lg hover:shadow-xl transition-shadow duration-200 w-auto p-4 bg-neutral-50 dark:bg-neutral-800 mt-8">';
        if ($Link != null) {
            $Widget .= '<a href="'.$Link.'">';
        }
        $Widget .= $Content;
        if ($Link != null) {
            $Widget .= '</a>';
        }
        $Widget .= '</div>';

        return $Widget;
    }
}
