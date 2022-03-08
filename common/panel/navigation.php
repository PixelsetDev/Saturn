<div class="w-full text-gray-100 bg-<?php echo THEME_PANEL_COLOUR; ?>-900 dark:bg-neutral-900">
            <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto lg:items-center lg:justify-between lg:flex-row lg:px-6 lg:px-8">
                <div class="p-4 flex flex-row items-center justify-between flex-none w-full lg:w-1/6">
                    <div class="flex space-x-6">
                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/panel/dashboard" title="<?php echo __('General:Saturn'); ?>" class="w-32 flex-none text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">
                            <img src="<?php echo CONFIG_INSTALL_URL; ?>/assets/panel/images/saturn.png" alt="Saturn" class="flex-none w-40 h-auto">
                        </a>
                        <a href="<?php echo CONFIG_INSTALL_URL; ?>/" title="<?php echo CONFIG_SITE_NAME; ?>" class="w-40 flex-none text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">
                            <img src="<?php echo CONFIG_INSTALL_URL; ?>/storage/images/logo.png" alt="<?php echo CONFIG_SITE_NAME; ?>" class="flex-none w-40 h-auto">
                        </a>
                    </div>
                    <div class="flex-grow">&nbsp;</div>
                    <button class="lg:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <nav :class="{'flex': open, 'hidden': !open}" class="flex-wrap flex-col flex-auto pb-2 lg:pb-0 hidden lg:flex lg:justify-end lg:flex-row" aria-label="<?php echo __('Panel:Panel'); ?> Menu">
                    <?php if (get_user_roleID($_SESSION['id']) > 2 && CONFIG_PAGE_APPROVALS) { ?>
                        <div @click.away="open = false" class="relative self-center" x-data="{ open: false }">
                            <button @click="open = !open" class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:outline-none focus:shadow-outline">
                                <div class="flex">
                                    <span><?php echo __('Panel:Pages'); ?></span>
                                    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="self-center inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                </div>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-lg shadow-lg lg:w-48 z-50">
                                <div class="px-2 py-2 bg-<?php echo THEME_PANEL_COLOUR; ?>-800 dark:bg-neutral-900 rounded-lg shadow w-60">
                                    <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages"><?php echo __('Panel:Editor'); ?></a>
                                    <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages/approvals"><?php echo __('Panel:Approvals'); ?></a>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <a class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/pages"><?php echo __('Panel:Pages'); ?></a>
                        <?php
                        }
                        if (get_user_roleID($_SESSION['id']) > 2 && CONFIG_ARTICLE_APPROVALS) {
                            ?>
                            <div @click.away="open = false" class="relative self-center" x-data="{ open: false }">
                                <button @click="open = !open" class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline">
                                    <div class="flex">
                                        <span><?php echo __('Panel:Articles'); ?></span>
                                        <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="self-center inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-lg shadow-lg lg:w-48 z-50">
                                    <div class="px-2 py-2 bg-<?php echo THEME_PANEL_COLOUR; ?>-800 dark:bg-neutral-900 rounded-lg shadow w-60">
                                        <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles"><?php echo __('Panel:Editor'); ?></a>
                                        <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles/approvals"><?php echo __('Panel:Approvals'); ?></a>
                                    </div>
                                </div>
                            </div>
                    <?php
                        } else {
                            ?>
                            <a class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/articles"><?php echo __('Panel:Articles'); ?></a>
                    <?php
                        } ?>
                    <div @click.away="open = false" class="relative self-center" x-data="{ open: false }">
                        <button @click="open = !open" class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline">
                            <div class="flex">
                                <span><?php echo __('Panel:Team'); ?></span>
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="self-center inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-lg shadow-lg lg:w-48 z-50">
                            <div class="px-2 py-2 bg-<?php echo THEME_PANEL_COLOUR; ?>-800 dark:bg-neutral-900 rounded-lg shadow w-60">
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/team"><?php echo __('Panel:TeamMembers'); ?></a>
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/team/chat"><?php echo __('Panel:TeamChat'); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php if ($_SESSION['role_id'] >= '3') { ?>
                    <a class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/files"><?php echo __('Panel:Files'); ?></a>
                    <?php } ?>
                    <div @click.away="open = false" class="relative self-center" x-data="{ open: false }">
                        <button @click="open = !open" class="self-center text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg lg:mt-0 lg:ml-4 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline">
                            <div class="flex">
                                <div class="flex"><div class="relative"><img alt="<?php echo get_user_fullname($_SESSION['id']).'" src="'.get_user_profilephoto($_SESSION['id']); ?>" class=" bg-white mx-auto object-cover rounded-full h-10 w-10 "/><?php $notifCount = get_notification_count($_SESSION['id']); if ($notifCount > 0) {
                            echo '<div class="absolute px-1 h-4 bg-red-500 rounded-full top-0 right-0 text-xs">'.$notifCount.'</div>';
                        } ?></div><span class="self-center">&nbsp;<?php echo get_user_fullname($_SESSION['id']); ?><br><span class="font-light"><?php /* echo get_user_role($_SESSION['id']); For some reason, enabling this crashes everything. */ ?></span></span></div>
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="self-center inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform lg:-mt-1"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                            </div>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-lg shadow-lg lg:w-48 z-50">
                            <div class="px-2 py-2 bg-<?php echo THEME_PANEL_COLOUR; ?>-800 dark:bg-neutral-900 rounded-lg shadow w-60">
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-t-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo get_user_profile_link($_SESSION['id']); ?>"><?php echo __('Panel:MyProfile'); ?></a>
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-none lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline- dark:hover:bg-neutral-800 dark:focus:bg-neutral-800none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/team/profile/edit"><?php echo __('Panel:AccountSettings'); ?></a>
                                <hr>
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-none lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/notifications"><?php echo __('Panel:Notifications'); ?> <span class="px-1 h-6 bg-red-500 rounded-full text-xs"><?php echo $notifCount; unset($notifCount); ?></span></a>
                                <?php
                                    if (get_user_roleID($_SESSION['id']) == '4') {
                                        ?>
                                        <hr>
                                        <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-none lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin"><?php echo __('Admin:Panel'); ?></a>
                                        <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-none lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/settings"><?php echo __('Admin:Settings_Web'); ?></a>
                                        <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-none lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/admin/user-management"><?php echo __('Admin:UserManagement'); ?></a>
                                    <?php
                                    }
                                ?>
                                <hr>
                                <a class="block text-<?php echo THEME_PANEL_COLOUR; ?>-100 px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-b-lg lg:mt-0 hover:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 focus:bg-<?php echo THEME_PANEL_COLOUR; ?>-700 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 focus:outline-none focus:shadow-outline" href="<?php echo CONFIG_INSTALL_URL; ?>/panel/account/signout"><?php echo __('Panel:SignOut'); ?></a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="flex fixed bottom-0 left-0 px-2 text-xs w-full bg-<?php echo THEME_PANEL_COLOUR; ?>-100 dark:bg-neutral-900 z-40">
            <span class="w-1/3"><?php echo __('General:Saturn'); ?> <?php echo __('Panel:Panel'); ?> &copy; 2021 - <?php echo date('Y'); ?> <?php echo __('General:SaturnCMS'); ?></span>
            <span class="w-1/3 text-center font-bold"><?php echo __('Panel:BugFree_Message'); ?> <a href="https://saturncms.net/feedback" target="_blank" class="font-normal underline text-black dark:text-white text-black" rel="nofollow noopener"><?php echo __('Panel:BugFree_Contact'); ?></a></span>
            <span class="w-1/3 text-right"><?php echo SATURN_VERSION; ?></span>
        </div>