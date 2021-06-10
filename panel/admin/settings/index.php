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

        <div class="px-8 py-4 w-full">
            <div class="grid grid-cols-2">
                <h1 class="text-gray-900 text-3xl">Settings</h1>
                <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-save" aria-hidden="true"></i>
                    </span>
                    Save
                </button>
            </div>
            <form class="mt-8 space-y-6 w-full" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">General</h2>
                    <div class="grid grid-cols-2">
                        <label for="site_name">Site Name</label>
                        <input id="site_name" name="site_name" type="text" value="<?php echo CONFIG_SITE_NAME; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_description">Site Description</label>
                        <input id="site_description" name="site_description" type="text" value="<?php echo CONFIG_SITE_DESCRIPTION; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_keywords">Site Keywords</label>
                        <input id="site_keywords" name="site_keywords" type="text" value="<?php echo CONFIG_SITE_KEYWORDS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_charset">Site Charset</label>
                        <select id="site_charset" name="site_charset" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option disabled>UTF</option>
                            <option value="utf-8">UTF-8</option>
                            <option value="utf-8" selected>UTF-8 (utf8mb4) (Recommended)</option>
                            <option value="utf-16">UTF-16</option>
                            <option value="utf-32">UTF-32</option>
                            <option disabled>Others</option>
                            <option value="ascii">US ASCII</option>
                            <option value="unicode">Unicode (ucs2)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="site_timezone">Site Timezone</label>
                        <select id="site_timezone" name="site_timezone" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option selected>Europe/London</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Database</h2>
                    <div class="grid grid-cols-2">
                        <label for="database_host">Database Host</label>
                        <input id="database_host" name="database_host" type="text" value="<?php echo DATABASE_HOST; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_username">Database Username</label>
                        <input id="database_username" name="database_username" type="text" value="<?php echo DATABASE_USERNAME; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_password">Database Password</label>
                        <input id="database_password" name="database_password" type="text" value="<?php echo DATABASE_PASSWORD; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_port">Database Port</label>
                        <input id="database_port" name="database_port" type="text" value="<?php echo DATABASE_PORT; ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="database_prefix">Database Prefix</label>
                        <input id="database_prefix" name="database_prefix" type="text" value="<?php echo DATABASE_PREFIX; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Email</h2>
                    <div class="grid grid-cols-2">
                        <label for="email_admin">Administrator's Email</label>
                        <input id="email_admin" name="email_admin" type="text" value="<?php echo CONFIG_EMAIL_ADMIN; ?>" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_function">Email Function</label>
                        <select id="email_function" name="email_function" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="phpmail" selected>phpmail (Recommended)</option>
                            <option disabled>SMTP (Coming Soon)</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="email_sendfrom">Email Sendfrom</label>
                        <input id="email_sendfrom" name="email_sendfrom" type="text" value="<?php echo CONFIG_EMAIL_SENDFROM; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Pages and Articles</h2>
                    <div class="grid grid-cols-2">
                        <label for="page_approvals">Page Approvals</label>
                        <select id="page_approvals" name="page_approvals" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_PAGE_APPROVALS){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_PAGE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals">Article Approvals</label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_title_chars">Maximum Title Length</label>
                        <input id="max_title_chars" name="max_title_chars" type="number" value="<?php echo CONFIG_MAX_TITLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_page_chars">Maximum Page Content Length</label>
                        <input id="max_page_chars" name="max_page_chars" type="number" value="<?php echo CONFIG_MAX_PAGE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_article_chars">Maximum Article Content Length</label>
                        <input id="max_article_chars" name="max_article_chars" type="number" value="<?php echo CONFIG_MAX_ARTICLE_CHARS; ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="max_references_chars">Maximum References Length</label>
                        <input id="max_references_chars" name="max_references_chars" type="number" value="<?php echo CONFIG_MAX_REFERENCES_CHARS; ?>" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Security System</h2>
                    <div class="grid grid-cols-2">
                        <label for="security_active">Security Active</label>
                        <select id="security_active" name="security_active" required class="appearance-none rounded-t-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(SECURITY_ACTIVE){echo' selected';} ?>>True (Recommended)</option>
                            <option value="false"<?php if(!SECURITY_ACTIVE){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="article_approvals">Logging Active</label>
                        <select id="article_approvals" name="article_approvals" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>True (Recommended)</option>
                            <option value="false"<?php if(!CONFIG_ARTICLE_APPROVALS){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2">
                        <label for="security_mode">Security Mode</label>
                        <select id="security_mode" name="security_mode" required class="appearance-none rounded-b-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="clean"<?php if(SECURITY_MODE == 'clean'){echo' selected';} ?>>Clean (Recommended)</option>
                            <option value="halt"<?php if(SECURITY_MODE == 'halt'){echo' selected';} ?>>Halt</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <h2 class="text-gray-900 text-2xl pb-4 mb-1">Developer Tools</h2>
                    <div class="grid grid-cols-2">
                        <label for="debug">Debug Mode</label>
                        <select id="debug" name="debug" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                            <option value="true"<?php if(CONFIG_DEBUG){echo' selected';} ?>>True</option>
                            <option value="false"<?php if(!CONFIG_DEBUG){echo' selected';} ?>>False</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2">
                    <div></div>
                    <button type="submit" name="login" class="hover:shadow-lg group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-<?php echo THEME_PANEL_COLOUR; ?>-700 bg-<?php echo THEME_PANEL_COLOUR; ?>-100 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-save" aria-hidden="true"></i>
                        </span>
                        Save
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>