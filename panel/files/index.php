<?php
session_start();
include_once __DIR__.'/../../common/global_private.php';

function is_restricted($file): bool
{
    if (strpos($file[1], 'error.svg') === false && strpos($file[1], 'icon.png') === false && strpos($file[1], 'logo.png') === false && strpos($file[1], 'no-image-500x500.png') === false && strpos($file[1], 'icon.svg') === false && strpos($file[1], 'defaultprofile.png') === false) {
        return false;
    } else {
        return true;
    }
}

if (isset($_POST['delete']) && $_POST['delete'] != NULL) {
    if (preg_match("/'([^']+)'/", $_POST['delete'], $m)) {
        if (strpos($m[1], 'uploads') !== false || strpos($m[1], 'images') !== false || strpos($m[1], 'videos') !== false){
            if (file_exists(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.checkInput('DEFAULT', $m[1]))) {
                if (unlink(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.checkInput('DEFAULT', $m[1]))) {
                    $successMsg = checkInput('DEFAULT', $m[1]). 'was deleted.';
                } else {
                    $errorMsg = 'Saturn encountered an error whilst trying to delete the file. Please try again later.';
                }
            } else {
                $errorMsg = 'Saturn was unable to locate the file you requested to be deleted. It might have already been deleted.';
            }
        } else {
            $errorMsg = 'You can\'t delete files from this location.';
        }
    } else {
        $errorMsg = 'Saturn was unable to locate the file you requested to be deleted.';
    }
}

?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../common/panel/vendors.php';
            include_once __DIR__.'/../../common/panel/theme.php';
        ?>

        <title><?php echo __('Panel:Files'); ?> - <?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?></title>
    </head>
    <body class="mb-8 dark:bg-neutral-700 dark:text-white">
        <?php include_once __DIR__.'/../../common/panel/navigation.php'; ?>

        <header class="bg-white shadow dark:bg-neutral-800">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files'); ?></h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">

            <?php
            if (isset($errorMsg)) {
                echo alert('ERROR', $errorMsg);
                log_error('ERROR', $errorMsg);
            }
            unset($errorMsg);
            if (isset($successMsg)) {
                echo alert('SUCCESS', $successMsg);
            }
            unset($successMsg);
            ?>
            <?php if ($_SESSION['role_id'] == '4') {
            echo alert('INFO', '<p>'.__('Panel:Files_ThemeSettings_1').' <a href="'.CONFIG_INSTALL_URL.'/panel/admin/themes" class="underline text-black dark:text-white">'.__('Panel:Files_ThemeSettings_2').'</a>.</p>'); ?><br><?php
        } ?>
            <div class="w-full px-4 py-6 sm:px-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Images'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/';
                        foreach (glob($directory.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,svg,SVG,webp,WEBP}', GLOB_BRACE) as $file) {
                            $file = explode('/uploads/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <img src="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>" class="p-2 w-full" alt="<?php echo $file[1]; ?>">
                                    <p class="p-2 w-full text-xs self-center text-center"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>"><i class="self-center fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <form x-data="{open:false}" method="post" action="" class="mb-0">
                                            <a @click="open = true" class="cursor-pointer"><i class="self-center fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                            <?php echo display_modal('red', 'Delete File', 'Are you sure you want to delete '.$file[1].'?<br> This action cannot be undone.', '<div class="bg-gray-50 dark:bg-neutral-600 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                    <input type="submit" id="delete" name="delete" value="Delete \'/uploads/'.$file[1].'\'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-900 dark:text-white bg-red-200 dark:bg-red-700 dark:hover:bg-red-600 hover:bg-red-300 md:py-1 md:text-rg md:px-10">
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a @click="open=false" class="dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                </div>'); ?>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/images/';
                        foreach (glob($directory.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,svg,SVG,webp,WEBP}', GLOB_BRACE) as $file) {
                            $file = explode('/images/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <img src="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/images/'.$file[1]; ?>" class="p-2 w-full" alt="<?php echo $file[1]; ?>">
                                    <p class="p-2 w-full text-xs self-center text-center"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/images/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/images/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/images/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/images/';
                        foreach (glob($directory.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,svg,SVG,webp,WEBP}', GLOB_BRACE) as $file) {
                            $file = explode('/uploads/images/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <img src="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/images/'.$file[1]; ?>" class="p-2 w-full" alt="<?php echo $file[1]; ?>">
                                    <p class="p-2 w-full text-xs self-center text-center"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/images/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/images/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/images/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                    <a href="upload/?type=image" class="mt-6 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Upload new Image</a>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Videos'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/';
                        foreach (glob($directory.'*.{mp4,MP4,mov,MOV}', GLOB_BRACE) as $file) {
                            $file = explode('/uploads/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <p class="p-2 w-full"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/videos/';
                        foreach (glob($directory.'*.{mp4,MP4,mov,MOV}', GLOB_BRACE) as $file) {
                            $file = explode('/uploads/videos/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <p class="p-2 w-full"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/videos/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/videos/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/videos/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                    <a href="upload/?type=video" class="mt-6 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Upload new Video</a>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Other'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/*';
                        foreach (glob($directory.'*.{txt,TXT,pdf,PDF,doc,DOC,docx,DOCX,ppt,PPT,pptx,PPTX}', GLOB_BRACE) as $file) {
                            $file = explode('/uploads/', $file);
                            if (!is_restricted($file)) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <p class="p-2 w-full"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                    <a href="upload" class="mt-6 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:text-white flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Upload new File</a>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Recovery'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/recovery/*';
                        foreach (glob($directory.'*.{srp}', GLOB_BRACE) as $file) {
                            $file = explode('/recovery/', $file);
                            if (!is_restricted($file[1])) {
                                ?>
                                <div class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-900 w-full">
                                    <p class="p-2 w-full"><?php echo $file[1]; ?></p>
                                    <div class="flex">
                                        <a href="<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/recovery/'.$file[1]; ?>"><i class="fa-solid fa-eye py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                        <p class="flex-grow text-center text-xs self-center"><?php echo round((filesize(__DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/recovery/'.$file[1]) / 1048576),'2'); ?> MB</p>
                                        <a href="?delete=<?php echo '/../..'.SATURN_STORAGE_DIRECTORY.'/recovery/'.$file[1]; ?>"><i class="fa-solid fa-trash-can py-2 px-2 text-black hover:text-neutral-800 dark:text-white dark:hover:text-neutral-200 transition duration-200" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>