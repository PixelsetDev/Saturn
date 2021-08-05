<?php
    session_start();
    ob_start();
    include_once __DIR__.'/../../../assets/common/global_private.php';
    include_once __DIR__.'/../../../assets/common/panel/vendors.php';
    include_once __DIR__.'/../../../assets/common/panel/theme.php';
    $user = get_user_id(checkInput('DEFAULT', $_GET['u']));
    if ($user == null || $user == '') {
        header('Location: '.CONFIG_INSTALL_URL.'/panel/dashboard/?error=no_user');
    }
    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>

        <title><?php echo get_user_fullname($user); ?>'s Profile - Saturn Panel</title>

    </head>
    <body class="mb-6">
        <?php include_once __DIR__.'/../../../assets/common/panel/navigation.php'; ?>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="w-full h-48" style="background: url('<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/background.jpg');">
                <div class="max-w-7xl flex mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                    <div class="h-32 w-32 py-2 px-2 md:h-48 md:w-48 md:py-4 md:px-4 relative inline-block">
                        <img class="h-28 w-28 md:h-40 md:w-40 bg-white rounded-full" src="<?php echo get_user_profilephoto($user); ?>" alt="<?php echo get_user_fullname($user); ?>">
                        <span class="absolute inline-block bg-<?php echo get_activity($user); ?>-600 rounded-full border-black bottom-4 right-4 w-4 h-4 border-2 md:border-white md:bottom-5 md:right-5 md:w-8 md:h-8 md:border-4"></span>
                    </div>
                    <div class="flex flex-wrap items-center w-3/4">
                        <div class="w-3/4 flex flex-wrap">
                            <span class="self-center text-white font-extrabold tracking-tight text-5xl md:text-6xl w-3/4"><?php echo get_user_fullname($user); ?></span>
                            <?php
                                if (get_user_roleID($user) == '4') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-red-500 text-white bg-transparent font-semibold">Administrator</span>';
                                } elseif (get_user_roleID($user) == '3') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-yellow-600 text-white bg-transparent font-semibold">Editor</span>';
                                } elseif (get_user_roleID($user) == '2') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-yellow-300 text-black bg-transparent font-semibold">Writer</span>';
                                } elseif (get_user_roleID($user) == '1') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-blue-500 text-white bg-transparent font-semibold">Pending</span>';
                                } elseif (get_user_roleID($user) == '0') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-purple-500 text-white bg-transparent font-semibold">Restricted</span>';
                                } elseif (get_user_roleID($user) == '-1') {
                                    echo'<span class="self-center h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-black text-white bg-transparent font-semibold">Deleted</span>';
                                }
                            ?>
                        </div>
                        <?php if ($user == $_SESSION['id']) {
                                echo'<a href="edit" class="cursor-pointer h-7 px-3 ml-3 outline-none border-transparent text-center rounded border bg-blue-500 hover:bg-blue-600 hover:shadow-xl text-white bg-transparent font-semibold">Edit Profile</a>';
                            } ?>
                    </div>
                </div>
            </div>
            <div class="flex pt-16 pb-10">
                <div class="ml-10">
                    <ul class="flex justify-content-around items-center">
                        <li class="mr-4">
                            <span class="block text-base flex"><span class="font-bold mr-2"><?php echo get_user_views($user); ?> </span> Views</span>
                        </li>
                        <li class="mr-4">
                            <span class="block text-base flex"><span class="font-bold mr-2"><?php echo get_user_edits($user); ?> </span> Edits</span>
                        </li>
                        <?php if (get_user_roleID($user) > 2 && get_user_roleID($_SESSION['id']) > 2) {
                                echo '<li class="mr-4">
                            <span class="block text-base flex"><span class="font-bold mr-2">'.get_user_approvals($user).' </span> Approvals</span>
                        </li>';
                            } ?>
                    </ul>
                    <br>
                    <div class="">
                        <span class="text-base"><?php echo get_user_bio($user); ?></span>
                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/linkout.php?url=<?php echo get_user_website($user); ?>" class="block text-base text-blue-500 mt-2" target="_blank" rel="nofollow noopener"><?php echo get_user_website($user); ?></a>
                    </div>
                </div>
            </div>
            <div class="border-b border-gray-300 my-6"></div>
            <h1 class="text-2xl"><?php echo get_user_page_count($user); ?> Pages</h1>
            <article class="mt-5 flex space-x-4 overflow-x-scroll">
                <?php
                $query = "SELECT `title`, `url` FROM `gh_pages` WHERE `user_id` = '".$user."'";

                $rs = mysqli_query($conn,$query);
                $resultset = array();
                while ($row = mysqli_fetch_array($rs)) {
                    $resultset[] = $row;
                }

                foreach ($resultset as $result){
                ?>
                <a href="<?php echo $result[1]; ?>" target="_blank" class="relative flex-none" style="width:300px; height:300px">
                    <iframe src="<?php echo $result[1]; ?>?access_method=saturn_iframe_preview" class="cursor-pointer relative flex-none" style="width:300px; height:300px"></iframe>
                    <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-25 px-2 py-1"><?php echo $result[0]; ?></div>
                </a>
                <?php
                }
                ?>
            </article>
            <div class="border-b border-gray-300 my-6"></div>
            <h1 class="text-2xl"><?php echo get_user_article_count($user); ?> Articles</h1>
            <article class="mt-5 grid grid-cols-3 gap-10 overflow-x-scroll">
                <?php
                $query = "SELECT `title` FROM `gh_articles` WHERE `author_id` = '".$user."'";

                $rs = mysqli_query($conn,$query);
                $resultset = array();
                while ($row = mysqli_fetch_array($rs)) {
                    $resultset[] = $row;
                }

                foreach ($resultset as $result){
                    ?>
                    <a href="/" target="_blank" class="relative flex-none" style="width:300px; height:300px">
                        <div class="cursor-pointer relative flex-none">
                            <img src="<?php echo CONFIG_INSTALL_URL; ?>/assets/images/no-image-500x500.png"
                                 class="w-full h-full object-cover"
                                 alt="<?php echo $result[0]; ?>" />
                        </div>
                        <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-25 px-2 py-1"><?php echo $result[0]; ?></div>
                    </a>
                    <?php
                }
                ?>
            </article>
        </div>
    </body>
</html>