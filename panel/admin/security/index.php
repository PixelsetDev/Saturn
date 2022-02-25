<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';

    require_once __DIR__.'/../../../common/processes/gui/modals.php';

    if (isset($_POST['reset-ccv'])) {
        if (ccv_reset()) {
            log_file('SATURN][SECURITY', __('General:Warning').': '.get_user_fullname($_SESSION['id']).' '.__('Admin:ResetCCV_Message'));
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?successResetCCV='.__('Admin:ResetCCV_Success'));
        } else {
            header('Location: '.htmlspecialchars($_SERVER['PHP_SELF']).'/?errorMsg='.__('Error:ResetCCV'));
        }
        exit;
    }

    if (isset($_GET['successMsg'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successMsg']);
    } elseif (isset($_GET['successResetCCV'])) {
        $successMsg = checkInput('DEFAULT', $_GET['successResetCCV']);
    } elseif (isset($_GET['errorMsg'])) {
        $errorMsg = checkInput('DEFAULT', $_GET['errorMsg']);
    }

ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title>Security - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:SecurityManagement'); ?></h1>
            <?php
            if (isset($errorMsg)) {
                echo alert('ERROR', $errorMsg);
                log_error('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if (isset($successMsg)) {
                echo alert('SUCCESS', $successMsg);
                unset($successMsg);
            }
            ?>
            <br>
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:CCV'); ?></h2>
            <?php
            $issue = 0;
            if (!ccv_validate('CONFIG') && !isset($_GET['successResetCCV'])) {
                echo alert('WARNING', __('Error:CCV').' <a href="https://docs.saturncms.net/v/'.SATURN_VERSION.'/user-documentation/errors-and-warnings#website-configuration-checksum" class="underline text-xs text-black" target="_blank" rel="noopener">'.__('Error:GetHelp').'</a>', true);
                $issue = $issue + 1;
            }
            echo $issue.' issues found.';
            ?>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow cursor-pointer flex w-1/3 text-base font-medium text-red-700"><?php echo __('Admin:ResetCCV'); ?></a>
                <?php echo display_modal('ERROR', __('Admin:ResetCCV'), __('Admin:ResetCCV_Confirm').'<br>'.__('General:CannotBeUndone').'<br><br>'.__('Admin:RecordInSecurityLog'), '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="reset-ccv" name="reset-ccv" value="'.__('Admin:ResetCCV').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                    </div>
                                </form>'); ?>
            </div>
        </div>
    </body>
</html>