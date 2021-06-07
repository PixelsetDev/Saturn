<?php
session_start();

require_once __DIR__.'/../../../assets/common/global_private.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <?php include __DIR__ . '/../../../assets/common/panel/vendors.php'; ?>

        <title><?php echo CONFIG_SITE_NAME.' Admin Panel'; ?></title>
        <?php require __DIR__.'/../../../assets/common/panel/theme.php'; ?>

    </head>
    <body class="bg-gray-200">
        <?php require __DIR__.'/../../../assets/common/admin/navigation.php'; ?>

            <div class="px-8 py-4">
                <h1 class="text-gray-900 text-3xl">Settings</h1>
                <h2 class="text-gray-900 text-2xl pb-4">General</h2>
                <div class="relative">
                    <table class="invisible md:visible">
                        <tr>
                            <th scope="col">Config</th>
                            <th scope="col">Value</th>
                            <th scope="col">Description</th>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_INSTALL_URL" class="self-center">Install URL</label></td>
                            <td><textarea rows="1" id="CONFIG_INSTALL_URL" name="CONFIG_INSTALL_URL" class="w-80"><?php echo CONFIG_INSTALL_URL; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SITE_NAME" class="self-center">Site Name</label></td>
                            <td><textarea rows="1" id="CONFIG_SITE_NAME" name="CONFIG_SITE_NAME" class="w-80"><?php echo CONFIG_SITE_NAME; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SITE_DESCRIPTION" class="self-center">Site Description</label></td>
                            <td><textarea rows="1" id="CONFIG_SITE_DESCRIPTION" name="CONFIG_SITE_DESCRIPTION" class="w-80"><?php echo CONFIG_SITE_DESCRIPTION; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SITE_KEYWORDS" class="self-center">Site Keywords</label></td>
                            <td><textarea rows="1" id="CONFIG_SITE_KEYWORDS" name="CONFIG_SITE_KEYWORDS" class="w-80"><?php echo CONFIG_SITE_KEYWORDS; ?></textarea></td>
                            <td class="text-xs">Keywords used by search engines, must be comma separated.</td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SITE_CHARSET" class="self-center">Site Charset</label></td>
                            <td><textarea rows="1" id="CONFIG_SITE_CHARSET" name="CONFIG_SITE_CHARSET" class="w-80"><?php echo CONFIG_SITE_CHARSET; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SITE_TIMEZONE" class="self-center">Site Timezone</label></td>
                            <td><textarea rows="1" id="CONFIG_SITE_TIMEZONE" name="CONFIG_SITE_TIMEZONE" class="w-80"><?php echo CONFIG_SITE_TIMEZONE; ?></textarea></td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_ADMIN_EMAIL" class="self-center">Admin Email</label></td>
                            <td><textarea rows="1" id="CONFIG_ADMIN_EMAIL" name="CONFIG_ADMIN_EMAIL" class="w-80"><?php echo CONFIG_EMAIL_ADMIN; ?></textarea></td>
                            <td class="text-xs">The site administrator / owner's email address.</td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_SENDFROM_EMAIL" class="self-center">Send From Email</label></td>
                            <td><textarea rows="1" id="CONFIG_SENDFROM_EMAIL" name="CONFIG_SENDFROM_EMAIL" class="w-80"><?php echo CONFIG_EMAIL_SENDFROM; ?></textarea></td>
                            <td class="text-xs">This is the email address that emails will be sent from. We recommend using a noreply address (noreply@example.com).</td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_CHARSET" class="self-center">Character Set</label></td>
                            <td><textarea rows="1" id="CONFIG_CHARSET" name="CONFIG_CHARSET" class="w-80"><?php echo CONFIG_SITE_CHARSET; ?></textarea></td>
                            <td class="text-xs">Recommended: UTF-8.</td>
                        </tr>
                        <tr>
                            <td><label for="CONFIG_INSTALL_URL" class="self-center">Installation URL</label></td>
                            <td><textarea rows="1" id="CONFIG_INSTALL_URL" name="CONFIG_INSTALL_URL" class="w-80"><?php echo CONFIG_INSTALL_URL; ?></textarea></td>
                            <td class="text-xs">Where SiteKit is installed. Must begin with a '/' (eg. /mysite).</td>
                        </tr>
                    </table>
                    <div class="visible md:invisible absolute top-0">
                        <span><label for="CONFIG_SITE_NAME" class="self-center">Site Name</label></span>
                        <span><textarea rows="1" id="CONFIG_SITE_NAME" name="CONFIG_SITE_NAME" class="w-80"><?php echo CONFIG_SITE_NAME; ?></textarea></span>
                        <br><br>
                        <span><label for="CONFIG_SITE_DESCRIPTION" class="self-center">Site Description</label></span>
                        <span><textarea rows="1" id="CONFIG_SITE_DESCRIPTION" name="CONFIG_SITE_DESCRIPTION" class="w-80"><?php echo CONFIG_SITE_DESCRIPTION; ?></textarea></span>
                        <br><br>
                        <span><label for="CONFIG_SITE_KEYWORDS" class="self-center">Site Keywords</label></span>
                        <span><textarea rows="1" id="CONFIG_SITE_KEYWORDS" name="CONFIG_SITE_KEYWORDS" class="w-80"><?php echo CONFIG_SITE_KEYWORDS; ?></textarea></span>
                        <span class="text-xs">Keywords used by search engines, must be comma separated.</span>
                        <br><br>
                        <span><label for="CONFIG_ADMIN_EMAIL" class="self-center">Admin Email</label></span>
                        <span><textarea rows="1" id="CONFIG_ADMIN_EMAIL" name="CONFIG_ADMIN_EMAIL" class="w-80"><?php echo CONFIG_ADMIN_EMAIL; ?></textarea></span>
                        <span class="text-xs">The site administrator / owner's email address.</span>
                        <br><br>
                        <span><label for="CONFIG_SENDFROM_EMAIL" class="self-center">Send From Email</label></span>
                        <span><textarea rows="1" id="CONFIG_SENDFROM_EMAIL" name="CONFIG_SENDFROM_EMAIL" class="w-80"><?php echo CONFIG_SENDFROM_EMAIL; ?></textarea></span>
                        <span class="text-xs">This is the email address that emails will be sent from. We recommend using a noreply address (noreply@example.com).</span>
                        <br><br>
                        <span><label for="CONFIG_CHARSET" class="self-center">Character Set</label></span>
                        <span><textarea rows="1" id="CONFIG_CHARSET" name="CONFIG_CHARSET" class="w-80"><?php echo CONFIG_CHARSET; ?></textarea></span>
                        <span class="text-xs">Recommended: UTF-8.</span>
                        <br><br>
                        <span><label for="CONFIG_INSTALL_URL" class="self-center">Installation URL</label></span>
                        <span><textarea rows="1" id="CONFIG_INSTALL_URL" name="CONFIG_INSTALL_URL" class="w-80"><?php echo CONFIG_INSTALL_URL; ?></textarea></span>
                        <span class="text-xs">Where SiteKit is installed. Must begin with a '/' (eg. /mysite).</span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>