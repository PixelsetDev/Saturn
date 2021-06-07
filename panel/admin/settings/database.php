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
            <h2 class="text-gray-900 text-2xl pb-4">Database</h2>
            <div class="relative">
                <table class="invisible md:visible" aria-describedby="Database Settings">
                    <tr>
                        <th scope="col">Config</th>
                        <th scope="col">Value</th>
                        <th scope="col">Description</th>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_HOST" class="self-center">Host</label></td>
                        <td><textarea rows="1" id="DATABASE_HOST" name="DATABASE_HOST" class="w-80"><?php echo DATABASE_HOST; ?></textarea></td>
                        <td class="text-xs">Default: localhost</td>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_PORT" class="self-center">Port</label></td>
                        <td><textarea rows="1" id="DATABASE_PORT" name="DATABASE_PORT" class="w-80"><?php echo DATABASE_PORT; ?></textarea></td>
                        <td class="text-xs">Default: 3306</td>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_NAME" class="self-center">Name</label></td>
                        <td><textarea rows="1" id="DATABASE_NAME" name="DATABASE_NAME" class="w-80"><?php echo DATABASE_NAME; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_USERNAME" class="self-center">Username</label></td>
                        <td><textarea rows="1" id="DATABASE_USERNAME" name="DATABASE_USERNAME" class="w-80"><?php echo DATABASE_USERNAME; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_PASSWORD" class="self-center">Password</label></td>
                        <td><textarea rows="1" id="DATABASE_PASSWORD" name="DATABASE_PASSWORD" class="w-80"><?php echo DATABASE_PASSWORD; ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="DATABASE_PREFIX" class="self-center">Character Set</label></td>
                        <td><textarea rows="1" id="DATABASE_PREFIX" name="DATABASE_PREFIX" class="w-80"><?php echo DATABASE_PREFIX; ?></textarea></td>
                        <td class="text-xs">Default: sat_</td>
                    </tr>
                </table>
                <div class="visible md:invisible absolute top-0">
                    <span><label for="DATABASE_HOST" class="self-center">Host</label></span>
                    <span><textarea rows="1" id="DATABASE_HOST" name="DATABASE_HOST" class="w-80"><?php echo DATABASE_HOST; ?></textarea></span>
                    <span class="text-xs">Default: localhost</span>
                    <br><br>
                    <span><label for="DATABASE_PORT" class="self-center">Port</label></span>
                    <span><textarea rows="1" id="DATABASE_PORT" name="DATABASE_PORT" class="w-80"><?php echo DATABASE_PORT; ?></textarea></span>
                    <span class="text-xs">Default: 3306</span>
                    <br><br>
                    <span><label for="DATABASE_NAME" class="self-center">Name</label></span>
                    <span><textarea rows="1" id="DATABASE_NAME" name="DATABASE_NAME" class="w-80"><?php echo DATABASE_NAME; ?></textarea></span>
                    <br><br>
                    <span><label for="DATABASE_USERNAME" class="self-center">Username</label></span>
                    <span><textarea rows="1" id="DATABASE_USERNAME" name="DATABASE_USERNAME" class="w-80"><?php echo DATABASE_USERNAME; ?></textarea></span>
                    <br><br>
                    <span><label for="DATABASE_PASSWORD" class="self-center">Password</label></span>
                    <span><textarea rows="1" id="DATABASE_PASSWORD" name="DATABASE_PASSWORD" class="w-80"><?php echo DATABASE_PASSWORD; ?></textarea></span>
                    <br><br>
                    <span><label for="DATABASE_PREFIX" class="self-center">Character Set</label></span>
                    <span><textarea rows="1" id="DATABASE_PREFIX" name="DATABASE_PREFIX" class="w-80"><?php echo DATABASE_PREFIX; ?></textarea></span>
                </div>
            </div>
        </div>
    </body>
</html>