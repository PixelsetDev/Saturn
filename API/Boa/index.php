<?php

/**
 * Boa Demo Application
 * @author      Lewis Milburn <contact@lewismilburn.com>
 * @license     Apache-2.0 License
 */

require __DIR__ . '/Boa.php';
$Boa = new Boa\App();
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Boa</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/solid.min.css" integrity="sha512-6/gTF62BJ06BajySRzTm7i8N2ZZ6StspU9uVWDdoBiuuNu5rs1a8VwiJ7skCz2BcvhpipLKfFerXkuzs+npeKA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <div class="w-full p-12">
            <h1 class="text-4xl font-bold w-full text-center">Welcome to Boa!</h1>
            <p class="w-full text-center">The simple, fast and reliable PHP Framework.</p>
        </div>
        <?php if ($Boa->UpdateCheck()) { ?>
        <div class="w-full p-12">
            <h1 class="text-2xl font-bold">Update</h1>
            <p class="w-full">A new version of Boa is available to download.</p>
        </div>
        <?php } ?>
        <div class="w-full p-12">
            <h1 class="text-2xl font-bold">Installed Modules</h1>
            <p>Here's a list of all the installed modules in Boa. You can deactivate modules if you don't need them or delete them if you'd prefer, but don't forget to remove them from modules.json.</p>
            <?php
                $modules = $Boa->Modules();
                foreach ($modules as $module) {
                    if ($module->enabled == 'true')
                    {
                        echo '<span class="font-medium">' . $module->module . '</span> is <span class="text-green-500">activated</span>. <span class="text-gray-500 italic">You can use this module on this page.</span><br>';
                    } else {
                        echo '<span class="font-medium">' . $module->module . '</span> is <span class="text-red-500">deactivated</span>. <span class="text-gray-500 italic">You\'ll need to activate it before you can use it here.</span><br>';
                    }
                }
            ?>
            <a href="modules.json" class="underline text-blue-500 hover:text-blue-300 transition duration-200">View modules file.</a>
        </div>
    </body>
</html>