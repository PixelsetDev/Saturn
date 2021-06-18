<?php

    /* Config File */
    $config = __DIR__.'/discord.conf';
    $value = file($config);
    $value[0] = str_replace('enabled = ', '', $value[0]);
    $value[1] = str_replace('id = ', '', $value[1]);
    $value[2] = str_replace('appearance = ', '', $value[2]);

    if (strpos($value[0], 'true')) {
        /* Global Tags */
        $globalTag['Discord:Widget'] = '<iframe src="https://discord.com/widget?id='.$value[1].'&theme='.$value[2].'" width="350" height="500" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>';
    }
