
        <meta charset="<?php echo CONFIG_SITE_CHARSET; ?>">
        <meta name="description" content="<?php echo CONFIG_SITE_DESCRIPTION; ?>">
        <meta name="keywords" content="<?php echo CONFIG_SITE_KEYWORDS; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#111827">
        <meta name="robots" content="noindex, nofollow" />
        <link rel="icon" type="image/png" href="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/icon.png">
        <link rel="stylesheet" href="<?php echo CONFIG_INSTALL_URL; ?>/assets/css/tailwind-custom.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo CONFIG_INSTALL_URL; ?>/commonstyles.css">
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.js" integrity="sha256-9R44V6iCmVV7oDivSSvnPm4oYYirH6gC7ft09IS4j+o=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php $url = "https://$_SERVER[HTTP_HOST]"; echo $url; ?>">
        <meta property="og:title" content="<?php echo CONFIG_SITE_NAME; ?>">
        <meta property="og:description" content="<?php echo CONFIG_SITE_DESCRIPTION; ?>">
        <meta property="og:image" content="<?php echo 'https://'.$_SERVER['HTTP_HOST'].THEME_SOCIAL_IMAGE; ?>">
        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="<?php echo $url; unset($url)?>">
        <meta property="twitter:title" content="<?php echo CONFIG_SITE_NAME; ?>">
        <meta property="twitter:description" content="<?php echo CONFIG_SITE_DESCRIPTION; ?>">
        <meta property="twitter:image" content="<?php echo 'https://'.$_SERVER['HTTP_HOST'].THEME_SOCIAL_IMAGE; ?>">