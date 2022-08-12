<?php
use Saturn\ClientKit\Translate;

$TL = new Translate();
?><!DOCTYPE html>
<html lang="<?= PANEL_LANGUAGE; ?>" class="min-h-full">
    <head>
        <?php require_once __DIR__.'/../Vendors.inc'; ?>

        <title><?= $TL->TL('SignIn'); ?> - <?= WEBSITE_NAME; ?></title>
        <?php global $Plugins; $Plugins->ExecuteHook('PANEL_HEAD_END'); ?>

    </head>
    <body class="dark:bg-black dark:text-white w-full h-full">
        <?php require_once __DIR__ . '/../Header.inc'; ?>

        <div class="flex md:flex-row flex-col w-full h-full">
            <?php require_once __DIR__ . '/../Sidebar.inc'; ?>

            <div class="h-full w-full py-8 px-10">
                <h1 class="text-3xl font-bold mb-7"><?= $TL->TL('Pages'); ?></h1>

                <div class="p-2 my-1 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">Homepage</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">About us</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 ml-8 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">History</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 ml-8 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">Our people</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">Our work</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 ml-8 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">Saturn CMS</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 ml-8 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">WhatAccomm.com</p>
                    <div class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white">
                        <i class="fas fa-triangle-exclamation" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap hidden sm:block">Page Empty</span>
                    </div>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>

                <div class="p-2 my-1 ml-8 bg-neutral-100 dark:bg-neutral-900 flex space-x-1 md:space-x-4 md:text-lg">
                    <p class="flex-grow self-center">Boa Framework</p>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-pencil" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Edit</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fas fa-trash-can" aria-hidden="true"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Delete</span>
                    </a>
                    <a href="#" class="flex items-center px-2 py-1 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-200 dark:hover:bg-neutral-800">
                        <i class="fa-solid fa-arrows-up-down-left-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>