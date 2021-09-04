<?php
    session_start();
    require_once __DIR__.'/../../../assets/common/global_private.php';
    require_once __DIR__.'/../../../assets/common/processes/gui/modals.php';

    if (isset($_POST['clearSecurity'])) {
        if (log_clear('SECURITY')) {
            $successMsg = 'Log cleared.';
        } else {
            $errorMsg = 'Unable to clear the log, an error occurred.';
        }
    }

    if (isset($_POST['clearErrors'])) {
        if (log_clear('ERROR')) {
            $successMsg = 'Log cleared.';
        } else {
            $errorMsg = 'Unable to clear the log, an error occurred.';
        }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../assets/common/panel/vendors.php'; ?>

        <title>Security Log - <?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../assets/common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl">Security Log</h1>
            <?php
                if (isset($errorMsg)) {
                    alert('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if (isset($successMsg)) {
                    alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
            ?>
            <br>
            <iframe src="<?php echo CONFIG_INSTALL_URL; ?>/assets/storage/logs/security.txt?cache=<?php try {
                echo random_int('0000', '9999');
            } catch (Exception $e) {
                echo alert('ERROR', $e);
            } ?>" class="w-full h-1/4 overflow-scroll" title="Security Log"></iframe>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer flex w-1/6 items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">Clear Log</a>
                <?php echo display_modal('red', 'Clear Log', 'Are you sure you want to clear the Security Log?<br>This action cannot be undone.<br><br>If you clear the log you loose all existing logged data. Your username will be recorded as the person who cleared this log at the top of the new log.', '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="clearSecurity" name="clearSecurity" value="Clear Log" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                    </div>
                                </form>'); ?>
            </div>

            <h1 class="text-gray-900 text-3xl mt-10">Error Log</h1>
            <?php
            if (isset($errorMsg)) {
                alert('ERROR', $errorMsg);
                unset($errorMsg);
            }
            if (isset($successMsg)) {
                alert('SUCCESS', $successMsg);
                unset($successMsg);
            }
            ?>
            <br>
            <iframe src="<?php echo CONFIG_INSTALL_URL; ?>/assets/storage/logs/errors.txt?cache=<?php try {
                echo random_int('0000', '9999');
            } catch (Exception $e) {
                echo alert('ERROR', $e);
            } ?>" class="w-full h-1/4 overflow-scroll" title="Error Log"></iframe>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer flex w-1/6 items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">Clear Log</a>
                <?php echo display_modal('red', 'Clear Log', 'Are you sure you want to clear the Error Log?<br>This action cannot be undone.<br><br>If you clear the log you loose all existing logged data. Your username will be recorded as the person who cleared this log at the top of the new log.', '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="clearErrors" name="clearErrors" value="Clear Log" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">Cancel</a>
                                    </div>
                                </form>'); ?>
            </div>
        </div>
    </body>
</html>