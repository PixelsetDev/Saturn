<?php

    function get_announcement_panel_active(): bool
    {
        global $conn;

        $query = 'SELECT `active` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '1';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['active'];
    }

    function get_announcement_website_active(): bool
    {
        global $conn;

        $query = 'SELECT `active` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '2';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['active'];
    }

    function get_announcement_panel_type(): string
    {
        global $conn;

        $query = 'SELECT `type` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '1';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['type'];
    }

    function get_announcement_website_type(): string
    {
        global $conn;

        $query = 'SELECT `type` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '2';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['type'];
    }

    function get_announcement_panel_title(): string
    {
        global $conn;

        $query = 'SELECT `title` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '1';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_announcement_website_title(): string
    {
        global $conn;

        $query = 'SELECT `title` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '2';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['title'];
    }

    function get_announcement_panel_message(): string
    {
        global $conn;

        $query = 'SELECT `message` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '1';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['message'];
    }

    function get_announcement_website_message(): string
    {
        global $conn;

        $query = 'SELECT `message` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '2';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['message'];
    }

    function get_announcement_panel_link(): string
    {
        global $conn;

        $query = 'SELECT `link` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '1';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['link'];
    }

    function get_announcement_website_link(): string
    {
        global $conn;

        $query = 'SELECT `link` FROM `'.DATABASE_PREFIX."announcements` WHERE `id` = '2';";
        $rs = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($rs);

        return $row['link'];
    }
