<div class="w-full md:h-full p-2 bg-neutral-200 dark:bg-neutral-800" aria-label="Sidebar">
            <div class="md:space-y-2 md:space-x-0 space-x-2 h-full flex md:flex-col">
                <div>
                    <a href="/panel" class="flex items-center p-2 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-700">
                        <svg aria-hidden="true" class="w-6 h-6 text-neutral-500 transition duration-75 dark:text-neutral-400 group-hover:text-black dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
                        <span class="ml-3"><?= $TL->TL('Dashboard'); ?></span>
                    </a>
                </div>
                <div>
                    <a href="/panel/pages" class="flex items-center p-2 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-700">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-neutral-500 transition duration-75 dark:text-neutral-400 group-hover:text-black dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 4a3 3 0 00-3 3v6a3 3 0 003 3h10a3 3 0 003-3V7a3 3 0 00-3-3H5zm-1 9v-1h5v2H5a1 1 0 01-1-1zm7 1h4a1 1 0 001-1v-1h-5v2zm0-4h5V8h-5v2zM9 8H4v2h5V8z" clip-rule="evenodd"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap"><?= $TL->TL('Pages'); ?></span>
                    </a>
                </div>
                <div>
                    <a href="#" class="flex items-center p-2 text-base font-normal text-black rounded-lg dark:text-white hover:bg-neutral-300 dark:hover:bg-neutral-700">
                        <svg aria-hidden="true" class="flex-shrink-0 w-6 h-6 text-neutral-500 transition duration-75 dark:text-neutral-400 group-hover:text-black dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>
                        <span class="flex-1 ml-3 whitespace-nowrap"><?= $TL->TL('Inbox'); ?></span>
                        <span class="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">3</span>
                    </a>
                </div>

                <?php global $Plugins; $Plugins->ExecuteHook('PANEL_SIDEBAR_END'); ?>
            </div>
        </div>