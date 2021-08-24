<?php

    function get_activity($id): string
    {
        $date = strtotime('2012-03-08 16:02:35');
        $now = time();

        return $now - $date;
    }

    function get_activity_colour($id): string
    {
        return 'blue';
    }
