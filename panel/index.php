<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Saturn Panel</title>
        <?php
            include_once __DIR__.'/../assets/common/global_public.php';
            include_once __DIR__.'/../assets/common/panel/vendors.php';
            include_once __DIR__.'/../assets/common/panel/theme.php';
        ?>

    </head>
    <body>
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold leading-tight text-<?php echo THEME_PANEL_COLOUR; ?>-500"><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel">Saturn Panel</a></h1>
            </div>
        </header>
        <main>
            <div class="relative bg-<?php echo THEME_PANEL_COLOUR; ?>-500 h-full">
                <img src="<?php echo THEME_PANEL_BACKGROUND_IMAGE; ?>" class="object-cover absolute inset-0 object-cover w-full h-full" alt="" />
                <div class="relative bg-gray-900 bg-opacity-75">
                    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
                        <div class="flex flex-col items-center justify-between xl:flex-row">
                            <div class="w-full max-w-xl mb-12 xl:mb-0 xl:pr-16 xl:w-7/12">
                                <h2 class="max-w-lg mb-6 text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
                                    Welcome to <?php echo CONFIG_SITE_NAME; ?>'s<br class="hidden md:block" />
                                    Saturn CMS Panel
                                </h2>
                                <p class="max-w-xl mb-4 text-base text-gray-400 md:text-lg">
                                    <?php echo CONFIG_SITE_DESCRIPTION; ?>
                                </p>
                                <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/register" aria-label="" class="inline-flex items-center font-semibold tracking-wider transition-colors duration-200 text-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400">
                                    Register
                                    <svg class="inline-block w-3 ml-2" fill="currentColor" viewBox="0 0 12 12">
                                        <path d="M9.707,5.293l-5-5A1,1,0,0,0,3.293,1.707L7.586,6,3.293,10.293a1,1,0,1,0,1.414,1.414l5-5A1,1,0,0,0,9.707,5.293Z"></path>
                                    </svg>
                                </a>
                            </div>
                            <div class="w-full max-w-xl xl:px-8 xl:w-5/12">
                                <div class="bg-white rounded shadow-2xl p-7 sm:p-10">
                                    <h3 class="mb-4 text-xl font-semibold sm:text-center sm:mb-6 sm:text-2xl">
                                        Sign in to Saturn
                                    </h3>
                                    <form method="post" action="account/signin/?login=true">
                                        <div class="mb-1 sm:mb-2">
                                            <label for="email" class="inline-block mb-1 font-medium">Username or Email Address</label>
                                            <input
                                                    placeholder="me@example.com"
                                                    required=""
                                                    type="username"
                                                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                                    id="username"
                                                    name="username"
                                            />
                                        </div>
                                        <div class="mb-1 sm:mb-2">
                                            <label for="password" class="inline-block mb-1 font-medium">Password</label>
                                            <input
                                                    placeholder="********"
                                                    required=""
                                                    type="password"
                                                    class="flex-grow w-full h-12 px-4 mb-2 transition duration-200 bg-white border border-gray-300 rounded shadow-sm appearance-none focus:border-deep-purple-accent-400 focus:outline-none focus:shadow-outline"
                                                    id="password"
                                                    name="password"
                                            />
                                        </div>
                                        <div class="mt-4 mb-2 sm:mb-4">
                                            <button
                                                    type="submit" name="login"
                                                    class="hover:shadow-lg inline-flex items-center justify-center w-full h-12 px-6 font-medium tracking-wide text-white transition-all duration-200 rounded shadow-md bg-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-400 focus:shadow-outline focus:outline-none"
                                            >
                                                Sign in
                                            </button>
                                        </div>
                                        <p class="text-xs text-gray-600 sm:text-sm">
                                            <a href="account/signin/forgot-password" class="text-<?php echo THEME_PANEL_COLOUR; ?>-300 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-200">Forgot password</a>.
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-20 py-14">
                <h2 class="mb-6 text-3xl font-bold tracking-tight text-<?php echo THEME_PANEL_COLOUR; ?>-700 sm:text-4xl sm:leading-none">
                    About <?php echo CONFIG_SITE_NAME; ?>.
                </h2>
                <p class="text-<?php echo THEME_PANEL_COLOUR; ?>-500">
                    <?php echo CONFIG_SITE_DESCRIPTION; ?>
                </p>
            </div>
        </main>
    </body>
</html>