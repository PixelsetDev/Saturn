<?php
    session_start();
    ob_start();
    require_once __DIR__ . '/../../../assets/common/global_private.php';
    require_once __DIR__ . '/../../../assets/common/processes/gui/modals.php';

    if(isset($_POST['reset-ccv'])) {
        if(checksum_generate_config()) {
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?successResetCCV=Core Checksum Validation was reset successfully. If the warning is still present, refresh your page.');
            exit;
        } else {
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?errorMsg=Unable to reset Core Checksum Validation, an error occurred.');
            exit;
        }
    }

    if(isset($_GET['successMsg'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successMsg']);
    } else if (isset($_GET['successResetCCV'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successResetCCV']);
        log_file('SATURN][SECURITY', 'WARNING: '.get_user_fullname($_SESSION['id']).' reset the Core Checksum Validation values.');
    } else if (isset($_GET['errorMsg'])) {
        $errorMsg = checkInput('DEFAULT', $_GET['errorMsg']);
    }

ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../../assets/common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__ . '/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__ . '/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Security Management</h1>
            <?php
            if(isset($errorMsg)){
                alert('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if(isset($successMsg)){
                alert('SUCCESS', $successMsg);
                unset($successMsg);
            }
            ?>
            <br>
            <h2 class="text-gray-900 text-2xl mt-8">Core Checksum Validation</h2>
            <?php
            $issue=0;
            if(!checksum_validate_config()) {
            echo '<br><div class="duration-300 transform bg-yellow-100 border-l-4 border-yellow-500 hover:-translate-y-2">
                <div class="p-5 border border-l-0 rounded-r shadow-sm">
                    <h6 class="mb-2 font-semibold leading-5">[WARNING] Website configuration does not match checksum. <a href="https://docs.saturncms.net/website-configuration-checksum" class="underline text-xs text-black" target="_blank">Get help.</a></h6>
                </div>
            </div><br>';
            $issue = $issue+1;
            }
            echo $issue.' issues found.';
            ?>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow cursor-pointer flex w-1/3 text-base font-medium text-red-700">Reset Core Checksum Validation</a>
                <?php echo display_modal('red', 'Reset Core Checksum Validation', 'Are you sure you want to reset core checksum validation?<br>This action cannot be undone.<br><br>This action will be recorded in the Security Log.', '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="reset-ccv" name="reset-ccv" value="Reset Core Checksum Validation" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                    </div>
                                </form>'); ?>
            </div>
        </div>
    </body>
</html>