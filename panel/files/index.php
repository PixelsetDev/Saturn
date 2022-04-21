<?php
session_start();
include_once __DIR__.'/../../common/global_private.php';

function is_restricted($file): bool
{
    if (strpos($file[2], 'error.svg') === false && strpos($file[2], 'icon.png') === false && strpos($file[2], 'logo.png') === false && strpos($file[2], 'no-image-500x500.png') === false && strpos($file[2], 'icon.svg') === false && strpos($file[2], 'defaultprofile.png') === false) {
        return false;
    } else {
        return true;
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
            <?php if ($_SESSION['role_id'] == '4') {
            echo alert('INFO', '<p>'.__('Panel:Files_ThemeSettings_1').' <a href="'.CONFIG_INSTALL_URL.'/panel/admin/themes" class="underline text-black dark:text-white">'.__('Panel:Files_ThemeSettings_2').'</a>.</p>'); ?><br><?php
        } ?>
            <div class="w-full px-4 py-6 sm:px-0 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Images'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
<?php
    $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/images/*';
    foreach (glob($directory.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,svg,SVG}', GLOB_BRACE) as $file) {
        $file = explode('/..', $file);
        $fileName = basename($file);
        if (is_restricted($file) == false) {
            ?>
                        <a href="<?php echo $file[2]; ?>">
                            <img src="<?php echo $file[2]; ?>" class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-600 p-2" alt="<?php echo $fileName; ?>">
                        </a>
<?php
        }
    } ?>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Videos'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
<?php
    $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/videos/*';
    foreach (glob($directory.'*.{mp4,MP4,mov,MOV}', GLOB_BRACE) as $file) {
        $file = explode('/..', $file);
        $fileName = basename($file);
        if (is_restricted($file) == false) {
            ?>
                        <a href="<?php echo $file[2]; ?>" class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-600 p-2">
                            <video width="320" height="240" controls>
                                <source src="<?php echo $file[2]; ?>" type="video/mp4">
                                Your browser does not support videos.
                            </video>
                        </a>
<?php
        }
    } ?>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Other'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/uploads/*';
                        foreach (glob($directory.'*.{txt,TXT,pdf,PDF,doc,DOC,docx,DOCX,ppt,PPT,pptx,PPTX}', GLOB_BRACE) as $file) {
                            $file = explode('/..', $file);
                            $fileName = basename($file);
                            if (is_restricted($file) == false) {
                                ?>
                                <a href="<?php echo $file[2]; ?>" class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-600 p-2"><?php echo $fileName; ?></a>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold leading-tight text-gray-900 dark:text-white"><?php echo __('Panel:Files_Recovery'); ?></h1>
                    <div class="grid md:grid-cols-2 grid-cols-1 gap-2">
                        <?php
                        $directory = __DIR__.'/../..'.SATURN_STORAGE_DIRECTORY.'/recovery/*';
                        foreach (glob($directory.'*.{srp}', GLOB_BRACE) as $file) {
                            $file = explode('/..', $file);
                            $fileName = basename($file);
                            if (is_restricted($file) == false) {
                                ?>
                                <a href="<?php echo $file[2]; ?>" class="shadow-lg hover:shadow-xl rounded transition duration-200 bg-gray-100 dark:bg-neutral-600 p-2"><?php echo $fileName; ?></a>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>