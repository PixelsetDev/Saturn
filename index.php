<?php

ob_start();
/**
 * @author      LMWN <contact@lmwn.co.uk>
 * @copyright   Copyright (c), 2021 LMWN & Lewis Milburn
 *
 * This file is a modified version of the demo router provided by https://github.com/bramus/router.
 */
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}
require_once __DIR__.'/common/global_public.php';
require_once 'router.php';
$router = new \Saturn\Router\Router();

// Error Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    require_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/common/processes/error/404.php';
});

// Panel 404
$router->set404('/panel(/.*)?', function () {
    header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found');
    require_once $_SERVER['DOCUMENT_ROOT'].CONFIG_INSTALL_URL.'/panel/system/error/index.php';
});

$router->set404('/api(/.*)?', function () {
    header('HTTP/1.1 404 Not Found');
    header('Content-Type: application/json');

    $jsonArray = [];
    $jsonArray['status'] = '404';
    $jsonArray['status_text'] = 'route not defined';

    echo json_encode($jsonArray);
});

// Before Router Middleware
$router->before('GET', '/.*', function () {
    header('X-Powered-By: saturn/router');
});

/**
 * RSS Feeds.
 */
$router->mount('/rss', function () use ($router) {
    //rss
    $router->get('/', function () {
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <head>
                <title>RSS Feeds - <?php echo CONFIG_SITE_NAME; ?></title>
                <?php include_once __DIR__.'/common/vendors.php'; ?>
            </head>
            <body>
                <div class="p-2">
                    <section class="mb-10">
                        <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/logo.png" class="w-1/4 mx-auto" alt="<?php echo CONFIG_SITE_NAME; ?>">
                        <h1 class="text-4xl w-full text-center"><?php echo CONFIG_SITE_NAME; ?> RSS Feeds</h1>
                    </section>
                    <?php $current_url = 'feed://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
                    <section>
                        <div class="mb-2">
                            <h1 class="text-2xl">Articles</h1>
                            <p>Link: <a href="<?php echo $current_url; ?>/articles"><?php echo $current_url; ?>/articles</a></p>
                        </div>
                        <div class="mb-2">
                            <h1 class="text-2xl">Page Updates</h1>
                            <p>Link: <a href="<?php echo $current_url; ?>/page-updates"><?php echo $current_url; ?>/page-updates</a></p>
                        </div>
                    </section>
                </div>
            </body>
        </html>
        <?php
    });
    //rss/articles
    $router->get('/articles', function () {
        ?>

        <?php
    });
    //rss/pagehistory
    $router->get('/page-updates', function () {
        ?>

        <?php
    });
});

$result = $conn->query('SELECT `url`  FROM `'.DATABASE_PREFIX.'pages` WHERE 1 ORDER BY `id` DESC');

if ($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        foreach ($row as $page_uri) {
            $router->get($page_uri, function () {
                $pageuri = $_SERVER['REQUEST_URI'];
                require_once __DIR__.'/common/processes/render_engine/pages.php';
            });
        }
    }
}

// Homepage
$router->get('/', function () {
    echo '<h1>Saturn</h1><p>Whoops, we were unable to locate a file to render for the homepage. Please allocate a homepage in the Saturn Panel.</p>';
});

// Subrouting
$router->mount('/articles', function () use ($router) {
    $router->get('/', function () {
        require_once __DIR__.'/common/processes/render_engine/articles.php';
    });

    $router->get('/(\d+)', function ($id) {
        $articleID = htmlspecialchars($id);
        require_once __DIR__.'/common/processes/render_engine/articles.php';
    });
});

// Thunderbirds are go!
$router->run();

// EOF
ob_end_flush();
