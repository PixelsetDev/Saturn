<?php
    function get_last_activity_time($id): string
    {
        $id = checkInput('DEFAULT', $id);

        $date = strtotime(get_user_last_seen($id));
        $now = time();
        return $now - $date;
    }

    function get_activity_colour($id): string
    {
        $id = checkInput('DEFAULT', $id);

        $lastActivity = get_last_activity_time($id);

        if ($lastActivity <= '1800') {
            $colour = 'green'; // Online
        } else if ($lastActivity > '1800' && $lastActivity <= '3600') {
            $colour = 'yellow'; // Idle
        } else if ($lastActivity > '3600') {
            $colour = 'red'; // Offline
        } else {
            $colour = 'blue'; // Unknown result
        }

        return $colour;
    }