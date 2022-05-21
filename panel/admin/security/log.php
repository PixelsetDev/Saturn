<?php
    session_start();

    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';
    ob_end_flush();

    if (isset($_POST['clearSecurity'])) {
        if (log_clear('SECURITY')) {
            $successMsg = __('Admin:Logs_Security_Cleared');
        } else {
            $errorMsg = __('Error:Logs_Clear');
        }
    }

    if (isset($_POST['clearErrors'])) {
        if (log_clear('ERROR')) {
            $successMsg = __('Admin:Logs_Error_Cleared');
        } else {
            $errorMsg = __('Error:Logs_Clear');
        }
    }
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:Logs'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <div class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:Logs_Security'); ?></h1>
            <?php
                if (isset($errorMsg)) {
                    alert('ERROR', $errorMsg);
                    log_error('ERROR', $errorMsg);
                    unset($errorMsg);
                }
                if (isset($successMsg)) {
                    alert('SUCCESS', $successMsg);
                    unset($successMsg);
                }
            ?>
            <br>
            <iframe src="<?php echo CONFIG_INSTALL_URL; ?>/storage/logs/security.txt?cache=<?php try {
                echo random_int('0000', '9999');
            } catch (Exception $e) {
                echo alert('ERROR', $e);
                log_error('ERROR', $e);
            } ?>" class="w-full h-1/4 overflow-scroll" title="<?php echo __('Admin:Logs_Security'); ?>"></iframe>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer flex w-1/6 items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10"><?php echo __('Admin:Logs_Clear'); ?></a>
                <?php echo display_modal('red', __('Admin:Logs_Clear'), __('Admin:Logs_Clear_Confirm').'<br>'.__('General:CannotBeUndone').'<br><br>'.__('Admin:Logs_Clear_Confirm_2'), '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="clearSecurity" name="clearSecurity" value="'.__('Admin:Logs_Clear').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                    </div>
                                </form>'); ?>
            </div>

            <h1 class="text-gray-900 text-3xl mt-10"><?php echo __('Admin:Logs_Error'); ?></h1>
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
            <iframe src="<?php echo CONFIG_INSTALL_URL; ?>/storage/logs/errors.txt?cache=<?php try {
                echo random_int('0000', '9999');
            } catch (Exception $e) {
                echo alert('ERROR', $e);
                log_error('ERROR', $e);
            } ?>" class="w-full h-1/4 overflow-scroll" title="<?php echo __('Admin:Logs_Error'); ?>"></iframe>
            <div x-data="{open:false}">
                <a @click="open = true" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer flex w-1/6 items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10"><?php echo __('Admin:Logs_Clear'); ?></a>
                <?php echo display_modal('red', __('Admin:Logs_Clear'), __('Admin:Logs_Clear_Confirm').'<br>'.__('General:CannotBeUndone').'<br><br>'.__('Admin:Logs_Clear_Confirm_2'), '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="post"><div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse flex">
                                        <input type="submit" id="clearErrors" name="clearErrors" value="'.__('Admin:Logs_Clear').'" class="transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 md:py-1 md:text-rg md:px-10">
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <a @click="open=false" class="flex-grow transition-all duration-200 hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200 md:py-1 md:text-rg md:px-10">'.__('General:Cancel').'</a>
                                    </div>
                                </form>'); ?>
            </div>
        </div>
    </body>
</html>