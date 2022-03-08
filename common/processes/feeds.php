<?php

    function feed_rss($type): string
    {
        if ($type == 1) {
            return feed_rss_articles();
        } elseif ($type == 2) {
            return feed_rss_page_updates();
        } else {
            return __('404Feed');
        }
    }

    function feed_rss_articles(): string
    {
        require __DIR__.'/database/connect.php';
        $query = 'SELECT * FROM `'.DATABASE_PREFIX."articles` WHERE `status` = 'PUBLISHED';";
        $rs = mysqli_query($conn, $query);

        if (SECURITY_USE_HTTPS) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        header('Content-type: application/xml');

        $feed = "<?xml version='1.0' encoding='UTF-8'?>
        <rss version='2.0'>
            <channel>
                <title>".CONFIG_SITE_NAME.' '.__('Panel:Articles').'</title>
                <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].'/articles</link>
                <description>'.CONFIG_SITE_NAME.' '.__('Panel:Articles').'</description>
                <language>'.CONFIG_LANGUAGE.'</language>
                <image>
                    <url>'.$protocol.'://'.$_SERVER['HTTP_HOST'].THEME_SOCIAL_IMAGE.'</url>
                    <title>'.CONFIG_SITE_NAME.' '.__('Panel:Articles').'</title>
                    <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].'/articles</link>
                </image>';
        while ($row = mysqli_fetch_assoc($rs)) {
            if ($row['content'] != null) {
                $feed .= '
                <item>
                    <title>'.$row['title'].'</title>
                    <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].'/articles/'.$row['id'].'</link>
                    <description>'.strip_tags(stripslashes(html_entity_decode($row['content']))).'</description>
                    <author>'.CONFIG_EMAIL_ADMIN.' ('.get_author_fullname($row['author_id']).')</author>
                </item>';
            }
        }

        $feed .= '
            </channel>
        </rss>';

        return $feed;
    }

    function feed_rss_page_updates()
    {
        require __DIR__.'/database/connect.php';
        $query = 'SELECT * FROM `'.DATABASE_PREFIX.'pages_history` WHERE 1;';
        $rs = mysqli_query($conn, $query);

        if (SECURITY_USE_HTTPS) {
            $protocol = 'https';
        } else {
            $protocol = 'http';
        }

        header('Content-type: application/xml');

        $feed = "<?xml version='1.0' encoding='UTF-8'?>
        <rss version='2.0'>
            <channel>
                <title>".CONFIG_SITE_NAME.' '.__('Panel:PageUpdates').'</title>
                <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].'</link>
                <description>'.CONFIG_SITE_NAME.' '.__('Panel:PageUpdates').'</description>
                <language>'.CONFIG_LANGUAGE.'</language>
                <image>
                    <url>'.$protocol.'://'.$_SERVER['HTTP_HOST'].THEME_SOCIAL_IMAGE.'</url>
                    <title>'.CONFIG_SITE_NAME.' '.__('Panel:PageUpdates').'</title>
                    <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].'</link>
                </image>';
        while ($row = mysqli_fetch_assoc($rs)) {
            $query2 = 'SELECT `title`,`description`,`url` FROM `'.DATABASE_PREFIX.'pages` WHERE `id` ='.$row['page_id'];
            $rs2 = mysqli_query($conn, $query2);
            $row2 = mysqli_fetch_assoc($rs2);
            $name = get_author_fullname($row['user_id']);
            $feed .= '
                <item>
                    <title>'.$row2['title'].'</title>
                    <link>'.$protocol.'://'.$_SERVER['HTTP_HOST'].$row2['url'].'</link>
                    <description>'.$name.' '.__('Panel:EditedPageTitled').' '.$row2['title'].' at '.$row['timestamp'].'</description>
                    <author>'.CONFIG_EMAIL_ADMIN.' ('.$name.')</author>
                </item>';
        }

        $feed .= '
            </channel>
        </rss>';

        return $feed;
    }

    function get_author_fullname($id)
    {
        $id = checkInput('DEFAULT', $id);

        global $conn;

        $query = 'SELECT `first_name`, `last_name` FROM `'.DATABASE_PREFIX.'users` WHERE `id` = '.$id;
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        if (get_user_settings_privacy_abbreviate_surname($id)) {
            $lastname = $row['last_name'];
            $lastname = substr($lastname, 0, 1);

            return $row['first_name'].' '.$lastname;
        } else {
            return $row['first_name'].' '.$row['last_name'];
        }
    }
