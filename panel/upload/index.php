<?php
    session_start();
    ob_start();

    include_once __DIR__.'/../../common/global_private.php';

    if (!empty($_FILES['uploaded_file'])) {

        /* File Uploads Location Config */
        /* Changing this won't affect already existing uploads. */
        $defaultUploadLocation = '/../../storage/uploads/';
        $imageUploadLocation = '/../../storage/images/uploads/';
        $profilepictureUploadLocation = '/../../storage/images/profile-pictures/';
        $videoUploadLocation = '/../../storage/videos/uploads/';

        if (isset($_GET['uploadTo'])) {
            $uploadDirectory = __DIR__.'/../..'.checkInput('DEFAULT', $_GET['uploadTo']);
            $uploadedToDirectory = '/../..'.checkInput('DEFAULT', $_GET['uploadTo']);
        } else {
            if (isset($_GET['type'])) {
                if ($_GET['type'] == 'image') {
                    $uploadDirectory = __DIR__.$imageUploadLocation;
                    $uploadedToDirectory = $imageUploadLocation;
                } elseif ($_GET['type'] == 'profilepicture') {
                    $uploadDirectory = __DIR__.$profilepictureUploadLocation;
                    $uploadedToDirectory = $profilepictureUploadLocation;
                } elseif ($_GET['type'] == 'video') {
                    $uploadDirectory = __DIR__.$videoUploadLocation;
                    $uploadedToDirectory = $videoUploadLocation;
                } else {
                    $uploadDirectory = __DIR__.$defaultUploadLocation;
                    $uploadedToDirectory = $defaultUploadLocation;
                }
            } else {
                $uploadDirectory = __DIR__.$defaultUploadLocation;
                $uploadedToDirectory = $defaultUploadLocation;
            }
        }

        // Check if directory exists and create it if it does not.
        if (!file_exists($uploadDirectory) && !mkdir($uploadDirectory, 0755)) {
            echo alert('WARNING', 'The directory does not exist and could not be created. Please check that Saturn has the required permissions to do this. <a href="https://docs.saturncms.net/v/'.SATURN_VERSION.'/user-documentation/errors-and-warnings#directory-not-exist-creation-failed" class="underline text-xs text-black" target="_blank" rel="noopener">Get help.</a>', true);
            log_error('WARNING', 'The directory does not exist and could not be created.');
        }

        // Check if directory can be written to.
        if (!is_writable($uploadDirectory)) {
            echo alert('WARNING', 'You don\'t have the required permissions to write in this directory. <a href="https://docs.saturncms.net/v/'.SATURN_VERSION.'/user-documentation/errors-and-warnings#no-directory-write-permissions" class="underline text-xs text-black" target="_blank" rel="noopener">Get help.</a>', true);
            log_error('WARNING', 'You don\'t have the required permissions to write in this directory.');
        }
        $uploadDirectory = $uploadDirectory.basename($_FILES['uploaded_file']['name']);

        $allowUpload = true;

        // Check if file can be uploaded.
        if ($_GET['type'] == 'image' && isset($_GET['maxWidth']) && isset($_GET['maxHeight'])) {
            list($width, $height, $type, $attr) = getimagesize($_FILES['uploaded_file']['tmp_name']);
            if ($width <= $_GET['maxWidth']) {
                if ($height <= $_GET['maxHeight']) {
                    $allowUpload = true;
                } else {
                    echo alert('WARNING', 'This image is larger than the maximum height allowed. Your image height: '.$height.'; Maximum allowed: '.checkInput('DEFAULT', $_GET['maxHeight']), true);
                    $allowUpload = false;
                }
            } else {
                echo alert('WARNING', 'This image is larger than the maximum width allowed. Your image width: '.$width.'; Maximum allowed: '.checkInput('DEFAULT', $_GET['maxWidth']), true);
                $allowUpload = false;
            }
        }

        // Upload file.
        if ($allowUpload) {
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $uploadDirectory)) {
                $uploaded = true;
                $uploadedTo = basename($_FILES['uploaded_file']['name']);
            } else {
                echo alert('ERROR', 'There was an error uploading the file, please try again later or check warnings for more information.', true);
                log_error('ERROR', 'There was an error uploading the file, please try again later or check warnings for more information.');
                $uploaded = false;
            }

            if (isset($_GET['renameTo'])) {
                if (!rename($uploadDirectory, str_replace($_FILES['uploaded_file']['name'], '', $uploadDirectory).checkInput('DEFAULT', $_GET['renameTo']))) {
                    echo alert('WARNING', 'Unable to rename file.', true);
                    log_error('WARNING', 'Unable to rename file.');
                    $uploaded = false;
                } else {
                    $uploadedTo = checkInput('DEFAULT', $_GET['renameTo']);
                }
            } else {
                $path = $_FILES['uploaded_file']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $rand = rand(000000000000, 999999999999);
                if (!rename($uploadDirectory, str_replace($_FILES['uploaded_file']['name'], '', $uploadDirectory).$rand.'.'.$ext)) {
                    echo alert('WARNING', 'Unable to rename file.', true);
                    log_error('WARNING', 'Unable to rename file.');
                    $uploaded = false;
                } else {
                    $uploadedTo = checkInput('DEFAULT', $_GET['renameTo']);
                }
            }
        } else {
            $uploaded = false;
        }

        if ($uploaded) {
            if (isset($_GET['redirectTo'])) {
                if (isset($_GET['renameTo'])) {
                    header('Location: '.checkInput('DEFAULT', $_GET['redirectTo']).'/?uploadedTo='.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).checkInput('DEFAULT', $_GET['renameTo'])));
                } else {
                    header('Location: '.checkInput('DEFAULT', $_GET['redirectTo']).'/?uploadedTo='.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).$rand.'.'.$ext));
                }
            } else {
                if (isset($_GET['renameTo'])) {
                    echo alert('SUCCESS', 'The file '.checkInput('DEFAULT', basename($_FILES['uploaded_file']['name'])).' has been uploaded to: <a class="underline" target="_blank" href="'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).checkInput('DEFAULT', $_GET['renameTo'])).'">'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).checkInput('DEFAULT', $_GET['renameTo'])).' <i class="fas fa-external-link-alt" aria-hidden="true"></i></a>', true);
                } else {
                    echo alert('SUCCESS', 'The file '.checkInput('DEFAULT', basename($_FILES['uploaded_file']['name'])).' has been uploaded to: <a class="underline" target="_blank" href="'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).$rand.'.'.$ext).'">'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).$rand.'.'.$ext).' <i class="fas fa-external-link-alt" aria-hidden="true"></i></a>', true);
                }
            }
        } else {
            echo alert('ERROR', 'File not uploaded.', true);
            log_error('ERROR', 'File not uploaded.');
        }
    }

    ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../common/panel/vendors.php';
            include_once __DIR__.'/../../common/panel/theme.php';
        ?>

        <title>File Upload - Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php if (!isset($_GET['embed'])) {
            include_once __DIR__.'/../../common/panel/navigation.php';
        } ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">File Upload</h1>
            </div>
        </header>

        <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <form enctype="multipart/form-data" action="" method="POST" class="md:flex md:space-x-4">
                <input type="file" name="uploaded_file" class="flex-grow border rounded-md border-<?php echo THEME_PANEL_COLOUR; ?>-200 hover:border-<?php echo THEME_PANEL_COLOUR; ?>-300 text-<?php echo THEME_PANEL_COLOUR; ?>-700 py-1 px-8 transition duration-200">
                <br class="md:hidden block"><br class="md:hidden block">
                <input type="submit" value="Upload" class="rounded-md bg-<?php echo THEME_PANEL_COLOUR; ?>-200 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-300 text-<?php echo THEME_PANEL_COLOUR; ?>-700 py-2 px-8 transition duration-200">
            </form>
            <?php
            if ($uploaded) {
                echo '<h1 class="text-2xl text-<?php echo THEME_PANEL_COLOUR; ?>-700">Your file:</h1>';
                if (isset($_GET['renameTo'])) {
                    echo '<iframe class="w-full h-1/2" src="'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).checkInput('DEFAULT', $_GET['renameTo'])).'">'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).checkInput('DEFAULT', $_GET['renameTo'])).'</iframe>';
                } else {
                    echo '<iframe class="w-full h-1/2" src="'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).$rand.'.'.$ext).'">'.str_replace('/..', '', checkInput('DEFAULT', $uploadedToDirectory).$rand.'.'.$ext).'</iframe>';
                }
            }
            ?>
            <?php
                if ($_GET['type'] == 'image' && isset($_GET['maxWidth']) && isset($_GET['maxHeight'])) {
                    ?>
            <h1 class="text-2xl text-<?php echo THEME_PANEL_COLOUR; ?>-700">Image Restrictions</h1>
            <p class="text-<?php echo THEME_PANEL_COLOUR; ?>-700">This file must be a valid image. It must be no bigger than <?php echo checkOutput('DEFAULT', $_GET['maxWidth']); ?> x <?php echo checkOutput('DEFAULT', $_GET['maxHeight']); ?> (width x height).</p>
            <?php
                }
                $output = json_decode(file_get_contents(__DIR__.'/../../storage/terms.json'));
                if ($output->data->fileuploadinfo != null || $output->data->fileuploadinfo != '') {
                    ?>
            <h1 class="text-2xl text-<?php echo THEME_PANEL_COLOUR; ?>-700">File Upload Information</h1>
            <p class="text-<?php echo THEME_PANEL_COLOUR; ?>-700"><?php echo $output->data->fileuploadinfo; ?></p>
            <?php
                } ?>
        </div>
    </body>
</html>