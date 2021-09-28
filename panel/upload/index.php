<?php
    session_start();
    ob_start();

    include_once __DIR__.'/../../assets/common/global_private.php';

    if (!empty($_FILES['uploaded_file'])) {
        if (isset($_GET['uploadTo'])) {
            $uploadDirectory = __DIR__.'/../../'.checkInput('DEFAULT', $_GET['uploadTo']);
        } else {
            if (isset($_GET['type'])) {
                if ($_GET['type'] == 'image') {
                    $uploadDirectory = __DIR__.'/../../assets/images/uploads/';
                } elseif ($_GET['type'] == 'video') {
                    $uploadDirectory = __DIR__.'/../../assets/videos/uploads/';
                } else {
                    $uploadDirectory = __DIR__.'/../../assets/storage/uploads/';
                }
            } else {
                $uploadDirectory = __DIR__.'/../../assets/storage/uploads/';
            }
        }

        // Check if directory exists and create it if it does not.
        if (!file_exists($uploadDirectory)) {
            if (!mkdir($uploadDirectory, 0744)) {
                echo alert('WARNING', 'The directory does not exist and could not be created. Please check that Saturn has the required permissions to do this. <a href="https://docs.saturncms.net/BETA-1.0.0/warnings/#directory-not-exist-creation-failed" class="underline text-xs text-black" target="_blank" rel="noopener">Get help.</a>', true);
            }
        }

        // Check if directory can be written to.
        if (!is_writable($uploadDirectory)) {
            echo alert('WARNING', 'You don\'t have the required permissions to write in this directory. <a href="https://docs.saturncms.net/BETA-1.0.0/warnings/#no-directory-write-permissions" class="underline text-xs text-black" target="_blank" rel="noopener">Get help.</a>', true);
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
                echo alert('SUCCESS', 'The file '.basename($_FILES['uploaded_file']['name']).' has been uploaded', true);
                $uploaded = true;
                $uploadedTo = basename($_FILES['uploaded_file']['name']);
            } else {
                echo alert('ERROR', 'There was an error uploading the file, please try again later or check warnings for more information.', true);
                $uploaded = false;
            }

            if (isset($_GET['renameTo'])) {
                if (!rename($uploadDirectory, str_replace(basename($_FILES['uploaded_file']['name']), '', $uploadDirectory).checkInput('DEFAULT', $_GET['renameTo']))) {
                    echo alert('WARNING', 'Unable to rename file.', true);
                    $uploaded = false;
                    echo $uploadDirectory.' - '.str_replace(basename($_FILES['uploaded_file']['name']), '', $uploadDirectory).checkInput('DEFAULT', $_GET['renameTo']);
                } else {
                    $uploadedTo = checkInput('DEFAULT', $_GET['renameTo']);
                }
            }
        } else {
            $uploaded = false;
        }

        if ($uploaded) {
            if (isset($_GET['redirectTo'])) {
                header('Location: '.checkInput('DEFAULT', $_GET['redirectTo']).'/?uploadedTo='.checkInput('DEFAULT', $uploadedTo));
            }
        } else {
            echo alert('ERROR', 'File not uploaded.', true);
        }
    }

    ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            include_once __DIR__.'/../../assets/common/panel/vendors.php';
            include_once __DIR__.'/../../assets/common/panel/theme.php';
        ?>

        <title>Saturn Panel</title>
    </head>
    <body class="mb-8">
        <?php if (!isset($_GET['embed'])) {
            include_once __DIR__.'/../../assets/common/panel/navigation.php';
        } ?>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-gray-900">File Upload</h1>
            </div>
        </header>

        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <form enctype="multipart/form-data" action="" method="POST" class="flex space-x-4">
                <input type="file" name="uploaded_file" class="flex-grow border rounded-md border-<?php echo THEME_PANEL_COLOUR; ?>-200 hover:border-<?php echo THEME_PANEL_COLOUR; ?>-300 text-<?php echo THEME_PANEL_COLOUR; ?>-700 py-1 px-8 transition duration-200">
                <input type="submit" value="Upload" class="rounded-md bg-<?php echo THEME_PANEL_COLOUR; ?>-200 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-300 text-<?php echo THEME_PANEL_COLOUR; ?>-700 py-2 px-8 transition duration-200">
            </form>
            <?php
                if ($_GET['type'] == 'image' && isset($_GET['maxWidth']) && isset($_GET['maxHeight'])) {
                    ?>
            <h1 class="text-2xl text-<?php echo THEME_PANEL_COLOUR; ?>-700">Image Restrictions</h1>
            <p class="text-<?php echo THEME_PANEL_COLOUR; ?>-700">This file must be a valid image. It must be no bigger than <?php echo checkOutput('DEFAULT', $_GET['maxWidth']); ?> x <?php echo checkOutput('DEFAULT', $_GET['maxHeight']); ?> (width x height).</p>
            <?php
                }
                $output = json_decode(file_get_contents(__DIR__.'/../../assets/storage/terms.json'));
                if ($output->data->fileuploadinfo != null || $output->data->fileuploadinfo != '') {
                    ?>
            <h1 class="text-2xl text-<?php echo THEME_PANEL_COLOUR; ?>-700">File Upload Information</h1>
            <p class="text-<?php echo THEME_PANEL_COLOUR; ?>-700"><?php echo $output->data->fileuploadinfo; ?></p>
            <?php
                } ?>
        </div>
    </body>
</html>