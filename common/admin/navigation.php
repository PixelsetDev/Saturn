<nav class="bg-<?php echo THEME_PANEL_COLOUR; ?>-900 shadow-xl z-40" aria-label="Saturn Admin Panel Menu">
            <div class="px-4 py-5 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
                <div class="relative flex items-center justify-between">
                    <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin" aria-label="Saturn" title="Saturn" class="inline-flex items-center">
                        <span class="ml-2 text-xl font-bold transition-colors duration-200 tracking-wide text-<?php echo THEME_PANEL_COLOUR; ?>-300 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400"><?php echo CONFIG_SITE_NAME; ?> Admin Panel</span>
                    </a>
                    <ul class="flex items-center hidden space-x-8 lg:flex">
                        <li><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/dashboard" aria-label="Switch to Edit Mode" title="Switch to Edit Mode" class="font-medium tracking-wide text-gray-200 transition-colors duration-200 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400">Exit to Control Panel</a></li>
                        <li><a href="<?php echo CONFIG_INSTALL_URL; ?>/" aria-label="Exit" title="Exit" class="font-medium tracking-wide text-gray-200 transition-colors duration-200 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400">Exit to Website</a></li>
                    </ul>
                    <!-- Mobile menu -->
                    <div class="lg:hidden" x-data="{ open: false }">
                        <button @click="open = true" aria-label="Open Menu" title="Open Menu" class="p-2 -mr-1 transition duration-200 rounded focus:outline-none focus:shadow-outline hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-50 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-50">
                            <svg class="w-5 text-<?php echo THEME_PANEL_COLOUR; ?>-600" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M23,13H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,13,23,13z"></path>
                                <path fill="currentColor" d="M23,6H1C0.4,6,0,5.6,0,5s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,6,23,6z"></path>
                                <path fill="currentColor" d="M23,20H1c-0.6,0-1-0.4-1-1s0.4-1,1-1h22c0.6,0,1,0.4,1,1S23.6,20,23,20z"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" class="z-50 absolute top-0 left-0 w-full">
                            <div class="p-5 bg-<?php echo THEME_PANEL_COLOUR; ?>-900 border rounded shadow-sm">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin" aria-label="Title" title="Title" class="inline-flex items-center">
                                            <span class="ml-2 text-xl font-bold tracking-wide text-gray-800 text-<?php echo THEME_PANEL_COLOUR; ?>-500 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400"><?php echo CONFIG_SITE_NAME; ?> Admin Panel</span>
                                        </a>
                                    </div>
                                <div>
                                    <button @click="open = false" aria-label="Close Menu" title="Close Menu" class="p-2 -mt-2 -mr-2 transition duration-200 rounded hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                        <svg class="w-5 text-gray-600" viewBox="0 0 24 24">
                                            <path
                                                fill="currentColor"
                                                d="M19.7,4.3c-0.4-0.4-1-0.4-1.4,0L12,10.6L5.7,4.3c-0.4-0.4-1-0.4-1.4,0s-0.4,1,0,1.4l6.3,6.3l-6.3,6.3 c-0.4,0.4-0.4,1,0,1.4C4.5,19.9,4.7,20,5,20s0.5-0.1,0.7-0.3l6.3-6.3l6.3,6.3c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3 c0.4-0.4,0.4-1,0-1.4L13.4,12l6.3-6.3C20.1,5.3,20.1,4.7,19.7,4.3z"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <nav aria-label="Saturn Admin Panel Mobile Menu">
                                <ul class="space-y-4">
                                    <li><a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/dashboard" aria-label="Switch to Edit Mode" title="Switch to Edit Mode" class="font-medium tracking-wide text-gray-200 transition-colors duration-200 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400">Exit to Dashboard</a></li>
                                    <li><a href="<?php echo CONFIG_INSTALL_URL; ?>" aria-label="Exit" title="Exit" class="font-medium tracking-wide text-gray-200 transition-colors duration-200 hover:text-<?php echo THEME_PANEL_COLOUR; ?>-400">Exit to Website</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="md:relative md:flex flex-col md:flex-row md:min-h-full min-w-full bg-transparent">
            <div @click.away="open = false" class="z-20 flex flex-col w-full md:w-64 text-<?php echo THEME_PANEL_COLOUR; ?>-200 bg-<?php echo THEME_PANEL_COLOUR; ?>-800 flex-shrink-0" x-data="{ open: false }">
                <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between">
                    <a href="<?php echo CONFIG_INSTALL_URL ?>/panel/admin" class="text-lg font-semibold tracking-widest text-white rounded-lg hover:text-white focus:outline-none focus:shadow-outline">Admin Panel Menu</a>
                    <button class="rounded-lg md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto z-30" aria-label="Sidebar Menu">
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold rounded-lg bg-transparent hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin'; ?>">Dashboard</a>
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold rounded-lg bg-transparent hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/announcements'; ?>">Announcements</a>
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold rounded-lg bg-transparent hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/user-management'; ?>">User Management</a>
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold rounded-lg bg-transparent hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/themes'; ?>">Themes</a>
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left rounded-lg bg-transparent focus:text-white hover:text-white :focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 md:block focus:outline-none focus:shadow-outline">
                            <span>Security</span>
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg z-40">
                            <div class="px-2 py-2 rounded-md shadow bg-<?php echo THEME_PANEL_COLOUR; ?>-800">
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 md:mt-0 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/security'; ?>">Security Management</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 md:mt-0 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/security/log.php'; ?>">Log</a>
                            </div>
                        </div>
                    </div>
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex flex-row items-center w-full px-4 py-2 mt-2 text-sm font-semibold text-left rounded-lg bg-transparent focus:text-white hover:text-white :focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 md:block focus:outline-none focus:shadow-outline">
                            <span>Settings</span>
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg z-40">
                            <div class="px-2 py-2 rounded-md shadow bg-<?php echo THEME_PANEL_COLOUR; ?>-800">
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 md:mt-0 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/settings'; ?>">Website Settings</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 md:mt-0 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/settings/permissions'; ?>">Permissions</a>
                            </div>
                        </div>
                    </div>
                    <a class="block px-4 py-2 mt-2 text-sm font-semibold rounded-lg bg-transparent hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-600 focus:text-white hover:text-white text-<?php echo THEME_PANEL_COLOUR; ?>-200 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL.'/panel/admin/database-management'; ?>">Database Management</a>
                    <span class="fixed bottom-0 text-xs text-<?php echo THEME_PANEL_COLOUR; ?>-600">Saturn Panel &copy; 2021 - <?php echo date('Y'); ?> Saturn CMS</span>
                </nav>
            </div>