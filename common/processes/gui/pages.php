<?php

function display_page_new_form($category): string
{
    return '<form action="'.CONFIG_INSTALL_URL.'/panel/pages/new" name="newpage" method="GET">
                                                                    <div class="w-full font-semibold inline-block py-2 px-3 uppercase rounded text-gray-900 dark:bg-neutral-800 dark:text-white bg-gray-100">
                                                                        <div class="flex w-full relative space-x-3">
                                                                            <div class="flex-grow">
                                                                                <label for="pagetitle" class="sr-only">Page Name</label>
                                                                                <input id="pagetitle" name="pagetitle" type="text" maxlength="100" required class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-600 dark:text-white dark:border-blue-900 px-3 py-2 rounded-md w-full" placeholder="Page Title">
                                                                            </div>
                                                                            <div class="flex-grow hidden">
                                                                                <label for="pagecategory" class="sr-only">Category</label>
                                                                                <input id="pagecategory" name="pagecategory" type="text" value="'.$category.'" maxlength="100" required class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-600 dark:text-white dark:border-blue-900 px-3 py-2 rounded-md w-full" placeholder="Page Category">
                                                                            </div>
                                                                            <div><input type="submit" name="create" id="create" value="CREATE NEW" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-700 dark:hover:bg-neutral-600 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full"></div>
                                                                        </div>
                                                                    </div>
                                                                </form>';
}
function display_category_new_form(): string
{
    return '<form action="'.CONFIG_INSTALL_URL.'/panel/pages/new" name="newcategory" method="GET">
                                                                    <div class="w-full font-semibold inline-block rounded text-gray-900 dark:text-white">
                                                                        <div class="flex w-full relative space-x-3">
                                                                            <div class="flex-grow">
                                                                                <label for="categorytitle" class="sr-only">Category Name</label>
                                                                                <input id="categorytitle" name="categorytitle" type="text" maxlength="100" required class="border-b-2 border-blue-500 bg-gray-50 dark:bg-neutral-600 dark:text-white dark:border-blue-900 px-3 py-2 rounded-md w-full" placeholder="Category Name">
                                                                            </div>
                                                                            <div><input type="submit" name="createCategory" id="createCategory" value="Create New" class="hover:shadow-lg cursor-pointer w-full flex items-center justify-center px-8 py-1 border border-transparent text-base font-medium rounded-md text-'.THEME_PANEL_COLOUR.'-700 dark:text-white bg-'.THEME_PANEL_COLOUR.'-200 dark:bg-neutral-600 dark:hover:bg-neutral-500 hover:bg-'.THEME_PANEL_COLOUR.'-300 transition-all duration-200 md:py-1 md:text-rg md:px-10 h-full"></div>
                                                                        </div>
                                                                    </div>
                                                                </form>';
}
