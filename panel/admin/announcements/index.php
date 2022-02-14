<?php
    session_start();
    ob_start();
    require_once __DIR__.'/../../../common/global_private.php';
    require_once __DIR__.'/../../../common/admin/global.php';

    if (isset($_POST['save'])) {
        if (update_announcement_active('1', checkInput('DEFAULT', $_POST['panel_active'])) &&
        update_announcement_active('2', checkInput('DEFAULT', $_POST['website_active'])) &&
        update_announcement_type('1', checkInput('DEFAULT', $_POST['panel_type'])) &&
        update_announcement_type('2', checkInput('DEFAULT', $_POST['website_type'])) &&
        update_announcement_title('1', checkInput('DEFAULT', $_POST['panel_title'])) &&
        update_announcement_title('2', checkInput('DEFAULT', $_POST['website_title'])) &&
        update_announcement_message('1', checkInput('DEFAULT', $_POST['panel_message'])) &&
        update_announcement_message('2', checkInput('DEFAULT', $_POST['website_message'])) &&
        update_announcement_link('1', checkInput('DEFAULT', $_POST['panel_link'])) &&
        update_announcement_link('2', checkInput('DEFAULT', $_POST['website_link']))) {
            $successMsg = __('Admin:Announcements_Updated');
        } else {
            $errorMsg = __('Error:Unknown');
        }
        header('Location: index.php');
    }

    ob_end_flush();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__.'/../../../common/panel/vendors.php'; ?>

        <title><?php echo __('Admin:Announcements'); ?> - <?php echo CONFIG_SITE_NAME.' '.__('Admin:Panel'); ?></title>
        <?php require __DIR__.'/../../../common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../common/admin/navigation.php'; ?>

        <form action="index.php" method="post" class="px-8 py-4 w-full">
            <h1 class="text-gray-900 text-3xl"><?php echo __('Admin:Announcements'); ?></h1>
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
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:Announcements_ControlPanel'); ?></h2>
            <div class="my-6">
                <?php
                    if (get_announcement_panel_active()) {
                        if (get_announcement_panel_link() != null && get_announcement_panel_link() != '') {
                            echo alert(get_announcement_panel_type(), '<span class="underline">'.get_announcement_panel_title().':</span> '.get_announcement_panel_message().' - For more information <a href="'.get_announcement_panel_link().'" class="underline">please click here</a>.', true);
                        } else {
                            echo alert(get_announcement_panel_type(), '<span class="underline">'.get_announcement_panel_title().':</span> '.get_announcement_panel_message(), true);
                        }
                    }
                ?>
            </div>
            <div class="mb-6">
                <div class="grid grid-cols-2">
                    <label for="panel_active"><?php echo __('General:Active'); ?></label>
                    <select id="panel_active" name="panel_active" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="1"<?php if (get_announcement_panel_active()) {
                    echo ' selected';
                } ?>><?php echo __('General:Active'); ?> (<?php echo __('Admin:Announcements_Show'); ?>)</option>
                        <option value="0"<?php if (!get_announcement_panel_active()) {
                    echo ' selected';
                } ?>><?php echo __('General:Inactive'); ?> (<?php echo __('Admin:Announcements_Hide'); ?>)</option>
                    </select>
                </div>
                <br>
                <div class="grid grid-cols-2">
                    <label for="panel_title"><?php echo __('General:Title'); ?></label>
                    <input id="panel_title" name="panel_title" type="text" maxlength="50" value="<?php echo get_announcement_panel_title(); ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <div class="grid grid-cols-2">
                    <label for="panel_message"><?php echo __('General:Message'); ?></label>
                    <input id="panel_message" name="panel_message" type="text" maxlength="255" value="<?php echo get_announcement_panel_message(); ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <div class="grid grid-cols-2">
                    <label for="panel_link"><?php echo __('General:Link'); ?></label>
                    <input id="panel_link" name="panel_link" type="text" maxlength="255" value="<?php echo get_announcement_panel_link(); ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <br>
                <div class="grid grid-cols-2">
                    <label for="panel_type"><?php echo __('Admin:Announcements_Style'); ?></label>
                    <select id="panel_type" name="panel_type" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="NOTIFICATION"<?php if (get_announcement_panel_type() == 'NOTIFICATION') {
                    echo ' selected';
                } ?>><?php echo __('General:Notification'); ?> (<?php echo __('General:Default'); ?>)</option>
                        <option value="INFO"<?php if (get_announcement_panel_type() == 'INFO') {
                    echo ' selected';
                } ?>><?php echo __('General:Information'); ?></option>
                        <option value="SUCCESS"<?php if (get_announcement_panel_type() == 'SUCCESS') {
                    echo ' selected';
                } ?>><?php echo __('General:Success'); ?></option>
                        <option value="WARNING"<?php if (get_announcement_panel_type() == 'WARNING') {
                    echo ' selected';
                } ?>><?php echo __('General:Warning'); ?></option>
                        <option value="ERROR"<?php if (get_announcement_panel_type() == 'ERROR') {
                    echo ' selected';
                } ?>><?php echo __('General:Error'); ?></option>
                    </select>
                </div>
            </div>
            <input type="submit" name="save" value="<?php echo __('General:Save'); ?>" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
            <h2 class="text-gray-900 text-2xl mt-8"><?php echo __('Admin:Announcements_Website'); ?></h2>
            <div class="my-6">
            <?php
                if (get_announcement_website_active()) {
                    if (get_announcement_website_link() != null && get_announcement_website_link() != '') {
                        echo alert(get_announcement_website_type(), '<span class="underline">'.get_announcement_website_title().':</span> '.get_announcement_website_message().' - For more information <a href="'.get_announcement_website_link().'" class="underline">please click here</a>.', true);
                    } else {
                        echo alert(get_announcement_website_type(), '<span class="underline">'.get_announcement_website_title().':</span> '.get_announcement_website_message(), true);
                    }
                }
            ?>
            </div>
            <div class="mb-6">
                <div class="grid grid-cols-2">
                    <label for="website_active"><?php echo __('General:Active'); ?></label>
                    <select id="website_active" name="website_active" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="1"<?php if (get_announcement_website_active()) {
                echo ' selected';
            } ?>><?php echo __('General:Active'); ?> (<?php echo __('Admin:Announcements_Show'); ?>)</option>
                        <option value="0"<?php if (!get_announcement_website_active()) {
                echo ' selected';
            } ?>><?php echo __('General:Inactive'); ?> (<?php echo __('Admin:Announcements_Hide'); ?>)</option>
                    </select>
                </div>
                <br>
                <div class="grid grid-cols-2">
                    <label for="website_title"><?php echo __('General:Title'); ?></label>
                    <input id="website_title" name="website_title" type="text" maxlength="50" value="<?php echo get_announcement_website_title(); ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <div class="grid grid-cols-2">
                    <label for="website_message"><?php echo __('General:Message'); ?></label>
                    <input id="website_message" name="website_message" type="text" maxlength="255" value="<?php echo get_announcement_website_message(); ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <div class="grid grid-cols-2">
                    <label for="website_link"><?php echo __('General:Link'); ?></label>
                    <input id="website_link" name="website_link" type="text" maxlength="255" value="<?php echo get_announcement_website_link(); ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                </div>
                <br>
                <div class="grid grid-cols-2">
                    <label for="website_type"><?php echo __('Admin:Announcements_Style'); ?></label>
                    <select id="website_type" name="website_type" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:border-<?php echo THEME_PANEL_COLOUR; ?>-500 focus:z-10 sm:text-sm">
                        <option value="NOTIFICATION"<?php if (get_announcement_website_type() == 'NOTIFICATION') {
                echo ' selected';
            } ?>><?php echo __('General:Notification'); ?> (<?php echo __('General:Default'); ?>)</option>
                        <option value="INFO"<?php if (get_announcement_website_type() == 'INFO') {
                echo ' selected';
            } ?>><?php echo __('General:Information'); ?></option>
                        <option value="SUCCESS"<?php if (get_announcement_website_type() == 'SUCCESS') {
                echo ' selected';
            } ?>><?php echo __('General:Success'); ?></option>
                        <option value="WARNING"<?php if (get_announcement_website_type() == 'WARNING') {
                echo ' selected';
            } ?>><?php echo __('General:Warning'); ?></option>
                        <option value="ERROR"<?php if (get_announcement_website_type() == 'ERROR') {
                echo ' selected';
            } ?>><?php echo __('General:Error'); ?></option>
                    </select>
                </div>
            </div>
            <input type="submit" name="save" value="<?php echo __('General:Save'); ?>" class="hover:shadow-lg cursor-pointer group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php echo THEME_PANEL_COLOUR; ?>-500 transition-all duration-200">
        </form>
    </body>
</html>